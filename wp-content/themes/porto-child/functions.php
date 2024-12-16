<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')):
    function chld_thm_cfg_locale_css($uri)
    {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

if (!function_exists('chld_thm_cfg_parent_css')):
    function chld_thm_cfg_parent_css()
    {
        wp_enqueue_style('chld_thm_cfg_parent', trailingslashit(get_template_directory_uri()) . 'style.css', array('porto-fs-progress-bar', 'porto-plugins', 'porto-theme', 'porto-theme-portfolio', 'porto-theme-member', 'porto-shortcodes', 'porto-theme-shop', 'porto-theme-elementor'));
    }
endif;
add_action('wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 1000);

// END ENQUEUE PARENT ACTION
add_action('wp_enqueue_scripts', 'tt_child_enqueue_parent_styles');
function tt_child_enqueue_parent_styles()
{
    $api_google = get_option('api_google', '');
    wp_enqueue_style('intlTelInput-css', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css', array(), time(), 'all');
    wp_enqueue_script('intlTelInput-script', 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.7/js/intlTelInput.js', array('jquery'), time(), true);
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.5.1.slim.min.js', array(), '1.0.0', true);
    wp_enqueue_script('jquery.validate.min.js', get_stylesheet_directory_uri() . '/js/jquery.validate.min.js', array(), time(), true);
    wp_enqueue_script('theme-script', get_stylesheet_directory_uri() . '/js/theme.js', array('jquery'), time(), true);
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), time(), true);

    wp_enqueue_style('custom-css', get_stylesheet_directory_uri() . '/css/custom.css', array(), time(), 'all');
    wp_enqueue_style('theme-css', get_stylesheet_directory_uri() . '/css/theme.css', array(), time(), 'all');
    wp_enqueue_style('single-custom-css', get_stylesheet_directory_uri() . '/css/single-custom.css', array(), time(), 'all');
    if (!empty($api_google)) {
        wp_enqueue_script(
            'google-maps-api',
            sprintf('https://maps.googleapis.com/maps/api/js?key=%s&libraries=places', $api_google),
            array(),
            null,
            true
        );
    }

}
add_filter('woocommerce_countries_inc_tax_or_vat', function () {
    return __('(incl. TVA)', 'woocommerce');
});

add_filter('woocommerce_checkout_fields', 'customize_checkout_fields');

add_filter('ninja_forms_i18n_front_end', 'my_custom_ninja_forms_i18n_front_end');
function my_custom_ninja_forms_i18n_front_end($strings)
{
    $strings['fieldsMarkedRequired'] = "Les champs marqués d'un <span class='red-asterisk'>*</span> sont obligatoires";
    return $strings;
}

add_filter('ninja_forms_i18n_front_end', 'my_custom_translate_nf_form_errors');
function my_custom_translate_nf_form_errors($strings)
{
    foreach ($strings as $key => $string) {
        if ($string === 'If you are a human seeing this field, please leave it empty.') {
            $strings[$key] = 'Si vous êtes un être humain et que vous voyez ce champ, veuillez le laisser vide.';
        }
    }
    return $strings;
}
// hook country


add_filter('woocommerce_countries', 'limit_country_list');
function limit_country_list($countries)
{
    return [
        'FR' => 'France',
        'BE' => 'Belgium',
        'LU' => 'Luxembourg',
    ];
}



function customize_checkout_fields($fields)
{
    foreach ($fields as $category => $category_fields) {
        foreach ($category_fields as $field_key => $field) {
            $fields[$category][$field_key]['class'][] = 'custom-required-field';
        }
    }
    return $fields;
}

add_action('woocommerce_checkout_process', 'validate_checkout_fields');

function validate_checkout_fields()
{
    if (empty($_POST['billing_first_name'])) {
        wc_add_notice(__('Ce champ ne peut pas être vide.', 'woocommerce'), 'error');
    }
}

add_filter('wc_add_to_cart_message', 'custom_add_to_cart_message', 10, 2);
function custom_add_to_cart_message($message, $product_id)
{
    $product = wc_get_product($product_id);
    return sprintf('%s a été ajouté à votre panier.', $product->get_name());
}


add_filter('woocommerce_get_price_html', 'show_price_with_and_without_tax', 20, 2);
function show_price_with_and_without_tax($price, $product)
{
    if (!$product->is_taxable()) {
        return $price;
    }

    $price_excluding_tax = wc_get_price_excluding_tax($product);
    $price_including_tax = wc_get_price_including_tax($product);

    $stock_quantity = 0;
    // $stock_quantitya = $product->get_stock_quantity();
    // var_dump($stock_quantitya);
    if ($product->is_type('variable')) {
        $variations = $product->get_children();
        foreach ($variations as $variation_id) {
            $variation = wc_get_product($variation_id);
            $variation_stock = $variation->get_stock_quantity();
            if ($variation_stock > $stock_quantity) {
                $stock_quantity = $variation_stock;
            }
        }
        $stock_status_class = '';
    } else {
        $stock_quantity = $product->get_stock_quantity();
        $stock_status_class = 'active';
    }

    $stock_text = $stock_quantity > 0
        ? $stock_quantity . '&nbsp; en stock'
        : 'Rupture de stock';
    $new_price = sprintf(
        '<p class="inclu_tax">À partir de %s <span class="ttc_tax aa">TTC</span></p>
        <p class="exclu_tax">soit <span class="ht_tax">%s</span> HT</p>
        <p class="stock_status %s">%s</p>',
        wc_price($price_including_tax),
        wc_price($price_excluding_tax),
        esc_attr($stock_status_class),
        esc_html($stock_text)
    );

    return $new_price;
}
function get_name_cons_fields_html()
{
    ob_start();
    ?>

    <div class="pcf-container">
        <div class="pcf-field-container">
            <label for="name">Nom<span class="required">*</span></label>
            <input id="name" name="name" type="text" class="cr-review-form-textbox" required autocomplete="name">
        </div>

        <div class="pcf-field-container">
            <label for="email">Email<span class="required">*</span></label>
            <input id="email" name="email" type="email" class="cr-review-form-textbox" required autocomplete="email">
        </div>

        <div class="pcf-field-container checkbox-save_infor">
            <input id="save_infor" name="save_infor" type="checkbox" class="cr-review-form-checkbox">
            <label for="save_infor">Enregistrer mon nom, mon e-mail et mon site web dans le navigateur pour mon prochain
                commentaire.</label>
        </div>
    </div>

    <?php
    return ob_get_clean();
}



add_filter('comment_form_field_comment', 'render_name_cons_fields', 99, 1);
function render_name_cons_fields($comment_field)
{
    if (!is_product()) {
        return $comment_field;
    }

    return $comment_field . get_name_cons_fields_html();
}

add_action('comment_post', 'save_review_name_and_cons', 10, 3);
function save_review_name_and_cons($comment_id, $approved, $commentdata)
{

    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Spammers and hackers love to use comments to do XSS attacks.
    // Don't forget to escape the variables
    update_comment_meta($comment_id, 'name', esc_html($name));
    update_comment_meta($comment_id, 'email', esc_html($email));
}


add_action('add_meta_boxes_comment', 'extend_comment_add_meta_box', 10, 1);
function extend_comment_add_meta_box($comment)
{
    // We don't need to show this metabox if a comment doesn't belong to a product
    $post_id = $comment->comment_post_ID;
    $product = wc_get_product($post_id);

    if ($product === null || $product === false) {
        return;
    }

    add_meta_box('pcf_fields', 'name & email', 'render_pcf_fields_metabox', 'comment', 'normal', 'high');
}
add_action('edit_comment', 'save_pcf_changes', 10, 1);
function save_pcf_changes($comment_id)
{
    // First of all, let's validate the nonce
    if (!isset($_POST['pcf_metabox_nonce']) || !wp_verify_nonce($_POST['pcf_metabox_nonce'], 'pcf_metabox_update')) {
        wp_die('You can not do this action');
    }

    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        update_comment_meta($comment_id, 'name', esc_html($name));
    }

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        update_comment_meta($comment_id, 'email', esc_html($email));
    }
}
// var_dump(get_page_template());
function render_pcf_fields_metabox($comment)
{
    $name = get_comment_meta($comment->comment_ID, 'name', true);
    $email = get_comment_meta($comment->comment_ID, 'email', true);
    wp_nonce_field('pcf_metabox_update', 'pcf_metabox_nonce', false);
    ?>
    <p>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo esc_attr($name); ?>" class="widefat" />
    </p>
    <p>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?php echo esc_attr($email); ?>" class="widefat" />
    </p>
    <?php
}

// add_filter( 'lostpassword_url', 'custom_lostpassword_url', 10, 0 );

// function custom_lostpassword_url() {
//     return site_url( '/my-account/your-custom-lost-password-page/' ); // Replace with your desired URL
// }


add_filter('gettext', 'theme_change_comment_field_names', 20, 3);
function theme_change_comment_field_names($translated_text, $text, $domain)
{

    if (is_singular()) {

        switch ($translated_text) {

            case 'Check-out':

                $translated_text = __('Commande', 'theme_text_domain');
                break;

            case 'Order Complete':

                $translated_text = __('Commande terminée', 'theme_text_domain');
                break;

            case 'Select optionss':

                $translated_text = __('Sélectionnez les options', 'theme_text_domain');
                break;
        }

    }

    return $translated_text;
}

require get_theme_file_path('theme.php');


add_action('admin_menu', 'custom_admin_menu');
function custom_admin_menu()
{
    add_menu_page(
        'API Google',
        'API Google',
        'manage_options',
        'api-google',
        'api_google_tab_page',
        'dashicons-admin-generic',
        20
    );
}

function api_google_tab_page()
{
    ?>
    <div class="wrap">
        <h1>API Google</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('api_google_settings');
            do_settings_sections('api-google');
            ?>
            <label>Api Google</label>
            <input type="text" name="api_google" value="<?php echo esc_attr(get_option('api_google', '')); ?>"
                style="width:500px" />
            <?php submit_button('Save'); ?>
        </form>
    </div>
    <?php
}
add_action('admin_init', 'api_google_settings');
function api_google_settings()
{
    register_setting('api_google_settings', 'api_google');
}


// add_action('woocommerce_widget_shopping_cart_before_buttons', 'add_shipping_method_to_mini_cart');

// function add_shipping_method_to_mini_cart() {
//     if (!WC()->cart->is_empty()) {
//         $packages = WC()->shipping()->get_packages();
//         foreach ($packages as $package) {
//             $shipping_methods = WC()->shipping()->calculate_shipping_for_package($package);
//             if (!empty($shipping_methods['rates'])) {
//                 echo '<div class="mini-cart-shipping">';
//                 echo '<h4>' . __('Shipping Methods') . '</h4>';
//                 foreach ($shipping_methods['rates'] as $rate) {
//                     echo '<p>' . esc_html($rate->get_label() . ' - ' . wc_price($rate->get_cost())) . '</p>';
//                 }
//                 echo '</div>';
//             }
//         }
//     }
// }

add_filter('woocommerce_product_add_to_cart_text', function ($text) {
    if ('Lire la suite' == $text) {
        $text = __('Découvrir', 'woocommerce');
    }

    return $text;
});

add_action('wp_head', 'add_meta_noindex');

function add_meta_noindex()
{
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/categorie-produit/fauteuil-de-bureau/page/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/categorie-produit/armoires-occasion-mobilier-entreprise/page/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/categorie-produit/bureau/page/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow " />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/categorie-produit/bureau/bureau-professionnel/page/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/categorie-produit/tables-de-reunion-occasion-paris-ile-de-france/page/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/categorie-produit/accessoire-de-bureau/page/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/etiquette-produit/occasion/page/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/mobilier-bureau-entreprise-occasion/bon-cadeau-communaute-comet/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/nombre-de-colonnes/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/nombre-de-rangees/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/category/economie-circulaire-ecologie/page/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/category/bloga/page/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/page/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (isset($_GET['page_id']) && $_GET['page_id'] == 145) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (isset($_GET['page_id']) && $_GET['page_id'] == 540) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (isset($_GET['page_id']) && $_GET['page_id'] == 1871) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/mobilier-bureau-entreprise-occasion/siege-forma-5-sense-neuf/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/mobilier-bureau-entreprise-occasion/siege-steelcase-think-occasion-2/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/mobilier-bureau-entreprise-occasion/bureau-secretair-home/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/mobilier-bureau-entreprise-occasion/bureau-electrique-blanc-neuf/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/mobilier-bureau-entreprise-occasion/siege-steelcase-think-occasion/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/nos-engagements/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/nos-realisations/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
    if (is_paged() && strpos($_SERVER['REQUEST_URI'], '/mobilier-bureau-entreprise-occasion/table-ovale-200x100-saphir-occasion/') !== false) {
        echo '<meta name="robots" content="noindex, nofollow" />';
    }
}

// function custom_noindex_for_specific_pages($robots) {
//     if ( is_paged() ) {
//         if ( strpos( $_SERVER['REQUEST_URI'], '/categorie-produit/fauteuil-de-bureau/page/' ) !== false ||
//             strpos( $_SERVER['REQUEST_URI'], '/categorie-produit/armoires-occasion-mobilier-entreprise/page/' ) !== false ||
//             strpos( $_SERVER['REQUEST_URI'], '/categorie-produit/bureau/page/' ) !== false ||
//             strpos( $_SERVER['REQUEST_URI'], '/categorie-produit/bureau/bureau-professionnel/page/' ) !== false ||
//             strpos( $_SERVER['REQUEST_URI'], '/categorie-produit/tables-de-reunion-occasion-paris-ile-de-france/page/' ) !== false ||
//             strpos( $_SERVER['REQUEST_URI'], '/categorie-produit/accessoire-de-bureau/page/' ) !== false ||
//             strpos( $_SERVER['REQUEST_URI'], '/etiquette-produit/occasion/page/' ) !== false ||
//             strpos( $_SERVER['REQUEST_URI'], '/mobilier-bureau-entreprise-occasion/bon-cadeau-communaute-comet/' ) !== false ||
//             strpos( $_SERVER['REQUEST_URI'], '/nombre-de-colonnes/' ) !== false ||
//             strpos( $_SERVER['REQUEST_URI'], '/nombre-de-rangees/' ) !== false ||
//             strpos( $_SERVER['REQUEST_URI'], '/category/economie-circulaire-ecologie/page/' ) !== false ||
//             strpos( $_SERVER['REQUEST_URI'], '/category/bloga/page/' ) !== false ) {

//             $robots['noindex'] = true;
//             $robots['nofollow'] = true;
//         }
//     }
//     return $robots;
// }
// add_filter('_yoast_wpseo_meta_robots', 'custom_noindex_for_specific_pages');

add_filter('woocommerce_product_tabs', 'woo_new_product_tab');
function woo_new_product_tab($tabs)
{

    $tabs['test_tab'] = array(
        'title' => __('Politique de retour', 'woocommerce'),
        'priority' => 15,
        'callback' => 'woo_new_product_tab_content'
    );

    return $tabs;

}
function woo_new_product_tab_content()
{
    $content_tab_global_product = get_option('global_tab_product', '');
    echo '<h2>Politique de retour</h2>';
    echo "<div class='content-product-tab-global'>" . wp_kses_post($content_tab_global_product) . "</div>";
}

add_action('admin_menu', 'custom_admin_menu_tab_global_product');
function custom_admin_menu_tab_global_product()
{
    add_menu_page(
        'Tab Global Product',
        'Tab Global Product',
        'manage_options',
        'tab-global-product',
        'global_tab_page_product',
        'dashicons-admin-generic',
        20
    );
}

function global_tab_page_product()
{
    ?>
    <div class="wrap">
        <h1>Tab Global Product</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('global_tab_product_settings');
            do_settings_sections('global_tab_product');
            ?>
            <label>Tab Global Product</label>
            <?php
            $content = get_option('global_tab_product', '');

            wp_editor($content, 'global_tab_product_editor', array(
                'textarea_name' => 'global_tab_product',
                'textarea_rows' => 50,
                'editor_height' => 300,
            ));
            ?>
            <?php submit_button('Save'); ?>
        </form>
    </div>
    <?php
}
add_action('admin_init', 'global_tab_product_settings');
function global_tab_product_settings()
{
    register_setting('global_tab_product_settings', 'global_tab_product');
}


// add_action('init', 'handle_email_verification');

// function handle_email_verification()
// {
//     if (isset($_GET['action']) && $_GET['action'] == 'verify_email') {
//         $verification_key = sanitize_text_field($_GET['key']);
//         $user_id = intval($_GET['user']);

//         $stored_key = get_user_meta($user_id, '_email_verification_key', true);

//         if ($verification_key === $stored_key) {
//             update_user_meta($user_id, '_email_verified', true);

//             wp_set_auth_cookie($user_id);
            
//             $user = get_user_by('id', $user_id);
//             if (in_array('administrator', $user->roles)) {
//                 wp_redirect(admin_url());
//             } else {
//                 wp_redirect(home_url() . '/my-account');
//             }

//             delete_user_meta($user_id, '_email_verification_key');
//             delete_user_meta($user_id, '_email_verified');
//             exit;
//         } else {
//             wp_redirect(home_url() . '/');
//             exit;
//         }
//     }
// }
// add_filter('wp_authenticate_user', 'check_email_verification_before_login', 10, 2);

// function check_email_verification_before_login($user, $password)
// {
//     if ($user->ID === 5850) {
//         return $user;
//     }

//     $is_verified = get_user_meta($user->ID, '_email_verified', true);
//     $user_id = $user->ID;
//     if (!$is_verified) {
//         $verification_key = md5(time() . $user_id);
//         update_user_meta($user_id, '_email_verification_key', $verification_key);

//         $verification_url = add_query_arg(array(
//             'action' => 'verify_email',
//             'key' => $verification_key,
//             'user' => $user_id
//         ), home_url());

//         $logo_url = home_url('/wp-content/uploads/2024/11/cropped-aub-logo-2023-small-1.svg');
//         $subject = 'Vérifiez votre e-mail';
//         $message = generate_email_verification_message($user->user_email, $logo_url, $verification_url);

//         $headers = array('Content-Type: text/html; charset=UTF-8');

//         wp_mail($user->user_email, $subject, $message, $headers);
//     }
//     if (!$is_verified) {
//         return new WP_Error('authentication_failed', 'Votre adresse e-mail n\'a pas été vérifiée. Veuillez vérifier votre boîte de réception pour le lien de vérification.');
//     }


//     return $user;
// }
// function generate_email_verification_message($user_email, $logo_url, $verification_url)
// {
//     return '
//     <html>
//     <head>
//         <style>
//             body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }
//             .email-container { background-color: #fff; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; }
//             .email-header { text-align: center; }
//             .email-header img { max-width: 150px !important; }
//             .email-content { margin-top: 20px; text-align:center; }
//             .email-footer { text-align: center; margin-top: 20px; font-size: 12px; color: #888; }
//             .button { display: inline-block; background-color: #FFCE09; color: #000; padding: 15px 20px; text-decoration: none !important; border-radius: 5px; }
//             .button:hover { background-color: #d1a909; }
//             .wrap-button{display:flex; justify-content: center;}
//         </style>
//     </head>
//     <body>
//         <div class="email-container">
//             <div class="email-header">
//                 <img src="' . $logo_url . '" alt="Logo">
//                 <h1>Continuer en se connectant</h1>
//             </div>
//             <div class="email-content">
//                 <p>Salut ' . $user_email . '</p>
//                 <p>Cliquez sur le bouton pour continuer ou saisissez manuellement le code</p>
//                 <p>d\'authentification ci-dessous pour terminer votre connexion</p>
//                 <p class="wrap-button">
//                     <a href="' . esc_url($verification_url) . '" class="button">Vérifier votre e-mail</a>
//                 </p>
//             </div>
//             <div class="email-footer">
//                 <p>Si vous n\'avez pas demandé cela, veuillez ignorer cet e-mail.</p>
//             </div>
//         </div>
//     </body>
//     </html>';
// }
// add_action( 'wp_logout', 'clear_email_verification_meta_on_logout' );

// function clear_email_verification_meta_on_logout() {
//     $user_id = get_current_user_id();

//     if ( $user_id ) {
//         delete_user_meta( $user_id, '_email_verification_key' );
//         delete_user_meta( $user_id, '_email_verified' );
//         wp_clear_auth_cookie();
//     }
// }

?>
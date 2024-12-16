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
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.5.1.slim.min.js', array(), '1.0.0', true);
    wp_enqueue_script('jquery.validate.min.js', get_stylesheet_directory_uri() . '/js/jquery.validate.min.js', array(), time(), true);
    wp_enqueue_script('theme-script', get_stylesheet_directory_uri() . '/js/theme.js', array('jquery'), time(), true);

    wp_enqueue_style('custom-css', get_stylesheet_directory_uri() . '/css/custom.css', array(), time(), 'all');
    wp_enqueue_style('theme-css', get_stylesheet_directory_uri() . '/css/theme.css', array(), time(), 'all');
    wp_enqueue_style('single-custom-css', get_stylesheet_directory_uri() . '/css/single-custom.css', array(), time(), 'all');


}
add_filter('woocommerce_countries_inc_tax_or_vat', function () {
    return __('(incl. TVA)', 'woocommerce');
});

add_filter('woocommerce_checkout_fields', 'customize_checkout_fields');

add_filter( 'ninja_forms_i18n_front_end', 'my_custom_ninja_forms_i18n_front_end' );
function my_custom_ninja_forms_i18n_front_end( $strings ) {
    $strings['fieldsMarkedRequired'] = "Les champs marqués d'un <span class='red-asterisk'>*</span> sont obligatoires";
    return $strings;
}

add_filter( 'ninja_forms_i18n_front_end', 'my_custom_translate_nf_form_errors' );
function my_custom_translate_nf_form_errors( $strings ) {
    foreach ( $strings as $key => $string ) {
        if ( $string === 'If you are a human seeing this field, please leave it empty.' ) {
            $strings[ $key ] = 'Si vous êtes un être humain et que vous voyez ce champ, veuillez le laisser vide.';
        }
    }
    return $strings;
}



function customize_checkout_fields($fields) {
    foreach ($fields as $category => $category_fields) {
        foreach ($category_fields as $field_key => $field) {
            $fields[$category][$field_key]['class'][] = 'custom-required-field';
        }
    }
    return $fields;
}

add_action('woocommerce_checkout_process', 'validate_checkout_fields');

function validate_checkout_fields() {
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

    $new_price = sprintf(
        '<p class="inclu_tax">À partir de %s <span class="ttc_tax">TVA</span></p>
        <p class="exclu_tax">soit <span class="ht_tax">%s</span> HT</p>',
        wc_price($price_including_tax),
        wc_price($price_excluding_tax)
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
?>
<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$current_user_woospca=wp_get_current_user();
$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
?>

<p>
	<?php
	printf(
		/* translators: 1: user display name 2: logout url */
		wp_kses( __( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ), $allowed_html ),
		'<strong>' . esc_html( $current_user_woospca->display_name ) . '</strong>',
		esc_url( wc_logout_url() )
	);
	?>
</p>

<p>
	<?php
	/* translators: 1: Orders URL 2: Address URL 3: Account URL. */
	 $dashboard_desc = __( 'From your account dashboard you can view your <a id="woospca_ro" href="#Sectionorders">recent orders</a>, manage your <a href="#Sectionedit-address" id="woospca_ba">billing address</a>, and <a id="woospca_ad" href="#Sectionedit-account">edit your password and account details</a>.', 'woocommerce' );
	if ( wc_shipping_enabled() ) {
		/* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
		 $dashboard_desc = __( 'From your account dashboard you can view your <a id="woospca_ro" href="#Sectionorders">recent orders</a>, manage your <a href="#Sectionedit-address" id="woospca_ba">shipping and billing addresses</a>, and <a id="woospca_ad" href="#Sectionedit-account">edit your password and account details</a>.', 'woocommerce' );
	}
	echo filter_var($dashboard_desc);

	?>
</p>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	// do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	// do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	// do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
?>
<script type="text/javascript">
	jQuery('#woospca_ro').on('click',function(){
	
		jQuery('.plugify_main_nav_li').each(function(){
			jQuery(this).removeClass('active_class');
		});
		jQuery('.hide_class').hide();

		jQuery('.woocommerce-MyAccount-navigation-link--orders').addClass('active_class');
		jQuery('#plugify_orders').show();
		
		
	});

	jQuery('#woospca_ba').on('click',function(){
		jQuery('.plugify_main_nav_li').each(function(){
			jQuery(this).removeClass('active_class');
		});
		jQuery('.hide_class').hide();

		jQuery('.woocommerce-MyAccount-navigation-link--edit-address').addClass('active_class');
		jQuery('#plugify_edit-address').show();
	});

	jQuery('#woospca_ad').on('click',function(){
		jQuery('.plugify_main_nav_li').each(function(){
			jQuery(this).removeClass('active_class');
		});
		jQuery('.hide_class').hide();

		jQuery('.woocommerce-MyAccount-navigation-link--edit-account').addClass('active_class');
		jQuery('#plugify_edit-account').show();
	});
</script>

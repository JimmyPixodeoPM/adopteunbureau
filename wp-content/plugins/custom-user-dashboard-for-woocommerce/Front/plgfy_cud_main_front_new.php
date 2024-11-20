<?php 
add_action('init', 'plugify_check_the_valid_url', 999);
function plugify_check_the_valid_url() {

	

	//wp_enqueue_style( 'alphaa_sndsfont-awesome', plugins_url( 'Assets/font-awesome.css', __FILE__ ), false, '1.0', 'all' );
	
	if (is_user_logged_in()) {
	
		$host = filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_STRING);
		$uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);

		$current_url = ( isset( $_SERVER['HTTPS'] ) ? 'https' : 'http' ) . "://$host$uri";

		$dashboard_url = get_permalink( get_option('woocommerce_myaccount_page_id'));

		if ($dashboard_url == $current_url || '/members-area/' == substr($current_url, -14)) {
			add_shortcode('woocommerce_my_account', 'woospca_create_dashboard_callback');
		} else {
			add_action('woocommerce_after_account_navigation', 'woocommerce_after_customer_login_form');
		}	
	}
}

function woocommerce_after_customer_login_form () {

	$host = filter_input(INPUT_SERVER, 'HTTP_HOST', FILTER_SANITIZE_STRING);
	$uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);

	$current_url = ( isset( $_SERVER['HTTPS'] ) ? 'https' : 'http' ) . "://$host$uri";

	if (strpos($current_url, 'members') !== false) {
		$is_member = false;
	} else {


		$woospca_save_All_general_settings_db_in=get_option('woospca_save_All_general_settings_db_in');


		if (!isset($woospca_save_All_general_settings_db_in['woospca_btdb_t_clr'])) {
			$woospca_save_All_general_settings_db_in['woospca_btdb_t_clr'] = 'FFFFFF';
		}

		if (!isset($woospca_save_All_general_settings_db_in['woospca_btdb_bg_clr'])) {
			$woospca_save_All_general_settings_db_in['woospca_btdb_bg_clr'] = 'ae7b3b';
		}

		$woospca_btdb_t_clr=$woospca_save_All_general_settings_db_in['woospca_btdb_t_clr'];
		$woospca_btdb_bg_clr=$woospca_save_All_general_settings_db_in['woospca_btdb_bg_clr'];

		?>
		<a href="<?php echo filter_var(get_permalink( get_option('woocommerce_myaccount_page_id'))); ?>"  ><button class="button-primary back_tdashplgfy" style="cursor:pointer;background:#<?php echo filter_var( $woospca_btdb_bg_clr); ?>;color: #<?php echo filter_var($woospca_btdb_t_clr); ?>;border-radius: 4px;padding: 4px 6px 4px 6px !important;"><?php echo esc_attr('Back to Dashboard'); ?>  <i class="fas fa-arrow-left"></i>
	</button></a>

		<style type="text/css">
			
			.woocommerce-MyAccount-navigation {
				display: none;
			}

			.woocommerce-MyAccount-content {
				width: 100% !important;
			}

			.wc-memberships-members-area-navigation {
				display: block !important;
			}
		</style>
		<?php 

	}

}

function get_plugify_ends() {
	global $wpdb;
	 $woospca_all_endpoints_withgrp=array();
	
	$user_meta=get_userdata(get_current_user_ID());

	$user_roles=$user_meta->roles;

	$wpdb->woospca_custom_endpoints = $wpdb->prefix . 'woospca_custom_endpoints';
	$woospca_all_endpoints_withgrp = $wpdb->get_results( 'SELECT woospca_id, woospca_customer_role FROM ' . $wpdb->woospca_custom_endpoints );

	$woospca__ids='';

	if (isset($_GET['i'])) {
		$woospca_iiii=sanitize_text_field($_GET['i']);
	}
	$wpdb->woospca_custom_endpoints = $wpdb->woospca_custom_endpoints . $woospca__ids;

	$woospca_all_endpoints_withgrp = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->woospca_custom_endpoints . ' ORDER BY woospca_sort_order ASC');

	return $woospca_all_endpoints_withgrp;
}






function plgfy_cud_get_all_endpoints_custom_default () {

	$get_plugify_ends=get_plugify_ends();

	$def_slugs=wc_get_account_menu_items();

	$index_to_unset = array();


	foreach ($get_plugify_ends as $key12 => $value12) {
		if ( '2' == $value12->woospca_default) {
			if (!isset($def_slugs[$value12->woospca_slug])) {
				array_push($index_to_unset, $key12);
			}
		}
	}

	foreach ($index_to_unset as $key_index => $value_index) {
		unset($get_plugify_ends[$value_index]);
	}

	foreach ($def_slugs as $external_slug => $external_label) {
		
		if ( 'customer-logout' != $external_slug && 'edit-account' != $external_slug && 'orders' != $external_slug && 'downloads' != $external_slug && 'edit-address' != $external_slug && 'dashboard' != $external_slug) {

			$is_exist =false;

			foreach ($get_plugify_ends as $key12 => $value12) {
				if ($external_slug == $get_plugify_ends[$key12]->woospca_slug) {
					$is_exist = true;
				}
			}

			if (!$is_exist) {
				$object = new stdClass();
				$array=array(				
					'woospca_id' => '99999999',
					'woospca_name' => $external_label,
					'woospca_content' => '',
					'woospca_icon' => '',
					'woospca_is_hide' => '0',
					'woospca_children'=> '',
					'woospca_sort_order' => '9999',
					'woospca_type' => '',
					'woospca_new_tab'=> '',
					'woospca_default' => '2',
					'woospca_slug' => $external_slug,
					'woospca_customer_role' => ''
					
				);
				foreach ($array as $key => $value) {
					$object->$key = $value;
				}
				$get_plugify_ends[]=$object; 
			}
		}
	}
	return $get_plugify_ends;
}






function woospca_create_dashboard_callback() {
	include 'dashboard_view_main.php';
}

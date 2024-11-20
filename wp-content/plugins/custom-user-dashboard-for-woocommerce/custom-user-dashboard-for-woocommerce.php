<?php
/**
 * Plugin Name: Custom User Dashboard For Woocommerce
 * Plugin URI: https://woocommerce.com/products/custom-user-dashboard-for-woocommerce/
 * Author: Plugify
 * Author URI: https://woocommerce.com/vendor/plugify/
 * Version: 2.0.1
 * Developed By: Plugify Team
 * Description: Personalize user's my account dashboard by adding new tabs and customizing default endpoints.
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires at least: 4.4
 * Tested up to: 7.*.*
 * Woo: 8157223:54c77fad32116a675c6d040f94213662
 * WC requires at least: 3.0
 * WC tested up to: 7.*.*
 */
if ( ! defined( 'ABSPATH' ) ) { 
	exit; // Exit if accessed directly
}
/**
 * Check if WooCommerce is active
 * if wooCommerce is not active Custom User Dashboard For Woocommerce will not work.
 **/
if (!is_multisite()) {
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

		function my_admin_notice() {		
			deactivate_plugins(__FILE__);
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			?>
			<div id="message" class="error">
				<p>This plugin requires <a href="https://wordpress.org/extend/plugins/woocommerce/">WooCommerce</a> plugin to be installed and active!</p> 
			</div>
			<?php
		}
		add_action( 'admin_notices', 'my_admin_notice' );
	}
}
error_reporting(0);
class Woospca_Main_Class_Alpha {	
	public function __construct() {
		register_activation_hook( __FILE__, array( $this, 'woospca_activation_plugin_for_my_account_page'));
		if (is_admin()) {
			include ('Admin/woospca_main_admin.php');			
		} else {
			// include ('Front/woospca_main_front.php');
			include ('Front/plgfy_cud_main_front_new.php');
		}		
		add_action('init', array( $this, 'plugify_move_img'));
		add_action('wp_ajax_woospca_reset_to_def_clr', array( $this, 'woospca_reset_to_def_clr'));
		add_action('wp_ajax_nopriv_woospca_upload_image_tod', array( $this, 'woospca_upload_image_tod'));
		add_action('wp_ajax_woospca_upload_image_tod', array( $this, 'woospca_upload_image_tod'));
		add_action('wp_ajax_woospca_save_general_Settings_data_in_db', array( $this, 'woospca_save_general_Settings_data_in_db'));
		add_action('wp_ajax_woospca_get_children_for_grp_content_modal', array( $this, 'woospca_get_children_for_grp_content_modal'));
		add_action('wp_ajax_get_all_enpoints_from_db', array( $this, 'woospca_get_all_enpoints_from_db'));
		add_action('wp_ajax_woospca_save_endpoint_data_db', array( $this, 'woospca_save_endpoint_data_db'));
		add_action('wp_ajax_woospca_sort_endpoint_data_db', array( $this, 'woospca_sort_endpoint_data_db'));
		add_action('wp_ajax_woospca_delete_endpoint_data_db', array( $this, 'woospca_delete_endpoint_data_db'));	
		add_action('wp_ajax_woospca_get_all_epss_html', array( $this, 'woospca_get_all_epss_html'));	
		add_action('wp_ajax_woospca_get_one_ep_html_for_edit', array( $this, 'woospca_get_one_ep_html_for_edit'));	
		add_action('wp_ajax_woospca_edit_ep_details_one', array( $this, 'woospca_edit_ep_details_one'));

		add_action( 'before_woocommerce_init', array($this, 'plugify_check_compatibility'));

	}

	public function plugify_check_compatibility() {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}

	public function plugify_move_img() {
		$upload_dir = wp_upload_dir();
		$fromwhere=plugin_dir_path(__FILE__) . 'Uploaded_users_images/';
		if ( ! empty( $upload_dir['basedir'] ) ) {
			$user_dirname = $upload_dir['basedir'] . '/Uploaded_users_images/';
			if ( ! file_exists( $user_dirname ) ) {
				wp_mkdir_p( $user_dirname );

				chmod($user_dirname, 0777);

				
				chmod($fromwhere, 0777);
				chmod($fromwhere . 'dummy.jpeg', 0777);

				copy ($fromwhere . 'dummy.jpeg', $user_dirname . 'dummy.jpeg');
			}
			

		}
	}
	public function woospca_reset_to_def_clr() {
		$woospca_def_gen_settings=array(
			'woospca_is_avatar' => 'true',
			'woospca_is_upload_avatar' => 'true',
			'woospca_is_logout' => 'true',
			'woospca_avatar_radius' => '10',
			'woospca_menu_pos' => 'leftside',
			'woospca_menu_style' => 'woospca_menu_styleb',
			'woospca_p_t' => '5',
			'woospca_p_r' => '5',
			'woospca_p_b' => '5',
			'woospca_p_l' => '5',
			'woospca_d_bd_c' => 'F4F3E0',
			'woospca_d_t_c' => '000000',
			'woospca_d_brdrandcorner_c' => '858585',
			'woospca_a_bg_c' => '8B8B8B',
			'woospca_a_t_c' => 'FFFFFF',
			'woospca_a_brdrandcorner_c'=> '2B2B2B',
			'woospca_h_bg_c' => 'FFFFFF',
			'woospca_h_t_c' => '000000',
			'woospca_h_brdrandcorner_c' => '858585',

			'woospca_d_bd_c2' => 'FFFFFF',
			'woospca_d_t_c2' => '000000',
			'woospca_d_brdrandcorner_c2' => 'CFCFCF',

			'woospca_a_bg_c2' => 'CFCFCF',
			'woospca_a_t_c2' => '000000',
			'woospca_a_brdrandcorner_c2' => '919191',

			'woospca_h_bg_c2' => 'F0F0F0',
			'woospca_h_t_c2' => '000000',
			'woospca_h_brdrandcorner_c2' => 'CFCFCF',

			'woospca_d_brdrandcorner_c2bb' => '919191',
			'woospca_a_brdrandcorner_c2bb' => '1A1A1A',
			'woospca_h_brdrandcorner_c2bb' => '919191',

			'woospca_brdr_rdiis' => '5',
			'woospca_logout_bg_clr' => 'FF2121',
			'woospca_logout_t_clr' => 'FFFFFF',
			'woospca_btdb_bg_clr' => 'ae7b3b',
			'woospca_btdb_t_clr' => 'FFFFFF',
		);
		update_option('woospca_save_All_general_settings_db_in', $woospca_def_gen_settings);
		wp_die();
	}
	public function woospca_upload_image_tod() {
		if ( isset( $_REQUEST['id'] ) ) {
			$woospca_id=filter_var($_REQUEST['id']);

		} else {
			$woospca_id=false;
		}
		$upload_dir = wp_upload_dir();

		if ( ! empty( $upload_dir['basedir'] ) ) {
			$user_dirname = $upload_dir['basedir'] . '/Uploaded_users_images/';
			if ( ! file_exists( $user_dirname ) ) {
				wp_mkdir_p( $user_dirname );
			}


		}
		if ( isset ($_FILES[$woospca_id]['name']) || isset($_FILES[$woospca_id]['type']) || isset($_FILES[$woospca_id]['tmp_name']) || isset($_FILES[$woospca_id]['error']) || isset($_FILES[$woospca_id]['size']) ) {
			chmod($user_dirname . get_current_user_ID() . '-' . filter_var($_FILES[$woospca_id]['name']), 0777);
			move_uploaded_file ( sanitize_text_field($_FILES[$woospca_id]['tmp_name']), $user_dirname . get_current_user_ID() . '-' . filter_var($_FILES[$woospca_id]['name']));
			update_user_meta(get_current_user_ID(), '_woospca_current_user_profile', get_current_user_ID() . '-' . filter_var($_FILES[$woospca_id]['name']) );
		}
		wp_die();
	}
	public function woospca_save_general_Settings_data_in_db() {
		update_option('woospca_save_All_general_settings_db_in', $_REQUEST);
		wp_die();
	}
	public function woospca_get_children_for_grp_content_modal() {
		$woospca_all_endpoints = $this->plgfy_cud_get_all_endpoints_custom_default();

		foreach ($woospca_all_endpoints as $endpoint) {

			if ( 'group' != $endpoint->woospca_type) {
				?>
				<option value="<?php echo filter_var($endpoint->woospca_id); ?>">
					<?php echo esc_attr($endpoint->woospca_name); ?>
				</option>
				<?php
			}
		}
		wp_die();
	}
	public function woospca_edit_ep_details_one() {


	

		global $wpdb;
		if (isset($_REQUEST['active_class_val'])) {
			$woospca_type=sanitize_text_field($_REQUEST['active_class_val']);
		}
		if ('grp' == $woospca_type) {
			$woospca_type = 'group';
		} else if ('link' == $woospca_type) {
			$woospca_type = 'link';
		} else if ('page' == $woospca_type) {
			$woospca_type = 'page';
		} else {
			$woospca_type = 'endpoint';
		}
		$woospca_children='';
		if ('group' == $woospca_type) {
			if (isset($_REQUEST['woospca_eps_All'])) {
				$woochildd=array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['woospca_eps_All'] ) );
			}
			$woospca_children=serialize($woochildd);
		} else if ('page' == $woospca_type ) {
			if (isset($_REQUEST['woospca_sel_page_ep'])) {
				$woospca_sel_page_ep=sanitize_text_field($_REQUEST['woospca_sel_page_ep']);
			}
			$woospca_children=$woospca_sel_page_ep;
		} else if ('link' == $woospca_type ) {
			if (isset($_REQUEST['woospca_link_ep'])) {
				$woospca_link_ep=sanitize_text_field($_REQUEST['woospca_link_ep']);
			}
			$woospca_children=$woospca_link_ep;
		} else {
			if (isset($_REQUEST['woospca_showcontentwhere'])) {
				$woospca_children=sanitize_text_field($_REQUEST['woospca_showcontentwhere']);
			}
			
			
		}
		$newtab='777';
		if (isset($_REQUEST['woospca_checknewtab_ep'])) {
			$woospca_checknewtab_ep = sanitize_text_field($_REQUEST['woospca_checknewtab_ep']);
			if ('true' == $woospca_checknewtab_ep) {
				$newtab='111';
			}
		}
		$woospca_hide_ep='777';
		
		if (isset($_REQUEST['woospca_hide_ep'])) {
			$woospca_hide_ep = sanitize_text_field($_REQUEST['woospca_hide_ep']);
			if ('true' == $woospca_hide_ep) {
				$woospca_hide_ep='111';
			}
		}


		if (isset($_REQUEST['woospca_customer_roleedit'])) {
			$woospca_customer_roleedit = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['woospca_customer_roleedit'] ) );
		}
		if (isset($_REQUEST['woospca_slug_ep'])) {
			$woospca_slug_ep = sanitize_text_field($_REQUEST['woospca_slug_ep']);
		}
		if (isset($_REQUEST['woospca_icons'])) {
			$woospca_icons = sanitize_text_field($_REQUEST['woospca_icons']);
		}
		if (isset($_REQUEST['woospca_label_ep'])) {
			$woospca_label_ep = sanitize_text_field($_REQUEST['woospca_label_ep']);
		}
		if (isset($_REQUEST['woospca_editor_ep_id'])) {

			$allowed_tags = array(
				'a' => array(
					'class' => array(),
					'href' => array(),
					'rel' => array(),
					'title' => array(),
				),
				'abbr' => array(
					'title' => array(),
				),
				'b' => array(),
				'blockquote' => array(
					'cite' => array(),
				),
				'cite' => array(
					'title' => array(),
				),
				'code' => array(),
				'del' => array(
					'datetime' => array(),
					'title' => array(),
				),
				'dd' => array(),
				'div' => array(
					'class' => array(),
					'title' => array(),
					'style' => array(),
				),
				'dl' => array(),
				'dt' => array(),
				'em' => array(),
				'h1' => array(),
				'h2' => array(),
				'h3' => array(),
				'h4' => array(),
				'h5' => array(),
				'h6' => array(),
				'i' => array(),
				'img' => array(
					'alt' => array(),
					'class' => array(),
					'height' => array(),
					'src' => array(),
					'width' => array(),
				),
				'li' => array(
					'class' => array(),
				),
				'ol' => array(
					'class' => array(),
				),
				'p' => array(
					'class' => array(),
				),
				'q' => array(
					'cite' => array(),
					'title' => array(),
				),
				'span' => array(
					'class' => array(),
					'title' => array(),
					'style' => array(),
				),
				'strike' => array(),
				'strong' => array(),
				'ul' => array(
					'class' => array(),
				),
			);
			$woospca_editor_ep_id = wp_kses($_REQUEST['woospca_editor_ep_id'], $allowed_tags);
		}
		if (isset($_REQUEST['woospca_current_index'])) {
			$woospca_current_index=sanitize_text_field($_REQUEST['woospca_current_index']);
		}

		$wpdb->woospca_custom_endpoints = $wpdb->prefix . 'woospca_custom_endpoints';

		$wpdb->query($wpdb->prepare(' UPDATE ' . $wpdb->woospca_custom_endpoints . ' SET woospca_name = %s , woospca_content = %s , woospca_icon = %s , woospca_is_hide = %s , woospca_children = %s , woospca_new_tab = %s , woospca_slug = %s , woospca_customer_role = %s WHERE woospca_id = %d
			', $woospca_label_ep, $woospca_editor_ep_id, $woospca_icons, $woospca_hide_ep, $woospca_children, $newtab, $woospca_slug_ep, serialize($woospca_customer_roleedit), $woospca_current_index));
		
		wp_die();
	}
	public function woospca_get_one_ep_html_for_edit() {
		global $wpdb;
		if (isset($_REQUEST['woospca_current_index'])) {
			$woospca_current_index=sanitize_text_field($_REQUEST['woospca_current_index']);
		}
		if (isset($_REQUEST['woospca_current_slug'])) {
			$woospca_current_slug=sanitize_text_field($_REQUEST['woospca_current_slug']);
		}



		$get_plugify_ends = $this->plgfy_cud_get_all_endpoints_custom_default();

		foreach ($get_plugify_ends as $key1122 => $value1122) {
			if ($value1122->woospca_slug == $woospca_current_slug) {
				$woospca_result[0] = $value1122;
			}
		}

		$disable_slug_edit = '';

		if ('1' == $woospca_result[0]->woospca_default || '2' == $woospca_result[0]->woospca_default) {
			$disable_slug_edit = 'disabled';
		}


		if ('2' == $woospca_result[0]->woospca_default) {
			$woospca_result[0]->woospca_type = 'endpoint';
		}

		


		?>
		<div id="woospca_ep_content1" class="animate__animated animate__zoomIn" style="padding: 15px;margin-top: 1%;border-radius: 4px;border: 1px solid #bdbdbd;">
			<table style="width: 100%;">
				<tr>
					<td>
						<strong >Label<span style="color: red;">*</span></strong>
					</td>
					<td>
						<input type="text" id="woospca_label_ep1" value="<?php echo filter_var($woospca_result[0]->woospca_name); ?>" class="form-control ">
						<br>
					</td>
				</tr>
				<tr>
					<td>
						<strong >Slug<span style="color: red;">*</span></strong>
					</td>
					<td>
						<input type="text" <?php echo filter_var($disable_slug_edit); ?> value="<?php echo filter_var($woospca_result[0]->woospca_slug); ?>" id="woospca_slug_ep1" class="form-control "><br>
					</td>
				</tr>
				<tr>
					<td>
						<strong >Icon</strong>
					</td>
					<td id="icondivvvwoospca">
						<input type="hidden" id="pickthisiconanduse" value="<?php echo filter_var($woospca_result[0]->woospca_icon); ?>">
						<select id="woospca_icons1" class="form-control woospca_select1" style="width: 100%;">
							<option value="<?php echo esc_attr($woospca_result[0]->woospca_icon); ?> ">&lt;i class="fa fa-fw fa-<?php echo esc_attr($woospca_result[0]->woospca_icon); ?>"&gt;&lt;/i&gt; <?php echo esc_attr($woospca_result[0]->woospca_icon); ?></option>
						</select><br><br>
					</td>
				</tr>
				<?php 

				if ('group' == $woospca_result[0]->woospca_type) {
					?>
					<tr>
						<td>
							<strong>Link Children</strong>
						</td>
						<td>
							<select  id="woospca_eps_All1" multiple="multiple" style="width: 100%;">
								<?php							
								

								$woospca_all_endpoints = $get_plugify_ends;

								foreach ($woospca_all_endpoints as $endpoint) {
									if ('group' != $endpoint->woospca_type) {
										?>
										<option  value="<?php echo filter_var($endpoint->woospca_id); ?>"
											<?php 
											if (is_array(unserialize($woospca_result[0]->woospca_children)) && in_array($endpoint->woospca_id, unserialize($woospca_result[0]->woospca_children))) {
												echo filter_var('selected');
											} 
											?>
											><?php echo esc_attr($endpoint->woospca_name); ?>

										</option>
										<?php
									}
								}
								?>
							</select><br><br>
						</td>
					</tr>
					<?php
				}
				if ('link' == $woospca_result[0]->woospca_type) {
					?>
					<tr>
						<td>
							<strong >Add Link<span style="color: red;">*</span></strong>
						</td>
						<td>
							<input type="text" value="<?php echo filter_var($woospca_result[0]->woospca_children); ?>" id="woospca_link_ep1" class="form-control "><br>
						</td>
					</tr>
					<tr>
						<td>
							<strong >Open in new tab?</strong>
						</td>
						<td>
							<input  value="<?php echo filter_var($woospca_result[0]->woospca_new_tab); ?>" class="form-control " type="checkbox" id="woospca_checknewtab_ep1" 
							<?php 
							if ('111' == $woospca_result[0]->woospca_new_tab) {
								echo filter_var('checked');
							} 
							?>
							><br><br>
						</td>
					</tr>
					<?php
				}
				if ('page' == $woospca_result[0]->woospca_type) {
					?>
					<tr>
						<td>
							<strong >Choose Page</strong>
						</td>
						<td>
							<select  id="woospca_sel_page_ep1"  style="width: 100%;">
								<?php
								$args = array(
									'post_type'    => 'page',
									'sort_column'  => 'menu_order'
								);
								$pages = get_pages( $args );
								?>

								<?php 
								foreach ($pages as $page) {
									?>
									<option value="<?php echo esc_attr($page->ID); ?>" 
										<?php 
										if ($page->ID==$woospca_result[0]->woospca_children) {
											echo filter_var('selected');
										} 
										?>
										><?php echo esc_attr($page->post_title); ?></option>
									<?php
								}
								?>
								</select><br><br>
							</td>
						</tr>
						<tr>
							<td>
								<strong >Open in new tab?</strong>
							</td>
							<td>

								<input class="form-control " value="<?php echo filter_var( $woospca_result[0]->woospca_new_tab ); ?>" type="checkbox"id="woospca_checknewtab_ep1" 
								<?php 
								if ('111' == $woospca_result[0]->woospca_new_tab) {
									echo filter_var('checked');
								} 
								?>
								><br><br>
							</td>
						</tr>

						<?php
				}
				if ('1' == $woospca_result[0]->woospca_default || '2' == $woospca_result[0]->woospca_default) {
					?>
						<tr>
							<td>
								<strong >Show Content</strong>
							</td>
							<td>
								<input  value="before" class="form-control " style="vertical-align: sub;" type="radio" name="woospca_showcontentwhere" 
								<?php 
								if ('before' == $woospca_result[0]->woospca_children) {
									echo filter_var('checked');
								} 
								?>
								>Before Default
								<input  value="after" class="form-control " style="vertical-align: sub;margin-left: 3%;" type="radio" name="woospca_showcontentwhere" 
								<?php 
								if ('after' == $woospca_result[0]->woospca_children || ''==$woospca_result[0]->woospca_children) {
									echo filter_var('checked');
								} 
								?>
								>After Default
								<input style="vertical-align: sub;margin-left: 3%;" type="radio" name="woospca_showcontentwhere" value="override" class="form-control "
								<?php 
								if ('override' == $woospca_result[0]->woospca_children) {
									echo filter_var('checked');
								} 
								?>
								>Override Default
								<br>
								<br>
							</td>
						</tr>
						<?php
				}
				if ('group' != $woospca_result[0]->woospca_type) {
					?>
						<tr>
							<td>
								<strong >Hide?</strong>
							</td>
							<td>
								<input class="form-control " type="checkbox" id="woospca_hide_ep1" value="<?php echo filter_var( $woospca_result[0]->woospca_is_hide ); ?>"
								<?php 
								if ('111' == $woospca_result[0]->woospca_is_hide) {
									echo filter_var('checked');
								} 
								?>
								><br><br>

							</td>
						</tr>
						<?php
				}
				?>
					<tr>
						<td>
							<strong >Allowed Roles</strong>
						</td>
						<td>
							<?php 
							global $wp_roles;
							$woospca_all_roles = $wp_roles->get_names();
							?>
							<select class="woospca_customer_roleclassedit" id="woospca_customer_roleedit" multiple="multiple" class="form-control " style="width: 100%;">
								<?php
								foreach ($woospca_all_roles as $key_role => $value_role) {
									?>
									<option value="<?php echo filter_var($key_role); ?>"
										<?php 

										if (is_array( unserialize($woospca_result[0]->woospca_customer_role) )) {
											if (in_array($key_role, unserialize($woospca_result[0]->woospca_customer_role))) {
												echo filter_var('selected');
											}
										}


										
										?>
										><?php echo filter_var(ucfirst($value_role)); ?></option>
										<?php
								}
								?>

								</select>
								<br>
								<i style="color: green;">(Leave empty to allow all roles as selected)</i>
							</td>
						</tr>
					</table>

					<?php
					if ('endpoint' == $woospca_result[0]->woospca_type || '' == $woospca_result[0]->woospca_type) {
						$woospca_content= '';
						if ('' != $woospca_result[0]->woospca_content) {
							$woospca_content   = stripslashes($woospca_result[0]->woospca_content);
						}
						$woospca_editor_ep_id = 'woospca_editor_ep_id_ep11edit';
						$woospca_settings_array = array(
							'editor_height' => 180
						);
						wp_editor( $woospca_content, $woospca_editor_ep_id, $woospca_settings_array );
					}
					?>

				</div>
				<input type="hidden" woospca_default="<?php echo filter_var($woospca_result[0]->woospca_default); ?>" id="woospca_typeis" value="<?php echo filter_var($woospca_result[0]->woospca_type); ?>">
				<?php
				wp_die();
	}
	public function woospca_get_all_epss_html() {
	
		$woospca_all_endpoints_withgrp = $this->plgfy_cud_get_all_endpoints_custom_default();


		?>
		<ul id="sortable">
			<?php
			foreach ($woospca_all_endpoints_withgrp as $key_ep) {
				?>
				<li value="<?php echo filter_var($key_ep->woospca_id); ?>" 	ep_name="<?php echo filter_var($key_ep->woospca_name); ?>" class="ui-state-default" style="cursor:grab;width: 100%; display: flex; align-items: center;
				<?php 
				if ('18' <= count($woospca_all_endpoints_withgrp)) {
					echo filter_var('padding: 5px');
				} else {
					echo filter_var('padding: 8px');
				} 
				?>
				;" ><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><?php echo filter_var($key_ep->woospca_name); ?></li>
				<?php
			}
			?>
		</ul>
		<?php
		wp_die();
	}
	public function woospca_delete_endpoint_data_db() {
		global $wpdb;
		$wpdb->woospca_custom_endpoints = $wpdb->prefix . 'woospca_custom_endpoints';
		if (isset($_REQUEST['index_num'])) {
			$index_num_woospca=sanitize_text_field($_REQUEST['index_num']);
		}
		$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->woospca_custom_endpoints . ' WHERE woospca_id = %d', intval($index_num_woospca) ) );
		wp_die();
	}
	public function woospca_sort_endpoint_data_db() {
		
		if (isset($_REQUEST['new_array_Sorted'])) {
			$new_array_Sortedwoospca=array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['new_array_Sorted'] ) );
		}

		if (isset($_REQUEST['ep_name'])) {
			$ep_name=array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['ep_name'] ) );
		}


		$all_endpoints_woospca = $this->plgfy_cud_get_all_endpoints_custom_default();

		foreach ($new_array_Sortedwoospca as $key => $fieldid) {


			if ( '99999999' == $fieldid) {

				global $wpdb;
				$wpdb->woospca_custom_endpoints = $wpdb->prefix . 'woospca_custom_endpoints';
				foreach ($all_endpoints_woospca as $key2212 => $value2212) {

					if ($ep_name[$key] == $value2212->woospca_name) {

						$woospca_label_ep = $value2212->woospca_name;
						$woospca_content = '';
						$woospca_icon = '';
						$woospca_is_hide = '0';
						$woospca_children = '';
						$woospca_sort_order = $key+1;
						$woospca_type = '';
						$woospca_new_tab = '';
						$woospca_default = '2';
						$woospca_slug = $value2212->woospca_slug;
						$woospca_customer_role = '';



						$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->woospca_custom_endpoints
							(woospca_name, woospca_content, woospca_icon, woospca_is_hide, woospca_children, woospca_sort_order, woospca_type, woospca_new_tab, woospca_default, woospca_slug, woospca_customer_role) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $woospca_label_ep, $woospca_content, $woospca_icon, $woospca_is_hide, $woospca_children, $woospca_sort_order, $woospca_type, $woospca_new_tab, $woospca_default, $woospca_slug, $woospca_customer_role));
						break;
					}

				}

			} else {

				global $wpdb;
				$wpdb->woospca_custom_endpoints = $wpdb->prefix . 'woospca_custom_endpoints';

				$wpdb->query($wpdb->prepare('UPDATE ' . $wpdb->woospca_custom_endpoints . ' SET woospca_sort_order = %d WHERE woospca_id = %d', $key+1, intval($fieldid)));
			}

		
		}
		wp_die();
	}
	public function woospca_save_endpoint_data_db() {

	
		if (isset($_REQUEST['woospca_default'])) {
			$woospca_default = filter_var($_REQUEST['woospca_default']);
		} else {
			$woospca_default = '0';
		}
		

		global $wpdb;
		if (isset($_REQUEST['active_class_val'])) {
			$woospca_type=sanitize_text_field($_REQUEST['active_class_val']);
		}
		if ('grp' == $woospca_type) {
			$woospca_type = 'group';
		} else if ('link' == $woospca_type) {
			$woospca_type = 'link';
		} else if ('page' == $woospca_type) {
			$woospca_type = 'page';
		} else {
			$woospca_type = 'endpoint';
		}
		$woospca_children='';
		if ('2' == $woospca_default && isset($_REQUEST['woospca_showcontentwhere'])) {
			$woospca_children=filter_var($_REQUEST['woospca_showcontentwhere']);			
		}

		if ('grp' == $_REQUEST['active_class_val']) {
			if (isset($_REQUEST['woospca_eps_All'])) {
				$woochildd=array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['woospca_eps_All'] ) );
			}
			$woospca_children=serialize($woochildd);
		} else if ('page' == $woospca_type) {
			if (isset($_REQUEST['woospca_sel_page_ep'])) {
				$woospca_sel_page_ep=sanitize_text_field($_REQUEST['woospca_sel_page_ep']);
			}
			$woospca_children=$woospca_sel_page_ep;
		} else if ('link' == $woospca_type) {
			if (isset($_REQUEST['woospca_link_ep'])) {
				$woospca_link_ep=sanitize_text_field($_REQUEST['woospca_link_ep']);
			}
			$woospca_children=$woospca_link_ep;

		}
		$newtab='777';
		if (isset($_REQUEST['woospca_checknewtab_ep'])) {
			$woospca_checknewtab_ep = sanitize_text_field($_REQUEST['woospca_checknewtab_ep']);
			if ('true' == $woospca_checknewtab_ep) {
				$newtab='111';
			}
		}

		$woospca_hide_ep='777';

		if (isset($_REQUEST['woospca_hide_ep'])) {
			$woospca_hide_ep = sanitize_text_field($_REQUEST['woospca_hide_ep']);
			if ('true' == $woospca_hide_ep) {
				$woospca_hide_ep='111';
			}
		}
		if (isset($_REQUEST['woospca_customer_role'])) {
			$woospca_customer_role = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['woospca_customer_role'] ) );
		}
		if (isset($_REQUEST['woospca_slug_ep'])) {
			$woospca_slug_ep = sanitize_text_field($_REQUEST['woospca_slug_ep']);
		}
		if (isset($_REQUEST['woospca_icons'])) {
			$woospca_icons = sanitize_text_field($_REQUEST['woospca_icons']);
		}
		if (isset($_REQUEST['woospca_label_ep'])) {
			$woospca_label_ep = sanitize_text_field($_REQUEST['woospca_label_ep']);
		}
		if (isset($_REQUEST['woospca_editor_ep_id'])) {
			$allowed_tags = array(
				'a' => array(
					'class' => array(),
					'href' => array(),
					'rel' => array(),
					'title' => array(),
				),
				'abbr' => array(
					'title' => array(),
				),
				'b' => array(),
				'blockquote' => array(
					'cite' => array(),
				),
				'cite' => array(
					'title' => array(),
				),
				'code' => array(),
				'del' => array(
					'datetime' => array(),
					'title' => array(),
				),
				'dd' => array(),
				'div' => array(
					'class' => array(),
					'title' => array(),
					'style' => array(),
				),
				'dl' => array(),
				'dt' => array(),
				'em' => array(),
				'h1' => array(),
				'h2' => array(),
				'h3' => array(),
				'h4' => array(),
				'h5' => array(),
				'h6' => array(),
				'i' => array(),
				'img' => array(
					'alt' => array(),
					'class' => array(),
					'height' => array(),
					'src' => array(),
					'width' => array(),
				),
				'li' => array(
					'class' => array(),
				),
				'ol' => array(
					'class' => array(),
				),
				'p' => array(
					'class' => array(),
				),
				'q' => array(
					'cite' => array(),
					'title' => array(),
				),
				'span' => array(
					'class' => array(),
					'title' => array(),
					'style' => array(),
				),
				'strike' => array(),
				'strong' => array(),
				'ul' => array(
					'class' => array(),
				),
			);
			$woospca_editor_ep_id = wp_kses($_REQUEST['woospca_editor_ep_id'], $allowed_tags);

		}
		$wpdb->woospca_custom_endpoints = $wpdb->prefix . 'woospca_custom_endpoints';
		$previous_eps = $wpdb->get_results($wpdb->prepare( 'SELECT MAX(woospca_sort_order) AS max_val FROM ' . $wpdb->woospca_custom_endpoints));
		$previous_eps = $previous_eps[0]->max_val;
		
		$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->woospca_custom_endpoints
			(woospca_name, woospca_content, woospca_icon, woospca_is_hide, woospca_children, woospca_sort_order, woospca_type, woospca_new_tab, woospca_default, woospca_slug, woospca_customer_role) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $woospca_label_ep, $woospca_editor_ep_id, $woospca_icons, $woospca_hide_ep, $woospca_children, esc_attr($previous_eps + 1), sanitize_text_field($woospca_type), $newtab, $woospca_default, $woospca_slug_ep, serialize($woospca_customer_role )) );
		$id = $wpdb->insert_id;
		echo esc_attr($id);
		wp_die();

	}
	public function woospca_activation_plugin_for_my_account_page() {
		$woospca_save_All_general_settings_db_in=get_option('woospca_save_All_general_settings_db_in');
		if ('' == $woospca_save_All_general_settings_db_in) {
			$woospca_def_gen_settings=array(
				'woospca_is_avatar' => 'true',
				'woospca_is_upload_avatar' => 'true',
				'woospca_is_logout' => 'true',
				'woospca_avatar_radius' => '10',
				'woospca_menu_pos' => 'leftside',
				'woospca_menu_style' => 'woospca_menu_styleb',
				'woospca_p_t' => '5',
				'woospca_p_r' => '5',
				'woospca_p_b' => '5',
				'woospca_p_l' => '5',
				'woospca_d_bd_c' => 'F4F3E0',
				'woospca_d_t_c' => '000000',
				'woospca_d_brdrandcorner_c' => '858585',
				'woospca_a_bg_c' => '8B8B8B',
				'woospca_a_t_c' => 'FFFFFF',
				'woospca_a_brdrandcorner_c'=> '2B2B2B',
				'woospca_h_bg_c' => 'FFFFFF',
				'woospca_h_t_c' => '000000',
				'woospca_h_brdrandcorner_c' => '858585',

				'woospca_d_bd_c2' => 'FFFFFF',
				'woospca_d_t_c2' => '000000',
				'woospca_d_brdrandcorner_c2' => 'CFCFCF',

				'woospca_a_bg_c2' => 'CFCFCF',
				'woospca_a_t_c2' => '000000',
				'woospca_a_brdrandcorner_c2' => '919191',

				'woospca_h_bg_c2' => 'F0F0F0',
				'woospca_h_t_c2' => '000000',
				'woospca_h_brdrandcorner_c2' => 'CFCFCF',

				'woospca_d_brdrandcorner_c2bb' => '919191',
				'woospca_a_brdrandcorner_c2bb' => '1A1A1A',
				'woospca_h_brdrandcorner_c2bb' => '919191',

				'woospca_brdr_rdiis' => '5',
				'woospca_logout_bg_clr' => 'FF2121',
				'woospca_logout_t_clr' => 'FFFFFF',
				'woospca_btdb_bg_clr' => 'ae7b3b',
				'woospca_btdb_t_clr' => 'FFFFFF',
			);
			update_option('woospca_save_All_general_settings_db_in', $woospca_def_gen_settings);
		}

		global $wpdb;
		$wpdb->woospca_custom_endpoints = $wpdb->prefix . 'woospca_custom_endpoints';


		$this->woospca_create_tbl_in_db();
		$this->woospca_save_data_activation();
	}

	public function woospca_create_tbl_in_db() {
		global $wpdb;
		if ( $wpdb->get_var( $wpdb->prepare("SHOW TABLES LIKE '$wpdb->woospca_custom_endpoints'" , '')) != $wpdb->woospca_custom_endpoints ) {
			$sql = 'CREATE TABLE ' . $wpdb->woospca_custom_endpoints . ' (woospca_id int(25) NOT NULL auto_increment, woospca_name varchar(255) NULL, woospca_content varchar(5000) NULL, woospca_icon varchar(255) NULL, woospca_is_hide int(25) NOT NULL, woospca_children varchar(255) NULL, woospca_sort_order int(25) NULL, woospca_type varchar(255) NULL, woospca_new_tab int(25) NULL, woospca_default int(25) NULL, woospca_slug varchar(255) NULL, woospca_customer_role varchar(255) NULL, PRIMARY KEY (woospca_id));';
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
	}
	public function woospca_save_data_activation() {
		global $wpdb;
		if ( $wpdb->get_var( $wpdb->prepare("SHOW TABLES LIKE '$wpdb->woospca_custom_endpoints'" , '')) == $wpdb->woospca_custom_endpoints ) {

			$result = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->woospca_custom_endpoints , ''));

			if ( count($result)==0 ) {
				$this->woospca_insert_default_endpoints();
			}
		}
	}

	public function woospca_insert_default_endpoints() {
		global $wpdb;
		$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->woospca_custom_endpoints (woospca_name, woospca_content, woospca_icon, woospca_is_hide, woospca_children, woospca_sort_order, woospca_type, woospca_new_tab, woospca_default, woospca_slug, woospca_customer_role) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", esc_html('Dashboard', 'woospca'), '', 'tachometer', '777', 'after', '1', 'endpoint', '777', '1', 'dashboard', '') );

		$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->woospca_custom_endpoints (woospca_name, woospca_content, woospca_icon, woospca_is_hide, woospca_children, woospca_sort_order, woospca_type, woospca_new_tab, woospca_default, woospca_slug, woospca_customer_role) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", esc_html('Orders', 'woospca'), '', 'opencart', '777', 'after', '2', 'endpoint', '777', '1', 'orders', '') );

		$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->woospca_custom_endpoints (woospca_name, woospca_content, woospca_icon, woospca_is_hide, woospca_children, woospca_sort_order, woospca_type, woospca_new_tab, woospca_default, woospca_slug, woospca_customer_role) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", esc_html('Downloads', 'woospca'), '', 'download', '777', 'after', '3', 'endpoint', '777', '1', 'downloads', ''	) );

		$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->woospca_custom_endpoints
			(woospca_name, woospca_content, woospca_icon, woospca_is_hide, woospca_children, woospca_sort_order, woospca_type, woospca_new_tab, woospca_default, woospca_slug,woospca_customer_role) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", esc_html('Address', 'woospca'), '', 'home', '777', 'after', '4', 'endpoint', '777', '1', 'edit-address', '') );

		$wpdb->query($wpdb->prepare("INSERT INTO $wpdb->woospca_custom_endpoints (woospca_name, woospca_content, woospca_icon, woospca_is_hide, woospca_children, woospca_sort_order, woospca_type, woospca_new_tab, woospca_default, woospca_slug,woospca_customer_role) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s)", esc_html('Account Details', 'woospca'), '', 'user', '777', 'after', '5', 'endpoint', '777', '1', 'edit-account',	'') );
	}

	public function woospca_get_all_enpoints_from_db () {
		
		$get_plugify_ends = $this->plgfy_cud_get_all_endpoints_custom_default();

		$all_endpoints_woospca = $get_plugify_ends;

		foreach ($all_endpoints_woospca as $key => $value) {
			$woospca_def_ep=$value->woospca_default;

			$woospca_ep_type = ucfirst($value->woospca_type);

			if ('1' != $woospca_def_ep) {
				$woospca_def_ep='No';
			} else {
				$woospca_def_ep= 'Yes';
			}


			$woospca_row = array(
				'serial_no' => $key+1,
				'Endpoint Name' => $value->woospca_name,
				'Endpoint Icon' => '<i class="fa fa-fw fa-' . $value->woospca_icon . '"></i> ' . $value->woospca_icon,
				'Endpoint Type' =>  $woospca_ep_type,
				'Endpoint Sort Order' => $value->woospca_sort_order,
				'DefaultEndpoint' => $woospca_def_ep,
				'Action' => $value->woospca_id,
				'slug' => $value->woospca_slug,
				'woospca_default' => $value->woospca_default,

			);
			$return_json[] = $woospca_row;

		}

		echo json_encode(array('data' => $return_json));
		wp_die();
	}

	public function get_plugify_ends_admin() {
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

	public function plugify_add_thirdparty_endpoints ( $def_slugs ) {
		// show Membership endpoint in backend rules
		if ( in_array( 'woocommerce-memberships/woocommerce-memberships.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$def_slugs['members-area']='Memberships';
		}


		// show subscriptions endpoint in backend rules
		if ( in_array( 'woocommerce-subscriptions/woocommerce-subscriptions.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$def_slugs['subscriptions']='Subscriptions';
		}


		// show Support Ticlet System endpoint in backend rules
		if ( in_array( 'support-ticket-system-for-woocommerce/support-ticket-system-for-woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$def_slugs['plgfysts_cep']='Manage Tickets';
		}


		// show Make an Offer endpoint in backend rules
		if ( in_array( 'make-an-offer-for-woocommerce/make-an-offer-for-woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$def_slugs['plgfymao_cep']='Product Offers';
		}



		return $def_slugs;
	}

	public function plgfy_cud_get_all_endpoints_custom_default() {

		$get_plugify_ends=$this->get_plugify_ends_admin();

		$def_slugs=wc_get_account_menu_items();

		$index_to_unset = array();

		$def_slugs = $this->plugify_add_thirdparty_endpoints($def_slugs);

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

					if ( '2' == $value12->woospca_default) {
						if (!isset($def_slugs[$value12->woospca_slug])) {
							array_push($index_to_unset, $key12);
						}
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

		foreach ($index_to_unset as $key_index => $value_index) {
			unset($get_plugify_ends[$value_index]);
		}

		return $get_plugify_ends;
	}


} 
new Woospca_Main_Class_Alpha();

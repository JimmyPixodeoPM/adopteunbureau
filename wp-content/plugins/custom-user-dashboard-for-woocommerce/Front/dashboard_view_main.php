<?php

	$get_plugify_ends = plgfy_cud_get_all_endpoints_custom_default();


$index=0;

//gen settings
$woospca_save_All_general_settings_db_in=get_option('woospca_save_All_general_settings_db_in');
$woospca_is_avatar=$woospca_save_All_general_settings_db_in['woospca_is_avatar'];

$woospca_is_upload_avatar=$woospca_save_All_general_settings_db_in['woospca_is_upload_avatar'];			
$woospca_is_logout=$woospca_save_All_general_settings_db_in['woospca_is_logout'];			
$woospca_avatar_radius=$woospca_save_All_general_settings_db_in['woospca_avatar_radius'];
$woospca_menu_pos=$woospca_save_All_general_settings_db_in['woospca_menu_pos'];
$woospca_menu_style=$woospca_save_All_general_settings_db_in['woospca_menu_style'];
$woospca_p_t=$woospca_save_All_general_settings_db_in['woospca_p_t'];
$woospca_p_r=$woospca_save_All_general_settings_db_in['woospca_p_r'];
$woospca_p_b=$woospca_save_All_general_settings_db_in['woospca_p_b'];
$woospca_p_l=$woospca_save_All_general_settings_db_in['woospca_p_l'];

$woospca_d_bg_c=$woospca_save_All_general_settings_db_in['woospca_d_bd_c'];
$woospca_d_t_c=$woospca_save_All_general_settings_db_in['woospca_d_t_c'];
$woospca_d_brdrandcorner_c=$woospca_save_All_general_settings_db_in['woospca_d_brdrandcorner_c'];
$woospca_a_bg_c=$woospca_save_All_general_settings_db_in['woospca_a_bg_c'];
$woospca_a_t_c=$woospca_save_All_general_settings_db_in['woospca_a_t_c'];
$woospca_a_brdrandcorner_c=$woospca_save_All_general_settings_db_in['woospca_a_brdrandcorner_c'];
$woospca_h_bg_c=$woospca_save_All_general_settings_db_in['woospca_h_bg_c'];
$woospca_h_t_c=$woospca_save_All_general_settings_db_in['woospca_h_t_c'];
$woospca_h_brdrandcorner_c=$woospca_save_All_general_settings_db_in['woospca_h_brdrandcorner_c'];

$woospca_d_bg_c2=$woospca_save_All_general_settings_db_in['woospca_d_bd_c2'];
$woospca_d_t_c2=$woospca_save_All_general_settings_db_in['woospca_d_t_c2'];
$woospca_d_brdrandcorner_c2=$woospca_save_All_general_settings_db_in['woospca_d_brdrandcorner_c2'];
$woospca_a_bg_c2=$woospca_save_All_general_settings_db_in['woospca_a_bg_c2'];
$woospca_a_t_c2=$woospca_save_All_general_settings_db_in['woospca_a_t_c2'];
$woospca_a_brdrandcorner_c2=$woospca_save_All_general_settings_db_in['woospca_a_brdrandcorner_c2'];
$woospca_h_bg_c2=$woospca_save_All_general_settings_db_in['woospca_h_bg_c2'];
$woospca_h_t_c2=$woospca_save_All_general_settings_db_in['woospca_h_t_c2'];
$woospca_h_brdrandcorner_c2=$woospca_save_All_general_settings_db_in['woospca_h_brdrandcorner_c2'];
$woospca_d_brdrandcorner_c2bb=$woospca_save_All_general_settings_db_in['woospca_d_brdrandcorner_c2bb'];
$woospca_a_brdrandcorner_c2bb=$woospca_save_All_general_settings_db_in['woospca_a_brdrandcorner_c2bb'];
$woospca_h_brdrandcorner_c2bb=$woospca_save_All_general_settings_db_in['woospca_h_brdrandcorner_c2bb'];
$woospca_logout_bg_clr=$woospca_save_All_general_settings_db_in['woospca_logout_bg_clr'];
$woospca_logout_t_clr=$woospca_save_All_general_settings_db_in['woospca_logout_t_clr'];




$woospca_brdr_rdiis=$woospca_save_All_general_settings_db_in['woospca_brdr_rdiis'];

//get prof img
$upload_dir = wp_upload_dir();
$baseurl='';
if ( ! empty( $upload_dir['baseurl'] ) ) {
	$baseurl = $upload_dir['baseurl'] . '/Uploaded_users_images/';
}

$current_user_woospca=wp_get_current_user();
$current_user_name=ucfirst($current_user_woospca->display_name);
$woospca_existed_user_profile=get_user_meta(get_current_user_ID(), '_woospca_current_user_profile', true);
if ('' == $woospca_existed_user_profile) {
	$woospca_existed_user_profile='dummy.jpeg';
}
$current_user_profile_url=$baseurl . $woospca_existed_user_profile;


$user_meta=wp_get_current_user();
$user_roles=$user_meta->roles;


?>

<div class="woocommerce">
	<div class="plugify_container" style="margin:1%; padding:5%; width: 100%;box-shadow: 0px 5px 20px 3px rgba(0, 0, 0, 0.2), 1px 2px 11px 2px rgba(0, 0, 0, 0.29);border-radius: 4px;">
		<div class="woocommerce-MyAccount-navigation plugify_woo_li_prnt">
			<div class="plugify_avatar_div" style="width: auto;">
				<?php
				if ('true' == $woospca_is_avatar) {
					?>
				
					<center>
						<div class="avatar-upload" style="width:150px; height: 150px;">
							<?php
							if ('true' == $woospca_is_upload_avatar) {
								?>
								<div class="avatar-edit">
									<input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
									<label for="imageUpload">
										<i style="position:absolute;top:8px;left:10px;" class="fa fa-fw fa-pencil-square-o"></i>
									</label>
								</div>
								<?php
							}
							?>

							<center><img  class="avatar-preview" id="imagePreview" src="<?php echo filter_var($current_user_profile_url); ?>">
							</center>
							

						</div>
					</center>
						<br>
					
					<?php
				}
				?>
				
				<center>
					<strong style="font-size: 18px;"><?php echo esc_attr($current_user_name); ?></strong>
				</center>
				<center>
					<span style="font-size: 13px;"><?php echo esc_attr($current_user_woospca->user_email); ?></span>
				</center>
				<?php
				if ('true' == $woospca_is_logout) {
					?>
					<center> 
						<button class="button-primary logout_woospca_btn" value="<?php echo esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ); ?>" style="color:#<?php echo filter_var( $woospca_logout_t_clr); ?>;background: #<?php echo filter_var($woospca_logout_bg_clr); ?>;border-radius: 4px;padding: 4px 6px 4px 6px;">Logout <i class="fas fa-sign-out-alt"></i>
						</button>
					</center>
					<br>
					<?php
				}
				?>
			</div>
			<ul  class="plugify_nav_menu_div">
				<?php


				foreach ($get_plugify_ends as $key_custom => $custom_endpoint) {


					$is_valid_user = true;
					$woospca_arrrrrrrr=array();

					if ('' != $custom_endpoint->woospca_customer_role && 's:0:"";' != $custom_endpoint->woospca_customer_role && 'N;' != $custom_endpoint->woospca_customer_role) {

						$woospca_arrrrrrrr=unserialize($custom_endpoint->woospca_customer_role);

						$is_valid_user = false;
						foreach ($woospca_arrrrrrrr as $key1 => $value1) {
							if (in_array($value1, $user_roles)) {
								$is_valid_user = true;
							}
						}

					}


					if (!$is_valid_user) {
						continue;
					}



					if (0==$index) {
						$class_active=' active_class ';
					}
					$show_hide = '';
					if (111==$custom_endpoint->woospca_is_hide) {
						continue;
					}
					$index++;
					?>
					<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--<?php echo filter_var( $custom_endpoint->woospca_slug); ?> plugify_main_nav_li <?php echo filter_var( $class_active); ?>" id-attr="plugify_<?php echo filter_var( $custom_endpoint->woospca_slug); ?>" ep_type='<?php echo filter_var( $custom_endpoint->woospca_type); ?>' >
						<?php

						if ('link' == $custom_endpoint->woospca_type || 'page' == $custom_endpoint->woospca_type) {

							$href=$custom_endpoint->woospca_children;
							if ('page'==$custom_endpoint->woospca_type) {
								$href=get_permalink($custom_endpoint->woospca_children);
							}


							$target='';
							if ('111'==$custom_endpoint->woospca_new_tab) {
								$target='_blank';
							}

							?>


							<a style="display:contents;" target="<?php echo filter_var($target); ?>" href="<?php echo filter_var($href); ?>">
								<?php 
								echo '<div class="plugify_li_content"><span  style="width:90%">' . filter_var($custom_endpoint->woospca_name) . '</span> <i class="plugify_custom_icons fa fa-fw fa-' . filter_var($custom_endpoint->woospca_icon) . '"></i></div>'; 
								?>
							</a>

							<?php
						} else if ('group' == $custom_endpoint->woospca_type) {

							$endpoint_name = $custom_endpoint->woospca_name;
							$endpoint_icon = $custom_endpoint->woospca_icon;
							echo '<div  class="plugify_li_content"><span  style="width:90%">' . filter_var($endpoint_name) . '</span> <i class="plugify_custom_icons fa fa-fw fa-' . filter_var($endpoint_icon) . '"></i></div>'; 
							$group_children = unserialize($custom_endpoint->woospca_children);
							echo '<ul class="plugify_group_main" >';


							foreach ($get_plugify_ends as $custom_group_key => $custom_group_value) {

								$is_valid_user = true;
								$woospca_arrrrrrrr=array();

								if ('' != $custom_group_value->woospca_customer_role && 's:0:"";' != $custom_group_value->woospca_customer_role && 'N;' != $custom_group_value->woospca_customer_role) {

									$woospca_arrrrrrrr=unserialize($custom_group_value->woospca_customer_role);

									$is_valid_user = false;
									foreach ($woospca_arrrrrrrr as $key1 => $value1) {
										if (in_array($value1, $user_roles)) {
											$is_valid_user = true;
										}
									}

								}


								if (!$is_valid_user) {
									continue;
								}


								if ( is_array($group_children) && in_array($custom_group_value->woospca_id, $group_children)) {


									if ('link' == $custom_group_value->woospca_type || 'page' == $custom_group_value->woospca_type) {

										$href=$custom_group_value->woospca_children;
										if ('page'==$custom_group_value->woospca_type) {
											$href=get_permalink($custom_group_value->woospca_children);
										}


										$target='';
										if ('111'==$custom_group_value->woospca_new_tab) {
											$target='_blank';
										}

										?>


										<a style="display:contents;" target="<?php echo filter_var($target); ?>" href="<?php echo filter_var($href); ?>">
											<?php 
											echo '<li class="plugify_main_nav_li plugify_group_child" ep_type="group_child" id-attr="plugify_' . filter_var($custom_group_value->woospca_slug) . '" > <div class="plugify_li_content"><span  style="width:90%">' . filter_var($custom_group_value->woospca_name) . '</span> <i class="plugify_custom_icons fa fa-fw fa-' . filter_var($custom_group_value->woospca_icon) . '"></i></div><li>'; 
											?>
										</a>

										<?php
									} else {

										echo '<li class="plugify_main_nav_li plugify_group_child" ep_type="group_child" id-attr="plugify_' . filter_var($custom_group_value->woospca_slug) . '" > <div class="plugify_li_content"><span style="width:90%">' . filter_var($custom_group_value->woospca_name) . '</span> <i class="plugify_custom_icons fa fa-fw fa-' . filter_var($custom_group_value->woospca_icon) . '"></i> </div> </li>';
									}





								}
							}
							echo '</ul>';
						} else {
							$endpoint_name = $custom_endpoint->woospca_name;
							$endpoint_icon = $custom_endpoint->woospca_icon;

							echo '<div class="plugify_li_content"><span style="width:90%">' . filter_var($endpoint_name) . '</span> <i class="plugify_custom_icons fa fa-fw fa-' . filter_var($endpoint_icon) . '"></i></div>'; 

						}



						?>
					</li>
					<?php
				}
				?>


			</ul>




		</div>
		<div class="woocommerce-MyAccount-content">
			<?php
			foreach ($get_plugify_ends as $key_custom => $custom_endpoint) {

				$is_valid_user = true;
				$woospca_arrrrrrrr=array();
				if ('' != $custom_endpoint->woospca_customer_role && 's:0:"";' != $custom_endpoint->woospca_customer_role && 'N;' != $custom_endpoint->woospca_customer_role) {
					
					$woospca_arrrrrrrr=unserialize($custom_endpoint->woospca_customer_role);
					
					$is_valid_user = false;
					foreach ($woospca_arrrrrrrr as $key1 => $value1) {
						if (in_array($value1, $user_roles)) {
							$is_valid_user = true;
						}
					}

				}


				if (!$is_valid_user) {
					continue;
				}





				if ( '0' != $custom_endpoint->woospca_default ) {
					$show_hide = '';
					if (111==$custom_endpoint->woospca_is_hide) {
						continue;
					}

					if ('dashboard' == $custom_endpoint->woospca_slug) {
						?>
						<div id="plugify_<?php echo filter_var($custom_endpoint->woospca_slug); ?>" class="hide_class plugify_content_main" style="display: none;">

							<h1><?php echo filter_var($custom_endpoint->woospca_name); ?></h1> <hr>

							<?php
							if ('before' == $custom_endpoint->woospca_children) {

								echo filter_var(apply_filters( 'woocommerce_short_description', stripcslashes($custom_endpoint->woospca_content) ));
								include 'dashboard_template.php';
							} else if ('override' == $custom_endpoint->woospca_children) {
								echo filter_var(apply_filters( 'woocommerce_short_description', stripcslashes($custom_endpoint->woospca_content) ));

							} else {
								include 'dashboard_template.php';
								echo filter_var(apply_filters( 'woocommerce_short_description', stripcslashes($custom_endpoint->woospca_content) ));
							}
							?>
							<br>
						</div>



						<?php
					} else if ('members-area' == $custom_endpoint->woospca_slug) {
						?>
						<div  id="plugify_<?php echo filter_var($custom_endpoint->woospca_slug); ?>" class="hide_class plugify_content_main" style="display: none;">
						<h1><?php echo filter_var($custom_endpoint->woospca_name); ?></h1> <hr>
						<?php


						if ('before' == $custom_endpoint->woospca_children) {
							echo filter_var(apply_filters( 'woocommerce_short_description', stripcslashes($custom_endpoint->woospca_content) ));

							do_action( 'wc_memberships_before_my_memberships' );

							wc_get_template( 'myaccount/my-memberships.php', array(
								'customer_memberships' => wc_memberships_get_user_memberships(),
								'user_id'              => get_current_user_id(),
							) );
							do_action( 'wc_memberships_after_my_memberships' );

						} else if ('override' == $custom_endpoint->woospca_children) {
							echo filter_var(apply_filters( 'woocommerce_short_description', stripcslashes($custom_endpoint->woospca_content) ));
						} else {

							do_action( 'wc_memberships_before_my_memberships' );

							wc_get_template( 'myaccount/my-memberships.php', array(
								'customer_memberships' => wc_memberships_get_user_memberships(),
								'user_id'              => get_current_user_id(),
							) );
							do_action( 'wc_memberships_after_my_memberships' );

							echo filter_var(apply_filters( 'woocommerce_short_description', stripcslashes($custom_endpoint->woospca_content) ));
						}

						?>
					<br>
				</div>
						<?php

					} else {

							$show_hide = '';
						if (111==$custom_endpoint->woospca_is_hide) {
							$show_hide=' style="display:none;" ';
						}

						?>
							<div  id="plugify_<?php echo filter_var($custom_endpoint->woospca_slug); ?>" class="hide_class plugify_content_main" style="display: none;">
								
								<h1><?php echo filter_var($custom_endpoint->woospca_name); ?></h1> <hr>

								<?php
		
								if ('before' == $custom_endpoint->woospca_children) {
									echo filter_var(apply_filters( 'woocommerce_short_description', stripcslashes($custom_endpoint->woospca_content) ));
									echo filter_var(do_action('woocommerce_account_' . $custom_endpoint->woospca_slug . '_endpoint'));
								} else if ('override' == $custom_endpoint->woospca_children) {
									echo filter_var(apply_filters( 'woocommerce_short_description', stripcslashes($custom_endpoint->woospca_content) ));
								} else {
									echo filter_var(do_action('woocommerce_account_' . $custom_endpoint->woospca_slug . '_endpoint'));
									echo filter_var(apply_filters( 'woocommerce_short_description', stripcslashes($custom_endpoint->woospca_content) ));
								}

								?>
								<br>
								<br>
							</div>
							<?php
					}
					
				} else {

					?>
					<div id="plugify_<?php echo filter_var($custom_endpoint->woospca_slug); ?>" class="hide_class plugify_content_main" style="display: none;">
						<?php
						echo filter_var( apply_filters( 'woocommerce_short_description', stripcslashes($custom_endpoint->woospca_content) ));
						?>
						<br>
					</div>



					<?php
					

				}

			}

			?>



		</div>
	</div>
</div>


<script type="text/javascript">

	jQuery(document).ready(function(){
		


		jQuery('body').on('click', '.plugify_main_nav_li', function(){
			
			if(jQuery(this).attr('ep_type') != 'group') {
				jQuery('.hide_class').hide();
				jQuery('.plugify_main_nav_li').removeClass('active_class');
				jQuery('#'+jQuery(this).attr('id-attr')).show();

				jQuery(this).addClass('active_class');
				if (jQuery(this).attr('ep_type') == 'group_child') {
					jQuery(this).parent().parent().addClass('active_class')
				}
			}
		});
		jQuery('.plugify_main_nav_li:first').trigger('click');
		jQuery('.plugify_main_nav_li:first').click();

		//upload profile image
		jQuery('.woospca_vis_hdddn').css('filter','unset');
			
				function readURL_woospca(input) {
					formdata = formnames = [], loadfiles = [];
					if(window.FormData) {
						formdata = new FormData();
					}
					if (input.files && input.files[0]) {
						var file_data = input.files[0];
						
						var woospca_image_src=URL.createObjectURL(input.files[0]);
						
						var nameofimage=input.files[0].name;
						formdata.append('imagePreview', file_data);
						
						jQuery.ajax({
							url: '<?php echo filter_var(admin_url('admin-ajax.php')); ?>'+"?action=woospca_upload_image_tod&id=imagePreview&woospca_image_src="+woospca_image_src+"&nameofimage="+nameofimage,
							cache : false,
							contentType : false,
							processData : false,
							data : formdata, 
							type : 'post',
							success: function(result) {
								jQuery('#imagePreview').attr('src', woospca_image_src );
							}
						});


					}
				}
				jQuery("#imageUpload").change(function() {

					readURL_woospca(this);
				});
				jQuery('.logout_woospca_btn').on('click', function(){

					window.location.assign(jQuery(this).val());
				});



				jQuery('[ep_type="group"]').on('mouseenter', function(){

					jQuery(this).find('.plugify_group_main').fadeIn(500);

				});

				jQuery('[ep_type="group"]').on('mouseleave', function(){

					jQuery(this).find('.plugify_group_main').hide();

				});



	});


</script>
<?php

if ('leftside' == $woospca_menu_pos) {
	?>
	<style type="text/css">

		.plugify_container{
			display: inline-flex;
			padding: 10px;
		}
		.woocommerce-MyAccount-navigation{
			float: unset;
			width: 30%;
		}
		.woocommerce-MyAccount-content{
			float: unset;
			width: 70%;
		}
		.woocommerce-MyAccount-navigation ul{
			border:unset !important;
		}

		.plugify_group_main {
			width:100% !important;
			position:absolute;
			left: 100% !important;
			top: -17%  !important;
		}
		.plugify_group_child {
			width: 100% !important;
		}

		.plugify_li_content {
			display: contents;
		}
		
	</style>
	<?php
} else if ('rightside' == $woospca_menu_pos ) {
	?>
	<style type="text/css">
		.plugify_container{
			display: inline-flex;
			padding: 10px;
			flex-direction: row-reverse;
		}
		.woocommerce-MyAccount-navigation{
			float: unset;
			width: 30%;
		}
		.woocommerce-MyAccount-content{
			float: unset;

			width: 70%;
		}
		.woocommerce-MyAccount-navigation ul{
			border:unset !important;
		}

		.plugify_woo_li_prnt{
			margin: unset !important;
			margin-left: 5% !important;
		}

		.plugify_group_main {
			width:100%;
			position:absolute;
			left: -100% !important;
			top: -17% !important;
		}
		.plugify_group_child {
			width: 90% !important;
		}
		.plugify_li_content {
			display: contents;
		}
		
	</style>
	<?php
} else if ('topside' == $woospca_menu_pos) {
	?>
	<style type="text/css">

		.plugify_container{
			display: grid;
			padding: 10px;
		}
		.woocommerce-MyAccount-navigation{
			width: 100%;
			display: contents;
		}
		.woocommerce-MyAccount-content{
			width: 100%;
		}
		.woocommerce-MyAccount-navigation ul{
			border:unset !important;
		}	
		.plugify_main_nav_li{
			display: inline-flex !important;
		}

		.plugify_group_main {
			width:100% !important;
			position:absolute;
			top: 100% !important;
		}
		.plugify_group_child {
			width: 100% !important;
			display: block !important;
		}	


		.plugify_woo_li_prnt{
			display: flex;
		}

		.plugify_avatar_div {
			width: 30% !important;
		}

		.plugify_nav_menu_div {
			width: 70% !important;
		}

		.plugify_li_content {
			display: flex;
			align-items: center;
		}

	</style>
	<?php
}




if ('woospca_menu_styleb' == $woospca_menu_style) {
	?>
	<style type="text/css">
	.plugify_main_nav_li{
		margin: <?php echo filter_var($woospca_p_t . 'px ' . $woospca_p_r . 'px ' . $woospca_p_b . 'px ' . $woospca_p_l . 'px '); ?> !important;
		padding: 5px 10px !important;
		border-radius: <?php echo filter_var($woospca_brdr_rdiis); ?>px !important;
		cursor: pointer;
		background-color: #<?php echo filter_var($woospca_d_bg_c2); ?> !important;
		background: #<?php echo filter_var($woospca_d_bg_c2); ?> !important;
		color: #<?php echo filter_var($woospca_d_t_c2); ?> !important;
		border: 1px solid #<?php echo filter_var($woospca_d_brdrandcorner_c2bb); ?> !important;
		box-shadow: 1px 2px 8px 1px #<?php echo filter_var($woospca_d_brdrandcorner_c2); ?>, 1px 2px 4px 0px #<?php echo filter_var($woospca_d_brdrandcorner_c2); ?>;
		display: flex;
		align-items: center;
	}
	.plugify_main_nav_li:hover {
		border: 1px solid #<?php echo filter_var($woospca_h_brdrandcorner_c2bb); ?> !important;
		color: #<?php echo filter_var($woospca_h_t_c2); ?> !important;
		background-color: #<?php echo filter_var($woospca_h_bg_c2); ?> !important;
		box-shadow: 1px 2px 8px 1px #<?php echo filter_var($woospca_h_brdrandcorner_c2); ?>, 1px 2px 4px 0px #<?php echo filter_var($woospca_h_brdrandcorner_c2); ?> !important;


	}
	.active_class {
		border: 1px solid #<?php echo filter_var($woospca_a_brdrandcorner_c2bb); ?> !important;
		background: #<?php echo filter_var($woospca_a_bg_c2); ?> !important;
		color: #<?php echo filter_var($woospca_a_t_c2); ?> !important;
		box-shadow: 1px 2px 8px 1px #<?php echo filter_var($woospca_a_brdrandcorner_c2); ?>, 1px 2px 4px 0px #<?php echo filter_var($woospca_a_brdrandcorner_c2); ?> !important;


	}
	</style>
	<?php
} else {
	?>
	<style type="text/css">
		.plugify_main_nav_li{
			margin: <?php echo filter_var($woospca_p_t . 'px ' . $woospca_p_r . 'px ' . $woospca_p_b . 'px ' . $woospca_p_l . 'px '); ?> !important;
			padding: 5px 10px !important;
			cursor: pointer;
			background-color: #<?php echo filter_var($woospca_d_bg_c); ?> !important;
			background: #<?php echo filter_var($woospca_d_bg_c); ?> !important;
			color: #<?php echo filter_var($woospca_d_t_c); ?> !important;
			border: none !important;
			display: flex;
			align-items: center;


			border-top: 3px solid #<?php echo filter_var($woospca_d_brdrandcorner_c); ?> !important;
			border-bottom: 3px solid #<?php echo filter_var($woospca_d_brdrandcorner_c); ?> !important;
		}
		.plugify_main_nav_li:hover {
			color: #<?php echo filter_var($woospca_h_t_c); ?> !important;
			background-color: #<?php echo filter_var($woospca_h_bg_c); ?> !important;
		
			border-top: 3px solid #<?php echo filter_var($woospca_h_brdrandcorner_c); ?> !important;
			border-bottom: 3px solid #<?php echo filter_var($woospca_h_brdrandcorner_c); ?> !important;

		}



		.plugify_main_nav_li:hover:before{
			content: "";
			border-top: 15px solid #<?php echo filter_var($woospca_h_brdrandcorner_c); ?>;
			border-right: 15px solid transparent;
			border-bottom: 15px solid transparent;
			position: absolute;
			top: 0;
			left: 0;
			transition: all 0.3s ease 0s;
		}

		.plugify_main_nav_li:hover:after{
			content: "";
			border-bottom: 15px solid  #<?php echo filter_var($woospca_h_brdrandcorner_c); ?>;
			border-left: 15px solid transparent;
			border-top: 15px solid transparent;
			position: absolute;
			bottom: 0;
			right: 0;
			transition: all 0.3s ease 0s;
		}

		.active_class {
			background: #<?php echo filter_var($woospca_a_bg_c); ?> !important;
			color: #<?php echo filter_var($woospca_a_t_c); ?> !important;
			border-top: 3px solid #<?php echo filter_var($woospca_a_brdrandcorner_c); ?> !important;
			border-bottom: 3px solid #<?php echo filter_var($woospca_a_brdrandcorner_c); ?> !important;
		}


		.active_class:hover {
			border-top: 3px solid #<?php echo filter_var($woospca_a_brdrandcorner_c); ?> !important;
			border-bottom: 3px solid #<?php echo filter_var($woospca_a_brdrandcorner_c); ?> !important;
		}

		.plugify_main_nav_li.active_class:before {
			content: "";
			border-top: 15px solid  #<?php echo filter_var($woospca_a_brdrandcorner_c); ?>;
			border-right: 15px solid transparent;
			border-bottom: 15px solid transparent;
			position: absolute;
			top: 0;
			left: 0;
			transition: all 0.3s ease 0s;
		}
		.plugify_main_nav_li.active_class:after {
			content: "";
			border-bottom: 15px solid  #<?php echo filter_var($woospca_a_brdrandcorner_c); ?>;
			border-left: 15px solid transparent;
			border-top: 15px solid transparent;
			position: absolute;
			bottom: 0;
			right: 0;
			transition: all 0.3s ease 0s;
		}


		.plugify_content_main {
			display: flow-root;
			border-top: 3px solid #<?php echo filter_var($woospca_a_brdrandcorner_c); ?>;
			border-bottom: 3px solid #<?php echo filter_var($woospca_a_brdrandcorner_c); ?>;
		}


		.plugify_content_main:before {
			content: "";
			border-top: 15px solid  #<?php echo filter_var($woospca_a_brdrandcorner_c); ?>;
			border-right: 15px solid transparent;
			border-bottom: 15px solid transparent;
			float: left;
			transition: all 0.3s ease 0s;
		}
		.plugify_content_main:after {
			content: "";
			border-bottom: 15px solid  #<?php echo filter_var($woospca_a_brdrandcorner_c); ?>;
			border-left: 15px solid transparent;
			border-top: 15px solid transparent;
			float: right;
			transition: all 0.3s ease 0s;
		}

	</style>
	<?php
}




?>
<style type="text/css">

	.woocommerce-MyAccount-navigation ul li a::before {
		content: unset;
	}

	.plugify_main_nav_li a{
		text-decoration: none !important;
		background-color: transparent !important;
		color: inherit !important;
		margin: unset !important;
		padding: unset !important;
		width: 100% !important;

	}
	.plugify_group_main {
		z-index: 9 !important;
	}


	@media screen and (max-width: 670px) {
		.plugify_main_nav_li{
			width: 100% !important;
		}
		.woocommerce-MyAccount-navigation{
			width: 100%;
			display: contents;
		}
		.woocommerce-MyAccount-content{
			width: 100%;
		}
		.woocommerce-MyAccount-navigation ul{
			border:unset !important;
		}	
		.plugify_main_nav_li{
			display: block;
		}

		.plugify_container {
			display: block;
		}

		.plugify_group_main {
			left: unset !important;
			top: unset !important;
			z-index: 99999;
		}

		.plugify_avatar_div {
			width: 100% !important;
		}

		.plugify_nav_menu_div {
			width: 100% !important;
		}
	}

	.avatar-upload {
		position: relative;


	}
	.avatar-edit {
		position: absolute;
		left: 130px;
		z-index: 1;
		top: 130px;

	}
	.avatar-upload .avatar-edit input{
		display: none;
	}
	.avatar-upload .avatar-edit input + label{
		display: inline-block;
		width: 34px;
		height: 34px;
		margin-bottom: 0;
		border-radius: 100%;
		background: #FFFFFF;
		border: 1px solid transparent;
		box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
		cursor: pointer;
		font-weight: normal;
		transition: all 0.2s ease-in-out
	}
	.avatar-upload .avatar-edit input + label:after {

		color: #757575;
		position: absolute;
		top: 10px;
		left: 0;
		right: 0;
		text-align: center;
		margin: auto;
	}
	.avatar-preview {
		width: 150px;
		height: 150px;
		position: relative;
		border-radius: <?php echo filter_var($woospca_avatar_radius); ?>px;
		border: 3px solid #F8F8F8;
		box-shadow:1px 2px 7px 4px rgba(0, 0, 0, 0.2), 1px 2px 4px 0px rgba(0, 0, 0, 0.29)

	}

	.plugify_group_main {
		display: none;
	}

/*	.plugify_custom_icons {*/
/*		font-family:"Font Awesome 5 Pro" !important;*/
/*	}*/



</style>

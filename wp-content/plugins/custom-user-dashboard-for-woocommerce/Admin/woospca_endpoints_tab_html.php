<?php
$get_plugify_ends=$this->plgfy_cud_get_all_endpoints_custom_default();

$woospca_all_endpoints = $get_plugify_ends;

?>
<input type="hidden" id="woospca_savediv">



<h3 style="font-weight:400; font-size: 21px;">	
	<i class="fa fa-hand-o-right" aria-hidden="true"></i>
	All Endpoints          
</h3>
<hr>
<table style="width: 100%;">
	<tr>
		<td style="vertical-align:bottom;float: right;">
			<button class="button-primary" type="button" style="background-color: green;border-color: green;" id="woospca_create_ep_at1">
			<i class="fa fa-fw fa-plus"></i>
			Add Endpoint(s)</button>
			<button class="button-primary" type="button" style="background-color: #ae7b3b;border-color: #ae7b3b;" id="woospca_sort_eps_at_time"><i class="fa fa-fw fa-sort"></i>Sort Endpoints</button>

		</td>
	</tr>
</table>
<br>
<br>

<table id="woospca_datatables" class="table table-striped" style="width: 100%;">
	<thead>
		<tr> 
			<th style="width:10%;" class="name"><?php echo esc_html__('Serial #' , 'woospca'); ?></th>
			<th class="name" ><?php echo esc_html__('Endpoint Name' , 'woospca'); ?></th>
			<th class="status" ><?php echo esc_html__('Endpoint Icon' , 'woospca'); ?></th>
			<th class="status" ><?php echo esc_html__('Endpoint Type' , 'woospca'); ?></th>
			<th class="status" ><?php echo esc_html__('Endpoint Sort Order' , 'woospca'); ?></th> 
			<th class="status" ><?php echo esc_html__('Default Endpoint' , 'woospca'); ?></th> 
			<th style="width: 20%;" class="status" ><?php echo esc_html__('Action' , 'woospca'); ?></th> 
			
		</tr>
	</thead>
	<tbody >
	</tbody>
	<tfoot>
		<tr>
			<th style="width:10%;" class="name"><?php echo esc_html__('Serial #' , 'woospca'); ?></th>
			<th class="name" ><?php echo esc_html__('Endpoint Name' , 'woospca'); ?></th>
			<th class="status" ><?php echo esc_html__('Endpoint Icon' , 'woospca'); ?></th>
			<th class="status" ><?php echo esc_html__('Endpoint Type' , 'woospca'); ?></th>
			<th class="status" ><?php echo esc_html__('Endpoint Sort Order' , 'woospca'); ?></th> 
			<th class="status" ><?php echo esc_html__('Default Endpoint' , 'woospca'); ?></th> 
			<th style="width: 20%;" class="status" ><?php echo esc_html__('Action' , 'woospca'); ?></th> 
			
		</tr>
	</tfoot>
</table>

<script type="text/javascript">
	
</script>



<div class="modal fade" id="myModaledit_ep" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="">
				<button type="button" class="close"style="color: #000 !important; opacity: 1;" data-dismiss="modal">&times;</button>
				<h2 class="modal-title" style="color: #000 !important; font-family: verdena;">Edit Endpoints</h2>
			</div>
			<div class="modal-body" >

			</div>

			<div class="modal-footer">
				<button style="float: left;" type="button" id="woospca_edit_ep_details" class="button-primary">Save</button>
				
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="myModalsortid" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content modal-content112">
			<div class="modal-header" style="">
				<button type="button" class="close"style="color: #000 !important; opacity: 1;" data-dismiss="modal">&times;</button>
				<h2 class="modal-title" style="color: #000 !important; font-family: verdena;">Sort Endpoints</h2>
			</div>
			<div class="modal-body" >
				
			</div>
			<div class="modal-footer">

				<button style="float: left;" type="button" id="woospca_save_sort_ep_btn" class="button-primary">Save</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myModal_woospca" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="">
				<button type="button" class="close"style="color: #000 !important; opacity: 1;" data-dismiss="modal">&times;</button>
				<h2 class="modal-title" style="color: #000 !important; font-family: verdena;">Customize Tabs</h2>
			</div>
			<div class="modal-body" >
				<div>
					<button value="ep" type="button" class="endpoint_woospca button-primary">
						<i class="fa fa-plus" aria-hidden="true"></i> 
						<?php echo esc_html__('Add Endpoint', 'woospca'); ?>
					</button>
					<button value="grp" type="button" class="endpoint_woospca button-primary">
						<i class="fa fa-plus" aria-hidden="true"></i> 
						<?php echo esc_html__('Add Group', 'woospca'); ?>
					</button>
					<button value="link" type="button" class="endpoint_woospca button-primary">
						<i class="fa fa-plus" aria-hidden="true"></i> 
						<?php echo esc_html__('Add Link', 'woospca'); ?>
					</button>
					<button value="page" type="button" class="endpoint_woospca button-primary">
						<i class="fa fa-plus" aria-hidden="true"></i> 
						<?php echo esc_html__('Add Page', 'woospca'); ?>
					</button>
				</div>
				<div id="woospca_main_retreival_div">
					<div id="woospca_ep_content" style="display: none;" class="woospca_hide_all_tabss animate__animated animate__zoomIn">
						<table style="width: 97%;" class="last_tbl_gnrl_stng">
							<tr>
								<td style="width: 30%;">
									<strong >Label<span style="color: red;">*</span></strong>
								</td>
								<td style="width: 70%;">
									<input type="text" id="woospca_label_ep" class="form-control ">
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Slug<span style="color: red;">*</span></strong>
								</td>
								<td style="width: 70%;">
									<input type="text" id="woospca_slug_ep" class="form-control ">
								</td>
							</tr>
							<tr class="woospca_icons_div">
								<td style="width: 30%;">
									<strong >Icon</strong>
								</td>
								<td style="width: 70%;">
									<select id="woospca_icons" class="form-control woospca_select" style="width: 100%;">
										<option value=""></option>
									</select>
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Hide?</strong>
								</td>
								<td style="width: 70%;">
									<input type="checkbox" id="woospca_hide_ep" class="form-control ">
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Allowed Roles</strong>
								</td>
								<td style="width: 70%;">
									<?php 
									global $wp_roles;
									$woospca_all_roles = $wp_roles->get_names();
									?>
									<select class="woospca_customer_roleclass" id="woospca_customer_role" multiple="multiple" class="form-control " style="width: 100%;">
										<?php
										foreach ($woospca_all_roles as $key_role => $value_role) {
											?>
											<option value="<?php echo filter_var($key_role); ?>"><?php echo filter_var(ucfirst($value_role)); ?></option>
											<?php
										}
										?>

									</select>
									<br><i style="color: green;">(Leave empty to allow all roles as selected)</i>
								</td>
							</tr>
						</table>				
						<div >
							<?php
							$woospca_content   = '';
							$woospca_editor_ep_id = 'woospca_editor_ep_id_ep';
							$woospca_settings_array = array(
								'editor_height' => 180
							);
							wp_editor( $woospca_content, $woospca_editor_ep_id, $woospca_settings_array );
							?>
						</div><br><br>


						

						
					</div>
					<div id="woospca_grp_content" style="display: none;" class="woospca_hide_all_tabss animate__animated animate__zoomIn">
						<table style="width: 97%;" class="last_tbl_gnrl_stng">
							<tr>
								<td style="width: 30%;">
									<strong >Label<span style="color: red;">*</span></strong>
								</td>
								<td style="width: 70%;">
									<input type="text" id="woospca_label_ep" class="form-control ">
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Slug<span style="color: red;">*</span></strong>
								</td>
								<td style="width: 70%;">
									<input type="text" id="woospca_slug_ep" class="form-control ">
								</td>
							</tr>
							<tr class="woospca_icons_div">
								<td style="width: 30%;">
									<strong >Icon</strong>
								</td>
								<td style="width: 70%;">
									<select id="woospca_icons" class="form-control woospca_select" style="width: 100%;">
										<option value=""></option>
									</select>
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Link Children</strong>
								</td>
								<td style="width: 70%;">
									<select  id="woospca_eps_All" multiple="multiple" style="width: 100%;">
										<?php   
										foreach ($woospca_all_endpoints as $endpoint) {
											?>
											<option value="<?php echo filter_var($endpoint->woospca_id); ?>">
												<?php echo esc_attr($endpoint->woospca_name); ?>
											</option>
											<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Allowed Roles</strong>
								</td>
								<td style="width: 70%;">
									<?php 
									global $wp_roles;
									$woospca_all_roles = $wp_roles->get_names();
									?>
									<select class="woospca_customer_roleclass" id="woospca_customer_role" multiple="multiple" class="form-control " style="width: 100%;">
										<?php
										foreach ($woospca_all_roles as $key_role => $value_role) {
											?>
											<option value="<?php echo filter_var($key_role); ?>"><?php echo filter_var(ucfirst($value_role)); ?></option>
											<?php
										}
										?>

									</select><br><i style="color: green;">(Leave empty to allow all roles as selected)</i>
								</td>
							</tr>
							
						</table>
						
						
						
						<br><br>
						
						
					</div>
					<div id="woospca_link_content" style="display: none;" class="woospca_hide_all_tabss animate__animated animate__zoomIn">
						<table style="width: 97%;" class="last_tbl_gnrl_stng">
							<tr>
								<td style="width: 30%;">
									<strong >Label<span style="color: red;">*</span></strong>
								</td>
								<td style="width: 70%;">
									<input type="text" id="woospca_label_ep" class="form-control ">
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Slug<span style="color: red;">*</span></strong>
								</td>
								<td style="width: 70%;">
									<input type="text" id="woospca_slug_ep" class="form-control ">
								</td>
							</tr>
							<tr class="woospca_icons_div">
								<td style="width: 30%;">
									<strong >Icon</strong>
								</td>
								<td style="width: 70%;">
									<select id="woospca_icons" class="form-control woospca_select" style="width: 100%;">
										<option value=""></option>
									</select>
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Add Link<span style="color: red;">*</span></strong>
								</td>
								<td style="width: 70%;">
									<input type="text" id="woospca_link_ep" class="form-control ">
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Open in new tab?</strong>
								</td>
								<td style="width: 70%;">
									<input type="checkbox" id="woospca_checknewtab_ep" class="form-control ">
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Hide?</strong>
								</td>
								<td style="width: 70%;">
									<input type="checkbox" id="woospca_hide_ep" class="form-control ">
								</td>
							</tr>
							
							<tr>
								<td style="width: 30%;">
									<strong >Allowed Roles</strong>
								</td>
								<td style="width: 70%;">
									<?php 
									global $wp_roles;
									$woospca_all_roles = $wp_roles->get_names();
									?>
									<select class="woospca_customer_roleclass" id="woospca_customer_role" multiple="multiple" class="form-control " style="width: 100%;">
										<?php
										foreach ($woospca_all_roles as $key_role => $value_role) {
											?>
											<option value="<?php echo filter_var($key_role); ?>"><?php echo filter_var(ucfirst($value_role)); ?></option>
											<?php
										}
										?>

									</select><br><i style="color: green;">(Leave empty to allow all roles as selected)</i>
								</td>
							</tr>
						</table>
						
						<br><br>
					
					</div>
					<div id="woospca_page_content" style="display: none;" class="woospca_hide_all_tabss animate__animated animate__zoomIn">
						<table style="width: 97%;" class="last_tbl_gnrl_stng">
							<tr>
								<td style="width: 30%;">
									<strong >Label<span style="color: red;">*</span></strong>
								</td>
								<td style="width: 70%;">
									<input type="text" id="woospca_label_ep" class="form-control ">
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Slug<span style="color: red;">*</span></strong>
								</td>
								<td style="width: 70%;">
									<input type="text" id="woospca_slug_ep" class="form-control ">
								</td>
							</tr>
							<tr class="woospca_icons_div">
								<td style="width: 30%;">
									<strong >Icon</strong>
								</td>
								<td style="width: 70%;">
									<select id="woospca_icons" class="form-control woospca_select" style="width: 100%;">
										<option value=""></option>
									</select>
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Choose Page</strong>
								</td>
								<td style="width: 70%;">
									<select  id="woospca_sel_page_ep"  style="width: 100%;">
										<?php
										$args = array(
											'post_type'    => 'page',
											'sort_column'  => 'menu_order'
										);
										$pages_woospca = get_pages( $args );

										?>

										<?php 
										foreach ($pages_woospca as $page1) {
											?>
											<option value="<?php echo esc_attr($page1->ID); ?>"><?php echo esc_attr($page1->post_title); ?></option>
											<?php
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Open in new tab?</strong>
								</td>
								<td style="width: 70%;">
									<input type="checkbox" id="woospca_checknewtab_ep" class="form-control ">
								</td>
							</tr>
							<tr>
								<td style="width: 30%;">
									<strong >Hide?</strong>
								</td>
								<td style="width: 70%;">
									<input type="checkbox" id="woospca_hide_ep" class="form-control ">
								</td>
							</tr>
							
							<tr>
								<td style="width: 30%;">
									<strong >Allowed Roles</strong>
								</td>
								<td style="width: 70%;">
									<?php 
									global $wp_roles;
									$woospca_all_roles = $wp_roles->get_names();
									?>
									<select class="woospca_customer_roleclass" id="woospca_customer_role" multiple="multiple" class="form-control " style="width: 100%;">
										<?php
										foreach ($woospca_all_roles as $key_role => $value_role) {
											?>
											<option value="<?php echo filter_var($key_role); ?>"><?php echo filter_var(ucfirst($value_role)); ?></option>
											<?php
										}
										?>

									</select><br><i style="color: green;">(Leave empty to allow all roles as selected)</i>
								</td>
							</tr>
						</table>
						
					
						<br><br>
						
					</div>
					
				</div>

			</div>
			<div class="modal-footer">

				<button style="float: left;" woospca_default="0" type="button" id="woospca_save_ep_btn" class="button-primary">Save</button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	
</script>

<style type="text/css">
		
	.last_tbl_gnrl_stng {
		font-family: Arial, Helvetica, sans-serif;
		border-collapse: collapse;
		width: 100%;
	}

	.last_tbl_gnrl_stng td, .last_tbl_gnrl_stng th {

		padding: 4px;
	}


						
	.modal-dialog{
		top: 6%;
	}
	.modal-content112{
		top: 4% !important;
	}
	.endpoint_woospca{
		background-color: green !important;
		border-color: unset !important;
	}
	.tabtop .active a{
		background-color: #ae7b3b !important;
		background: #ae7b3b !important;
	}

	.tabtop .active a:before{
		color: #ae7b3b !important;
	}
	.active_btn_woospca{
		background:#ae7b3b !important; 
	}
	.woospca_hide_all_tabss{
		padding: 15px;
		margin-top: 1%;
		border-radius: 4px;border: 1px solid #bdbdbd;
	}

</style>

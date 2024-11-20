<?php

$woospca_save_All_general_settings_db_in=get_option('woospca_save_All_general_settings_db_in');

$woospca_is_avatar=$woospca_save_All_general_settings_db_in['woospca_is_avatar'];
$woospca_is_avatarforlatest=$woospca_save_All_general_settings_db_in['woospca_is_avatar'];
if ('true' == $woospca_is_avatar) {
	$woospca_is_avatar = 'checked="checked"';
}
$woospca_is_upload_avatar=$woospca_save_All_general_settings_db_in['woospca_is_upload_avatar'];
if ('true' == $woospca_is_upload_avatar) {
	$woospca_is_upload_avatar = 'checked="checked"';
}
$woospca_is_logout=$woospca_save_All_general_settings_db_in['woospca_is_logout'];
if ('true' == $woospca_is_logout) {
	$woospca_is_logout = 'checked="checked"';
}

if (!isset($woospca_save_All_general_settings_db_in['woospca_btdb_t_clr'])) {
	$woospca_save_All_general_settings_db_in['woospca_btdb_t_clr'] = 'FFFFFF';
}

if (!isset($woospca_save_All_general_settings_db_in['woospca_btdb_bg_clr'])) {
	$woospca_save_All_general_settings_db_in['woospca_btdb_bg_clr'] = 'ae7b3b';
}


$woospca_avatar_radius=$woospca_save_All_general_settings_db_in['woospca_avatar_radius'];

$woospca_menu_pos=$woospca_save_All_general_settings_db_in['woospca_menu_pos'];
$woospca_menu_style=$woospca_save_All_general_settings_db_in['woospca_menu_style'];
$woospca_p_t=$woospca_save_All_general_settings_db_in['woospca_p_t'];
$woospca_p_r=$woospca_save_All_general_settings_db_in['woospca_p_r'];
$woospca_p_b=$woospca_save_All_general_settings_db_in['woospca_p_b'];
$woospca_p_l=$woospca_save_All_general_settings_db_in['woospca_p_l'];

$woospca_d_bd_c=$woospca_save_All_general_settings_db_in['woospca_d_bd_c'];
$woospca_d_t_c=$woospca_save_All_general_settings_db_in['woospca_d_t_c'];
$woospca_d_brdrandcorner_c=$woospca_save_All_general_settings_db_in['woospca_d_brdrandcorner_c'];
$woospca_a_bg_c=$woospca_save_All_general_settings_db_in['woospca_a_bg_c'];
$woospca_a_t_c=$woospca_save_All_general_settings_db_in['woospca_a_t_c'];
$woospca_a_brdrandcorner_c=$woospca_save_All_general_settings_db_in['woospca_a_brdrandcorner_c'];
$woospca_h_bg_c=$woospca_save_All_general_settings_db_in['woospca_h_bg_c'];
$woospca_h_t_c=$woospca_save_All_general_settings_db_in['woospca_h_t_c'];
$woospca_h_brdrandcorner_c=$woospca_save_All_general_settings_db_in['woospca_h_brdrandcorner_c'];

$woospca_d_bd_c2=$woospca_save_All_general_settings_db_in['woospca_d_bd_c2'];
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
$woospca_brdr_rdiis=$woospca_save_All_general_settings_db_in['woospca_brdr_rdiis'];
$woospca_logout_t_clr=$woospca_save_All_general_settings_db_in['woospca_logout_t_clr'];
$woospca_logout_bg_clr=$woospca_save_All_general_settings_db_in['woospca_logout_bg_clr'];


$woospca_btdb_t_clr=$woospca_save_All_general_settings_db_in['woospca_btdb_t_clr'];
$woospca_btdb_bg_clr=$woospca_save_All_general_settings_db_in['woospca_btdb_bg_clr'];



?>
<input type="hidden" id="woospca_savediv1">
<h3 style="font-weight:400; font-size: 21px;">	
	<i class="fa fa-hand-o-right" aria-hidden="true"></i>
	These Settings will be applied on front end        
</h3>
<hr>

<div style="  width: 80%;  border: 1px solid #aaa;padding: 10px;border-radius: 4px;	position: relative;margin-top: 10px;">
	<div style="    background: #fff;padding: 5px;color: #000;font-size: 14px;font-weight: 800;position: absolute;top: -15px;	left: 10px;">Avatar And Logout Button Options
	</div>
	<br>
	<p style="margin-left: 2%;">
		<strong class="col-sm-3">Enable Avatar</strong>
		<input <?php echo filter_var($woospca_is_avatar); ?> type="checkbox" value="" class="col-sm-9"  id="woospca_is_avatar" style="margin-left: 12%;">
	</p><br><br>	
	<p style="margin-left: 2%;">
		<strong class="col-sm-3">Enable Upload Avatar</strong>
		<input 
		<?php
		echo filter_var($woospca_is_upload_avatar);
		if ('true' != $woospca_is_avatarforlatest) {
			echo filter_var('disabled="disabled"');
		}
		?>
		type="checkbox" value="" class="col-sm-9" id="woospca_is_upload_avatar" style="margin-left: 12%;">
	</p><br><br>
	
	<p style="margin-left: 2%;">
		<strong class="col-sm-3">Avatar Border Radius</strong>
		<input 
		<?php
		if ('true' != $woospca_is_avatarforlatest) {
			echo filter_var('disabled="disabled"');
		}
		?>
		type="number" value="<?php echo filter_var($woospca_avatar_radius); ?>" style="width:10%;margin-left: 12% !important;" min="1" max="15" class="col-sm-9" id="woospca_avatar_radius" >
	</p><br><hr>
	<p style="margin-left: 2%;">
		<strong class="col-sm-3">Enable Logout Button</strong>
		<input <?php echo filter_var($woospca_is_logout); ?> type="checkbox" value="" class="col-sm-9" id="woospca_is_logout" style="margin-left: 12%;">
	</p><br><br><br>
	<p style="margin-left: 2%;">
		<strong class="col-sm-3">Logout Button Background Color</strong>
		<input type="text" value="<?php echo filter_var($woospca_logout_bg_clr); ?>" style="width:10%;margin-left: 12% !important;"  class="jscolor col-sm-9" id="woospca_logout_bg_clr" >
	</p><br><br><br>
	<p style="margin-left: 2%;">
		<strong class="col-sm-3">Logout Button Text Color</strong>
		<input type="text" value="<?php echo filter_var($woospca_logout_t_clr); ?>" style="width:10%;margin-left: 12% !important;"  class="jscolor col-sm-9" id="woospca_logout_t_clr" >
	</p><br><br><br>

<p style="margin-left: 2%;">
		<strong class="col-sm-3">"Back To Dashboard" Button Background Color</strong>
		<input type="text" value="<?php echo filter_var($woospca_btdb_bg_clr); ?>" style="width:10%;margin-left: 12% !important;"  class="jscolor col-sm-9" id="woospca_btdb_bg_clr" >
	</p><br><br><br>
	<p style="margin-left: 2%;">
		<strong class="col-sm-3">"Back To Dashboard" Button Text Color</strong>
		<input type="text" value="<?php echo filter_var($woospca_btdb_t_clr); ?>" style="width:10%;margin-left: 12% !important;"  class="jscolor col-sm-9" id="woospca_btdb_t_clr" >
	</p><br><br>

</div>
<br>
<br>
<div style="  width: 80%;  border: 1px solid #aaa;padding: 10px;border-radius: 4px;	position: relative;margin-top: 10px;">
	<div style="    background: #fff;padding: 5px;color: #000;font-size: 14px;font-weight: 800;position: absolute;top: -15px;	left: 10px;">Menu Options
	</div>
	<br>
	<p style="margin-left: 2%;">
		<strong class="col-sm-3">Menu Position</strong>
		<input type="radio" name="woospca_menu_pos" value="leftside" style="margin-left: 12%;"
		<?php
		if ('leftside' == $woospca_menu_pos) {
			echo filter_var('checked="checked"');
		}
		?>
		>
		<span style="margin-left: 1%;">Left</span>
		<input type="radio" name="woospca_menu_pos"  value="rightside" style="margin-left: 12%;"
		<?php
		if ('rightside' == $woospca_menu_pos) {
			echo filter_var('checked="checked"');
		}
		?>
		>
		<span style="margin-left: 1%;">Right</span>
		<input type="radio" name="woospca_menu_pos"  value="topside" style="margin-left: 12%;"
		<?php
		if ('topside' == $woospca_menu_pos) {
			echo filter_var('checked="checked"');
		}
		?>
		>
		<span style="margin-left: 1%;">Top</span>
	</p><br>	
	<p style="margin-left: 2%;">
		<strong class="col-sm-3">Menu Style</strong>
		<input type="radio" name="woospca_menu_style"  value="woospca_menu_stylea" style="margin-left: 12%;"
		<?php
		if ('woospca_menu_stylea' == $woospca_menu_style) {
			echo filter_var('checked="checked"');
		}
		?>
		>
		<span style="margin-left: 1%;">Corner Edges</span>
		<input type="radio" name="woospca_menu_style"  value="woospca_menu_styleb" style="margin-left: 4%;" 
		<?php
		if ('woospca_menu_styleb' == $woospca_menu_style) {
			echo filter_var('checked="checked"');
		}
		?>
		>
		<span style="margin-left: 1%;">Shadow</span>
		
		
	</p><br>	
	<p style="margin-left: 2%;">
		<strong class="col-sm-3">Menu Items Padding (px)</strong>
		<table style="margin-left: 38%;">
			<tr>
				<td><input type="number" id="woospca_p_t" value="<?php echo filter_var($woospca_p_t); ?>" style="width: 90%;"></td>
				<td><input type="number" id="woospca_p_r" value="<?php echo filter_var($woospca_p_r); ?>" style="width: 90%;"></td>
				<td><input type="number" id="woospca_p_b" value="<?php echo filter_var($woospca_p_b); ?>" style="width: 90%;"></td>
				<td><input type="number" id="woospca_p_l" value="<?php echo filter_var($woospca_p_l); ?>" style="width: 90%;"></td>
			</tr>
			<tr style="text-align: center;">
				<td><i >Top</i></td>
				<td><i >Right</i></td>
				<td><i >Bottom</i></td>
				<td><i >Left</i></td>

			</tr>
		</table>
		
		
		
		
		<br>
		

		
	</p><br><br>	

</div>
<br>
<br>

<div style="  width: 80%;  border: 1px solid #aaa;padding: 10px;border-radius: 4px;	position: relative;margin-top: 10px;">
	<div style="    background: #fff;padding: 5px;color: #000;font-size: 14px;font-weight: 800;position: absolute;top: -15px;	left: 10px;">Menu Color Options
	</div>
	<br>
	<div id="design_woospca_1" class="woospca_designs_colors_div" 
	<?php
	if ('woospca_menu_styleb' == $woospca_menu_style) {
		echo filter_var('style="display:none"');
	}
	?>
	 >
		<p style="margin-left: 2%;">
			<strong class="col-sm-3">Default Background Color</strong>
			<input type="text"   id="woospca_d_bd_c" value="<?php echo filter_var($woospca_d_bd_c); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Default Text Color</strong>
			<input type="text"   id="woospca_d_t_c" value="<?php echo filter_var($woospca_d_t_c); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Default Borders and Corners Color</strong>
			<input type="text"   id="woospca_d_brdrandcorner_c" value="<?php echo filter_var($woospca_d_brdrandcorner_c); ?>" class="jscolor" style="margin-left: 12%;"><br><hr>
		</p>
		<p style="margin-left: 2%;">
			<strong class="col-sm-3">Active Background Color</strong>
			<input type="text"   id="woospca_a_bg_c" value="<?php echo filter_var($woospca_a_bg_c); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Active Text Color</strong>
			<input type="text"   id="woospca_a_t_c" value="<?php echo filter_var($woospca_a_t_c); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Active Borders and Corners Color</strong>
			<input type="text"   id="woospca_a_brdrandcorner_c" value="<?php echo filter_var($woospca_a_brdrandcorner_c); ?>" class="jscolor" style="margin-left: 12%;"><br><hr>
		</p>
		<p style="margin-left: 2%;">
			<strong class="col-sm-3">Hover Background Color</strong>
			<input type="text"   id="woospca_h_bg_c" value="<?php echo filter_var($woospca_h_bg_c); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Hover Text Color</strong>
			<input type="text"   id="woospca_h_t_c" value="<?php echo filter_var($woospca_h_t_c); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Hover Borders and Corners Color</strong>
			<input type="text"   id="woospca_h_brdrandcorner_c" value="<?php echo filter_var($woospca_h_brdrandcorner_c); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			
		</p><br>
	</div>
	<div id="design_woospca_2" class="woospca_designs_colors_div"
	<?php
	if ('woospca_menu_stylea' == $woospca_menu_style) {
		echo filter_var('style="display:none"');
	}
	?>
	>
	<p style="margin-left: 2%;">
		<strong class="col-sm-3">Default Background Color</strong>
			<input type="text"   id="woospca_d_bd_c2" value="<?php echo filter_var($woospca_d_bd_c2); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Default Text Color</strong>
			<input type="text"   id="woospca_d_t_c2" value="<?php echo filter_var($woospca_d_t_c2); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Default Shodow Color</strong>
			<input type="text"   id="woospca_d_brdrandcorner_c2" value="<?php echo filter_var($woospca_d_brdrandcorner_c2); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Default Border Color</strong>
			<input type="text"   id="woospca_d_brdrandcorner_c2bb" value="<?php echo filter_var($woospca_d_brdrandcorner_c2bb); ?>" class="jscolor" style="margin-left: 12%;"><br><hr>
		</p>
		<p style="margin-left: 2%;">

			<strong class="col-sm-3">Active Background Color</strong>
			<input type="text"   id="woospca_a_bg_c2" value="<?php echo filter_var($woospca_a_bg_c2); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Active Text Color</strong>
			<input type="text"   id="woospca_a_t_c2" value="<?php echo filter_var($woospca_a_t_c2); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Active Shodow Color</strong>
			<input type="text"   id="woospca_a_brdrandcorner_c2" value="<?php echo filter_var($woospca_a_brdrandcorner_c2); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Active Border Color</strong>
			<input type="text"   id="woospca_a_brdrandcorner_c2bb" value="<?php echo filter_var($woospca_a_brdrandcorner_c2bb); ?>" class="jscolor" style="margin-left: 12%;"><br><hr>
		</p>
		<p style="margin-left: 2%;">

			<strong class="col-sm-3">Hover Background Color</strong>
			<input type="text"   id="woospca_h_bg_c2" value="<?php echo filter_var($woospca_h_bg_c2); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Hover Text Color</strong>
			<input type="text"   id="woospca_h_t_c2" value="<?php echo filter_var($woospca_h_t_c2); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Hover Shodow Color</strong>
			<input type="text"   id="woospca_h_brdrandcorner_c2" value="<?php echo filter_var($woospca_h_brdrandcorner_c2); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			<strong class="col-sm-3">Hover Border Color</strong>
			<input type="text"   id="woospca_h_brdrandcorner_c2bb" value="<?php echo filter_var($woospca_h_brdrandcorner_c2bb); ?>" class="jscolor" style="margin-left: 12%;"><br><br>
			
		</p><br><hr>
		<p style="margin-left: 2%;">
			<strong class="col-sm-3">Border Radius (px)</strong>
			<input type="number"   id="woospca_brdr_rdiis" value="<?php echo filter_var($woospca_brdr_rdiis); ?>" style="margin-left: 12%;">
		</p>
	</div>
	
	

</div>
<br>
<br>
<button type="button" class="button-primary" id="save_all_gnerl_Settings_woospca">Save Settings</button>
<button type="button" style="background-color: red;border-color: red;" class="button-primary" id="woospca_reset_to_def_clr">Reset To Default Color Scheme</button>
<br>
<br>

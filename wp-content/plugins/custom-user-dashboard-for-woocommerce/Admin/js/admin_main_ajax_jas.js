jQuery(document).ready(function () {

	"use strict";
	jQuery('#woospca_sel_page_ep').select2();
	jQuery('#woospca_eps_All').select2();
	jQuery('.woospca_customer_roleclass').select2();

	var datatable = jQuery('#woospca_datatables').DataTable({
		ajax: {
			url: woospcaData.admin_url + '?action=get_all_enpoints_from_db'
		},
		columns: [
		{data: 'serial_no'},
		{data: 'Endpoint Name'},
		{data: 'Endpoint Icon'},
		{data: 'Endpoint Type'},
		{data: 'Endpoint Sort Order'},
		{data: 'DefaultEndpoint'},
		{data: "Action" ,render: function ( data, type, full ) {
			// console.log(full.woospca_default);
			var btnhtml='<button type="button" value="'+data+'" woospca_default="'+full.woospca_default+'" def_slug="'+full.slug+'" style="background:green;border-color:green;" class="button-primary woospca_edit_btn"><i class="fa fa-fw fa-edit"></i>Edit</button>';
			if('Yes' ==full['DefaultEndpoint'] || '2' == full.woospca_default) {
				btnhtml=btnhtml;

			}else {
				btnhtml = btnhtml + '<button style="margin-left:2%;background:red;border-color:red;" class="button-primary woospca_delete_btn" value="'+data+'" type="button" id="" ><i class="fa fa-fw fa-trash"></i>Delete</button>';

			}
			return btnhtml;
		}}

		],

	});
	jQuery.get(woospcaData.icon_url, function(data) {
		var parsedYaml = jsyaml.load(data);

		var options = new Array();
		jQuery.each(parsedYaml.icons, function(index, icon){
			options.push({
				id: icon.id,
				text: '<i class="fa fa-fw fa-' + icon.id + '"></i> ' + icon.id

			});
		});



		jQuery('.woospca_select').select2({
			data: options,
			escapeMarkup: function(markup) {
				return markup;
			}
		});

	});
	setTimeout(function(){
		jQuery('.woospca_icons_div').find('.selection').find('.select2-selection__rendered').html('')
	},1200);
	jQuery('body').on('change', '.woospca_select1' , function(){
		var thisss=this;
		var icono = jQuery(this).val();
		
		setTimeout(function(){
			
			jQuery(thisss).parent().find('.selection').find('.select2-selection__rendered').html('<i class="fa fa-fw fa-' + icono + '"></i> '+icono)
		},200);


	});
	jQuery('body').on('change', '.woospca_select' , function(){
		var icono = jQuery(this).val();
		var active_class_val = jQuery('.active_btn_woospca').val();
		jQuery('#woospca_'+active_class_val+'_content').find('#woospca_icons').val(icono); 

		setTimeout(function(){

			jQuery('#woospca_'+active_class_val+'_content').find('.woospca_icons_div').find('.selection').find('.select2-selection__rendered').html('<i class="fa fa-fw fa-' + icono + '"></i> '+icono)
		},500);


	});

	jQuery('#woospca_sort_eps_at_time').on('click',function(e){
		jQuery('#woospca_save_sort_ep_btn').attr('disabled', 'disabled');
		jQuery("#myModalsortid").modal();
		jQuery.ajax({
			url : woospcaData.admin_url,

			type : 'post',
			data : {
				action : 'woospca_get_all_epss_html'       

			},
			success : function( response ) {

				jQuery('#myModalsortid').find('.modal-body').html(response);
				jQuery('#woospca_save_sort_ep_btn').attr('disabled', false);
				jQuery( "#sortable" ).sortable();
				jQuery( "#sortable" ).disableSelection();
				datatable.ajax.reload();


			}

		});

	});
	jQuery('#woospca_create_ep_at1').on('click',function(e){
		jQuery('#woospca_save_ep_btn').attr('disabled','disabled');
		e.preventDefault();
		jQuery('.endpoint_woospca').removeClass('active_btn_woospca');
		jQuery('.woospca_hide_all_tabss').hide();
		jQuery("#myModal_woospca").modal();

	});
	jQuery('.endpoint_woospca').on('click',function(e){
		jQuery('.endpoint_woospca').removeClass('active_btn_woospca');
		var thiss='#woospca_'+jQuery(this).val()+'_content';
		jQuery(this).addClass('active_btn_woospca');
		jQuery('#woospca_save_ep_btn').attr('disabled',false);
		e.preventDefault();
		jQuery('.woospca_hide_all_tabss').hide();
		jQuery('#woospca_'+jQuery(this).val()+'_content').show();
		if ('grp' == jQuery(this).val()) {
			jQuery.ajax({
				url : woospcaData.admin_url,

				type : 'post',
				data : {
					action : 'woospca_get_children_for_grp_content_modal', 
					

				},
				success : function( response ) {


					
					jQuery(thiss).find('#woospca_eps_All').html(response);

				}

			});
		}

	});
	jQuery( function() {
		jQuery( "#sortable" ).sortable();
		jQuery( "#sortable" ).disableSelection();
	} );

	jQuery('#woospca_save_sort_ep_btn').on('click', function(){

		var new_array_Sorted=[];
		var ep_name=[];
		jQuery('#myModalsortid').find('li').each(function(){
			new_array_Sorted.push(jQuery(this).val());
			ep_name.push(jQuery(this).attr('ep_name'));
		});

		
		jQuery.ajax({
			url : woospcaData.admin_url,

			type : 'post',
			data : {
				action : 'woospca_sort_endpoint_data_db', 
				new_array_Sorted:new_array_Sorted,
				ep_name:ep_name,

			},
			success : function( response ) {

				console.log(response);
				// return;
				datatable.ajax.reload();
				jQuery('.close').click();
				jQuery('.woospca').remove();
				jQuery('#woospca_savediv').after('<div class="notice notice-success is-dismissible woospca" ><p id="woospca_saveeditmsg">Done</p><button type="button" class="notice-dismiss hidedivv"><span class="screen-reader-text">Dismiss this notice.</span></button></div>')

				jQuery('#woospca_saveeditmsg').html('Account tabs has been sorted successfully');
				jQuery("html, body").animate({ scrollTop: 0 }, "slow");

			}

		});

	});
	jQuery('#woospca_save_ep_btn').on('click', function(){


		var active_class_val = jQuery('.active_btn_woospca').val();
		jQuery('#woospca_'+active_class_val+'_content').find('#woospca_editor_ep_id_'+active_class_val+'-html').click();
		var woospca_label_ep = jQuery('#woospca_'+active_class_val+'_content').find('#woospca_label_ep').val();
		var woospca_slug_ep = jQuery('#woospca_'+active_class_val+'_content').find('#woospca_slug_ep').val();
		var woospca_icons = jQuery('#woospca_'+active_class_val+'_content').find('#woospca_icons').val();      
		var woospca_editor_ep_id = '';
		var woospca_eps_All='';
		var woospca_link_ep='';
		var woospca_sel_page_ep='';
		var woospca_checknewtab_ep='';
		var woospca_hide_ep='';
		if (active_class_val == 'grp') {
			woospca_eps_All=jQuery('#woospca_'+active_class_val+'_content').find('#woospca_eps_All').val();
		} else if (active_class_val == 'link') {
			woospca_link_ep=jQuery('#woospca_link_ep').val();
			woospca_checknewtab_ep=jQuery('#woospca_'+active_class_val+'_content').find('#woospca_checknewtab_ep').prop('checked');
			woospca_hide_ep=jQuery('#woospca_'+active_class_val+'_content').find('#woospca_hide_ep').prop('checked');
		} else if (active_class_val == 'page') {
			woospca_sel_page_ep=jQuery('#woospca_'+active_class_val+'_content').find('#woospca_sel_page_ep').val();
			woospca_checknewtab_ep=jQuery('#woospca_'+active_class_val+'_content').find('#woospca_checknewtab_ep').prop('checked');
			woospca_hide_ep=jQuery('#woospca_'+active_class_val+'_content').find('#woospca_hide_ep').prop('checked');
		} else if ('ep'==active_class_val){
			woospca_editor_ep_id=jQuery('#woospca_editor_ep_id_ep').val();
			woospca_hide_ep=jQuery('#woospca_'+active_class_val+'_content').find('#woospca_hide_ep').prop('checked');
		}

		if (woospca_label_ep=='' || woospca_slug_ep==''){
			alert('Please enter the required fields to proceed successfully');
			jQuery('#woospca_'+active_class_val+'_content').find('#woospca_editor_ep_id_'+active_class_val+'-tmce').click();
			return;
		}
		if(woospca_link_ep=='' && active_class_val=='link'){
			alert('Please enter the required fields to proceed successfully');
			jQuery('#woospca_'+active_class_val+'_content').find('#woospca_editor_ep_id_'+active_class_val+'-tmce').click();
			return;
		}


		var woospca_default =  jQuery(this).attr('woospca_default');

		var woospca_customer_role=jQuery('#woospca_'+active_class_val+'_content').find('#woospca_customer_role').val();
		jQuery.ajax({
			url : woospcaData.admin_url,

			type : 'post',
			data : {
				action : 'woospca_save_endpoint_data_db', 
				active_class_val:active_class_val,
				woospca_label_ep:woospca_label_ep,
				woospca_slug_ep:woospca_slug_ep,
				woospca_icons:woospca_icons,
				woospca_editor_ep_id:woospca_editor_ep_id,
				woospca_eps_All:woospca_eps_All,
				woospca_link_ep:woospca_link_ep,
				woospca_default:woospca_default,
				woospca_sel_page_ep:woospca_sel_page_ep,
				woospca_checknewtab_ep:woospca_checknewtab_ep,
				woospca_hide_ep:woospca_hide_ep,
				woospca_customer_role:woospca_customer_role,

			},
			success : function( response ) {

				jQuery('#woospca_'+active_class_val+'_content').find('#woospca_editor_ep_id_'+active_class_val+'-tmce').click();
				datatable.ajax.reload();
				jQuery('.close').click();
				jQuery('.woospca').remove();
				jQuery('#woospca_savediv').after('<div class="notice notice-success is-dismissible woospca" ><p id="woospca_saveeditmsg">Done</p><button type="button" class="notice-dismiss hidedivv"><span class="screen-reader-text">Dismiss this notice.</span></button></div>')

				jQuery('#woospca_saveeditmsg').html('Account tab has been added successfully');
				jQuery("html, body").animate({ scrollTop: 0 }, "slow");

				var arraytobeempty=['ep','grp','page','link'];
				for (var i = 0; i < arraytobeempty.length; i++) {
					var active_class_val = arraytobeempty[i];

					jQuery('#woospca_'+active_class_val+'_content').find('#woospca_label_ep').val('');
					jQuery('#woospca_'+active_class_val+'_content').find('#woospca_slug_ep').val('');
					jQuery('#woospca_'+active_class_val+'_content').find('#woospca_icons').val('');      
					jQuery('#woospca_'+active_class_val+'_content').find('#woospca_editor_ep_id_'+active_class_val).val('');
					if (active_class_val == 'grp') {
						jQuery('#woospca_'+active_class_val+'_content').find('#woospca_eps_All').val('');
					} else if (active_class_val == 'link') {
						jQuery('#woospca_link_ep').val('');

					} else if (active_class_val == 'page') {
						jQuery('#woospca_'+active_class_val+'_content').find('#woospca_sel_page_ep').val('');

					}


				}

			}


		});

	});


	jQuery('body').on('click', '#woospca_edit_ep_details' , function(){
		var active_class_val = jQuery('#woospca_typeis').val();
		if (active_class_val=='endpoint'){
			active_class_val='ep';
		}else if(active_class_val=='group'){
			active_class_val='grp';
		}
		jQuery('#woospca_editor_ep_id_ep11edit-html').click();
		var woospca_label_ep = jQuery('#woospca_label_ep1').val();
		var woospca_slug_ep = jQuery('#woospca_slug_ep1').val();
		var woospca_icons = jQuery('#woospca_icons1').val();      
		var woospca_editor_ep_id = '';

		var woospca_eps_All='';
		var woospca_link_ep='';
		var woospca_sel_page_ep='';
		var woospca_checknewtab_ep='';
		var woospca_hide_ep='';
		var woospca_showcontentwhere=jQuery('input[name=woospca_showcontentwhere]:checked').val();;

		if (active_class_val == 'grp') {
			woospca_eps_All=jQuery('#woospca_eps_All1').val();
		} else if (active_class_val == 'link') {
			woospca_link_ep=jQuery('#woospca_link_ep1').val();
			woospca_checknewtab_ep=jQuery('#woospca_checknewtab_ep1').prop('checked');
			woospca_hide_ep=jQuery('#woospca_hide_ep1').prop('checked');
		} else if (active_class_val == 'page') {
			woospca_sel_page_ep=jQuery('#woospca_sel_page_ep1').val();
			woospca_checknewtab_ep=jQuery('#woospca_checknewtab_ep1').prop('checked');
			woospca_hide_ep=jQuery('#woospca_hide_ep1').prop('checked');
		}else if ('ep'==active_class_val){
			woospca_editor_ep_id = jQuery('#woospca_editor_ep_id_ep11edit').val();
			woospca_hide_ep = jQuery('#woospca_hide_ep1').prop('checked');
		}
		if (woospca_label_ep=='' || woospca_slug_ep=='' ){
			alert('Please enter the required fields to proceed successfully');
			jQuery('#woospca_editor_ep_id_ep11edit-tmce').click();
			return;
		}
		if(woospca_link_ep=='' && active_class_val=='link'){
			alert('Please enter the required fields to proceed successfully');
			jQuery('#woospca_editor_ep_id_ep11edit-tmce').click();
			return;
		}
		var woospca_customer_roleedit=jQuery('#woospca_customer_roleedit').val();


		var action = 'woospca_edit_ep_details_one';


		if (jQuery(this).val() == '99999999') {
			action = 'woospca_save_endpoint_data_db';
		} else {
			action = 'woospca_edit_ep_details_one';
		}


		var woospca_default =  jQuery(this).attr('woospca_default');
		jQuery.ajax({
			url : woospcaData.admin_url,

			type : 'post',
			data : {
				action : action,
				woospca_current_index:jQuery(this).val(),  
				active_class_val:active_class_val,
				woospca_label_ep:woospca_label_ep,
				woospca_slug_ep:woospca_slug_ep,
				woospca_icons:woospca_icons,
				woospca_editor_ep_id:woospca_editor_ep_id,
				woospca_eps_All:woospca_eps_All,
				woospca_link_ep:woospca_link_ep,
				woospca_sel_page_ep:woospca_sel_page_ep,
				woospca_default:woospca_default,
				woospca_checknewtab_ep:woospca_checknewtab_ep,    
				woospca_hide_ep:woospca_hide_ep,    
				woospca_showcontentwhere:woospca_showcontentwhere,    
				woospca_customer_roleedit:woospca_customer_roleedit,    

			},
			success : function( response ) {
				jQuery('#woospca_editor_ep_id_ep11edit-tmce').click();
				jQuery('.close').click();
				jQuery('.woospca').remove();
				jQuery('#woospca_savediv').after('<div class="notice notice-success is-dismissible woospca" ><p id="woospca_saveeditmsg">Done</p><button type="button" class="notice-dismiss hidedivv"><span class="screen-reader-text">Dismiss this notice.</span></button></div>')
				jQuery('#woospca_saveeditmsg').html('Account tab has been updated successfully');
				jQuery("html, body").animate({ scrollTop: 0 }, "slow");

				datatable.ajax.reload();


			}

		});
	});

	jQuery('body').on('click', '.woospca_edit_btn' , function(){
		jQuery('#woospca_edit_ep_details').attr('disabled', 'disabled');
		jQuery('#myModaledit_ep').modal();
		jQuery('#woospca_edit_ep_details').val(jQuery(this).val());
		
		var woospca_default = jQuery(this).attr('woospca_default');

		jQuery('#woospca_edit_ep_details').attr('woospca_default', woospca_default);

		jQuery('#myModaledit_ep').find('.modal-body').html('');
		tinyMCE.execCommand('mceRemoveEditor', true, 'woospca_editor_ep_id_ep11edit');
		var My_New_Global_Settings =  tinyMCEPreInit.mceInit.content;
		jQuery.ajax({
			url : woospcaData.admin_url,

			type : 'post',
			data : {
				action : 'woospca_get_one_ep_html_for_edit',
				woospca_current_index:jQuery(this).val(),      
				woospca_current_slug:jQuery(this).attr('def_slug'),      

			},
			success : function( response ) {

				jQuery('#myModaledit_ep').find('.modal-body').html(response);
				jQuery('#woospca_edit_ep_details').attr('disabled', false);
				jQuery.get(woospcaData.icon_url, function(data) {
					var parsedYaml = jsyaml.load(data);

					var options = new Array();
					jQuery.each(parsedYaml.icons, function(index, icon){
						options.push({
							id: icon.id,
							text: '<i class="fa fa-fw fa-' + icon.id + '"></i> ' + icon.id

						});
					});



					jQuery('.woospca_select1').select2({
						data: options,
						escapeMarkup: function(markup) {
							return markup;
						}
					});

				});
				setTimeout(function(){
					jQuery('#icondivvvwoospca').find('.selection').find('.select2-selection__rendered').html('<i class="fa fa-fw fa-'+jQuery('#pickthisiconanduse').val()+'"></i> '+jQuery('#pickthisiconanduse').val()+'')
				},800);
				datatable.ajax.reload();



				tinyMCE.execCommand('mceAddEditor', true, "woospca_editor_ep_id_ep11edit"); 
				quicktags({id : "woospca_editor_ep_id_ep11edit"});

				jQuery('#woospca_customer_roleedit').select2();
				jQuery('#woospca_eps_All1').select2();
				jQuery('#woospca_sel_page_ep1').select2();
			}

		});

	});
	jQuery('body').on('click', '.woospca_delete_btn' , function(){

		if(!confirm('Are you sure you want to permanently remove this endpoint?')){
			return;
		}
		jQuery.ajax({
			url : woospcaData.admin_url,

			type : 'post',
			data : {
				action : 'woospca_delete_endpoint_data_db', 
				index_num:jQuery(this).val(),

			},
			success : function( response ) {

				jQuery('.close').click();
				jQuery('.woospca').remove();
				jQuery('#woospca_savediv').after('<div class="notice notice-success is-dismissible woospca" ><p id="woospca_saveeditmsg">Done</p><button type="button" class="notice-dismiss hidedivv"><span class="screen-reader-text">Dismiss this notice.</span></button></div>')

				jQuery('#woospca_saveeditmsg').html('Account tab has been deleted');
				jQuery("html, body").animate({ scrollTop: 0 }, "slow");
				datatable.ajax.reload();


			}

		});
	});


	jQuery('body').on('click', '.hidedivv' , function(){
		jQuery('.woospca').remove();
	});


	jQuery('input[name=woospca_menu_style]').on('change', function(){

		if (jQuery(this).prop('checked')){

			if (jQuery(this).val() == 'woospca_menu_stylea'){
				jQuery('#design_woospca_1').show();
				jQuery('#design_woospca_2').hide();				
			} else {
				jQuery('#design_woospca_2').show();	
				jQuery('#design_woospca_1').hide();
				
			}
		} 
	})





	jQuery('#woospca_reset_to_def_clr').on('click',function(){
		if (!confirm('All Settings will be replaced by default. Are you sure to replace?')){
			return;
		}
		jQuery.ajax({
			url : woospcaData.admin_url,

			type : 'post',
			data : {
				action : 'woospca_reset_to_def_clr', 	
				

			},
			success : function( response ) {

				jQuery('.close').click();
				jQuery('.woospca').remove();
				jQuery('#woospca_savediv1').after('<div class="notice notice-success is-dismissible woospca" ><p id="woospca_saveeditmsg1">Done</p><button type="button" class="notice-dismiss hidedivv"><span class="screen-reader-text">Dismiss this notice.</span></button></div>')

				jQuery('#woospca_saveeditmsg1').html('All settings have been updated to default.');
				jQuery("html, body").animate({ scrollTop: 100 }, "slow");
				// datatable.ajax.reload();
				setTimeout(function(){
					location.reload();
				},2000); 

			}
			});
	});
	jQuery('#save_all_gnerl_Settings_woospca').on('click',function(){
		var woospca_is_avatar=jQuery('#woospca_is_avatar').prop('checked');
		var woospca_is_upload_avatar=jQuery('#woospca_is_upload_avatar').prop('checked');
		var woospca_is_logout=jQuery('#woospca_is_logout').prop('checked');
		var woospca_avatar_radius=jQuery('#woospca_avatar_radius').val();

		var woospca_menu_pos=jQuery('input[name=woospca_menu_pos]:checked').val();
		var woospca_menu_style=jQuery('input[name=woospca_menu_style]:checked').val();
		var woospca_p_t=jQuery('#woospca_p_t').val();
		var woospca_p_r=jQuery('#woospca_p_r').val();
		var woospca_p_b=jQuery('#woospca_p_b').val();
		var woospca_p_l=jQuery('#woospca_p_l').val();

		var woospca_d_bd_c=jQuery('#woospca_d_bd_c').val();
		var woospca_d_t_c=jQuery('#woospca_d_t_c').val();
		var woospca_d_brdrandcorner_c=jQuery('#woospca_d_brdrandcorner_c').val();
		var woospca_a_bg_c=jQuery('#woospca_a_bg_c').val();
		var woospca_a_t_c=jQuery('#woospca_a_t_c').val();
		var woospca_a_brdrandcorner_c=jQuery('#woospca_a_brdrandcorner_c').val();
		var woospca_h_bg_c=jQuery('#woospca_h_bg_c').val();
		var woospca_h_t_c=jQuery('#woospca_h_t_c').val();
		var woospca_h_brdrandcorner_c=jQuery('#woospca_h_brdrandcorner_c').val();

		var woospca_d_bd_c2=jQuery('#woospca_d_bd_c2').val();
		var woospca_d_t_c2=jQuery('#woospca_d_t_c2').val();
		var woospca_d_brdrandcorner_c2=jQuery('#woospca_d_brdrandcorner_c2').val();
		var woospca_a_bg_c2=jQuery('#woospca_a_bg_c2').val();
		var woospca_a_t_c2=jQuery('#woospca_a_t_c2').val();
		var woospca_a_brdrandcorner_c2=jQuery('#woospca_a_brdrandcorner_c2').val();
		var woospca_h_bg_c2=jQuery('#woospca_h_bg_c2').val();
		var woospca_h_t_c2=jQuery('#woospca_h_t_c2').val();
		var woospca_h_brdrandcorner_c2=jQuery('#woospca_h_brdrandcorner_c2').val();
		var woospca_d_brdrandcorner_c2bb=jQuery('#woospca_d_brdrandcorner_c2bb').val();
		var woospca_a_brdrandcorner_c2bb=jQuery('#woospca_a_brdrandcorner_c2bb').val();
		var woospca_h_brdrandcorner_c2bb=jQuery('#woospca_h_brdrandcorner_c2bb').val();
		var woospca_brdr_rdiis=jQuery('#woospca_brdr_rdiis').val();
		var woospca_logout_bg_clr=jQuery('#woospca_logout_bg_clr').val();
		var woospca_logout_t_clr=jQuery('#woospca_logout_t_clr').val();


		var woospca_btdb_bg_clr=jQuery('#woospca_btdb_bg_clr').val();
		var woospca_btdb_t_clr=jQuery('#woospca_btdb_t_clr').val();



		jQuery.ajax({
			url : woospcaData.admin_url,

			type : 'post',
			data : {
				action : 'woospca_save_general_Settings_data_in_db', 
				woospca_is_avatar:woospca_is_avatar,
				woospca_is_upload_avatar:woospca_is_upload_avatar,
				woospca_is_logout:woospca_is_logout,
				woospca_avatar_radius:woospca_avatar_radius,
				woospca_menu_pos:woospca_menu_pos,
				woospca_menu_style:woospca_menu_style,
				woospca_p_t:woospca_p_t,
				woospca_p_r:woospca_p_r,
				woospca_p_b:woospca_p_b,
				woospca_p_l:woospca_p_l,
				woospca_d_bd_c:woospca_d_bd_c,
				woospca_d_t_c:woospca_d_t_c,
				woospca_d_brdrandcorner_c:woospca_d_brdrandcorner_c,
				woospca_a_bg_c:woospca_a_bg_c,
				woospca_a_t_c:woospca_a_t_c,
				woospca_a_brdrandcorner_c:woospca_a_brdrandcorner_c,
				woospca_h_bg_c:woospca_h_bg_c,
				woospca_h_t_c:woospca_h_t_c,
				woospca_h_brdrandcorner_c:woospca_h_brdrandcorner_c,

				woospca_d_bd_c2:woospca_d_bd_c2,
				woospca_d_t_c2:woospca_d_t_c2,
				woospca_d_brdrandcorner_c2:woospca_d_brdrandcorner_c2,
				woospca_a_bg_c2:woospca_a_bg_c2,
				woospca_a_t_c2:woospca_a_t_c2,
				woospca_a_brdrandcorner_c2:woospca_a_brdrandcorner_c2,
				woospca_h_bg_c2:woospca_h_bg_c2,
				woospca_h_t_c2:woospca_h_t_c2,
				woospca_h_brdrandcorner_c2:woospca_h_brdrandcorner_c2,
				woospca_d_brdrandcorner_c2bb:woospca_d_brdrandcorner_c2bb,
				woospca_a_brdrandcorner_c2bb:woospca_a_brdrandcorner_c2bb,
				woospca_h_brdrandcorner_c2bb:woospca_h_brdrandcorner_c2bb,
				woospca_brdr_rdiis:woospca_brdr_rdiis,

				woospca_logout_bg_clr:woospca_logout_bg_clr,
				woospca_logout_t_clr:woospca_logout_t_clr,
				
				woospca_btdb_bg_clr:woospca_btdb_bg_clr,
				woospca_btdb_t_clr:woospca_btdb_t_clr,
				

			},
			success : function( response ) {

				jQuery('.close').click();
				jQuery('.woospca').remove();
				jQuery('#woospca_savediv1').after('<div class="notice notice-success is-dismissible woospca" ><p id="woospca_saveeditmsg1">Done</p><button type="button" class="notice-dismiss hidedivv"><span class="screen-reader-text">Dismiss this notice.</span></button></div>')

				jQuery('#woospca_saveeditmsg1').html('All Settings have been updated');
				jQuery("html, body").animate({ scrollTop: 100 }, "slow");
				


			}

		});
	});

	jQuery('#woospca_is_avatar').on('change', function(){
		if (jQuery(this).prop('checked')) {
			jQuery('#woospca_is_upload_avatar').attr('disabled', false);
			jQuery('#woospca_avatar_radius').attr('disabled', false);
		} else {
			jQuery('#woospca_is_upload_avatar').attr('disabled', 'disabled');
			jQuery('#woospca_avatar_radius').attr('disabled', 'disabled');
		}
	});

	jQuery('body').on('keypress', '#woospca_slug_ep', function(e) {
		console.log(String.fromCharCode(e.which));
		if(!/[A-Za-z_-]/.test(String.fromCharCode(e.which)))
		return false;
	});


	jQuery('body').on('keypress', '#woospca_slug_ep1', function(e) {
		if(!/[A-Za-z_-]/.test(String.fromCharCode(e.which)))
		return false;
	});





});

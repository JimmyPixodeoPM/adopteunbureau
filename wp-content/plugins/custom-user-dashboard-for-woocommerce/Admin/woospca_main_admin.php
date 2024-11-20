<?php
class Woospca_Admin_Main extends Woospca_Main_Class_Alpha {	
	public function __construct() {
		add_action('woocommerce_settings_woospca', array($this, 'woospca_callback_against_mainsetting_content'));		
		add_filter('woocommerce_settings_tabs_array', array($this, 'woospca_filter_woocommerce_settings_tabs'), 50);
		add_action('init', array( $this, 'woospca_scripts_on_load1'));		
		add_action('admin_head', array( $this, 'woospca_scripts_on_load'));
	}
	
	public function woospca_filter_woocommerce_settings_tabs ( $tabs ) {
		$tabs['woospca'] = __('User Dashboard', 'woospca');		
		return $tabs;
	}	
	public function woospca_callback_against_mainsetting_content () {
		?>
		<section class="home-content-top">
			<div class="container-fluid">
				<div class="clearfix"></div>
				<div class="tabbable-panel margin-tops4 ">
					<div class="tabbable-line">
						<ul class="nav nav-tabs tabtop tabsetting">
							<li class="active"> <a href="#tab_default_1" data-toggle="tab"><i class="fa fa-fw fa-briefcase" aria-hidden="true"></i> <?php echo esc_html__('Manage Endpoints', 'woospca'); ?></a>
							</li>
							<li> <a href="#tab_default_2" data-toggle="tab"><i class="fa fa-cogs" aria-hidden="true"></i> <?php echo esc_html__('General Settings', 'woospca'); ?></a> 
							</li>

						</ul>
						<div class="tab-content margin-tops">
							<div class="tab-pane active fade in" id="tab_default_1">
								<div class="col-md-12 woospca_main">
									<?php include('woospca_endpoints_tab_html.php'); ?>
								</div>
							</div>
							<div class="tab-pane fade" id="tab_default_2">
								<div class="col-md-12 woospca_main">
									<?php include('woospca_general_settings_tab_html.php'); ?>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

		</section>
		<?php
	}	
	public function woospca_scripts_on_load1() {


		if ( isset ($_GET['page']) && ( 'wc-settings' == $_GET['page'] && isset ( $_GET['tab'] ) && 'woospca' == $_GET['tab'] ) ) {
			wp_enqueue_script('datatables12', plugins_url( 'datatables.min.js', __FILE__ ), array('jquery'), '1.0', 'all' );		
			wp_enqueue_style('datatables21awooshop', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', '1.0', 'all');
			wp_enqueue_style('datatables21', 'https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css', '1.0', 'all');
			wp_enqueue_style('datatables21animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', '1.0', 'all');
			wp_enqueue_script('woospca_jqui_drag', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', false, '1.0', 'all');			
		} 
	}
	public function woospca_scripts_on_load () {
		
		if ( isset ($_GET['page']) && ( ( 'wc-settings' == $_GET['page'] && isset ( $_GET['tab'] ) && 'woospca' == $_GET['tab'] ) || 'edit_rule' == $_GET['page'] ) ) {			
			wp_enqueue_style('date_picker_css_woospca', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', false, '1.0', 'all');
			wp_register_script('datepicker_woospca_alpha', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', '', '1.0');
			wp_enqueue_script('datepicker_woospca_alpha'); 
			wp_enqueue_script('colorpickearjs', plugins_url('js/jscolor.js', __FILE__), false, '1.0', 'all');			
			wp_enqueue_style('demo_acss', plugins_url('css/woospca_admin_style.css', __FILE__), false, '1.0', 'all');					
			wp_enqueue_script('my_custom_script_woospca', plugins_url('js/admin_main_ajax_jas.js', __FILE__) , false, '2.0', 'all' );
			$woospcaData = array(
				'admin_url' => admin_url('admin-ajax.php'),
				'icon_url' => plugin_dir_url(__FILE__) . 'js/icons.yml',
			);
			wp_localize_script('my_custom_script_woospca', 'woospcaData', $woospcaData);			
			wp_enqueue_script( 'select2', plugins_url( 'js/select2.min.js', __FILE__ ), false, '1.0', 'all');
			wp_enqueue_style( 'select2', plugins_url( 'js/select2.min.css', __FILE__ ), false, '1.0', 'all' );
			wp_enqueue_style( 'font-awesome', plugins_url( 'js/font-awesome.css', __FILE__ ), false, '1.0', 'all' );
			wp_enqueue_script( 'yaml', plugins_url('/js/yaml.min.js', __FILE__), false, '1.0', 'all' );
		}
	}





}
new Woospca_Admin_Main();

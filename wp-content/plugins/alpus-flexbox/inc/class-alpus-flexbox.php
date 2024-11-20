<?php

// Direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Plugin;
use Elementor\Core\Settings\Manager as SettingsManager;

class Alpus_Flexbox {

    private $modules = array();

	/**
	 * The Constructor
     *
	 * @since 1.0.0
	 * @access public
	*/
	public function __construct() {
        $this->modules = apply_filters(
            'alpus_modules',
            array(
                'slider',
                'image-accordion',
                'interactive-banners',
                'hscroller',
                // 'conditional',
            )
        );
        
        // Load style on admin for elementor preview
        add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'enqueue_script' ) );
        add_action( 'init', array( $this, 'load_module' ) );
        add_filter( 'language_attributes', function ( $output ) {
            $ui_theme_selected = SettingsManager::get_settings_managers( 'editorPreferences' )->get_model()->get_settings( 'ui_theme' );
            if ( ! empty( $ui_theme_selected ) && 'dark' == $ui_theme_selected ) {
                $output .= ' data-ui-mode="dark"';
            }
            
            return $output;
        } );

	}

    public function enqueue_script() {
	    wp_enqueue_style( 'alpus-el-admin', ALPUS_FLEXBOX_URI . 'assets/css/el-admin' . ( is_rtl() ? '-rtl' : '' ) . '.min.css' );
        wp_enqueue_script( 'alpus-el-admin', ALPUS_FLEXBOX_URI . 'assets/js/el-admin.min.js', array( 'nested-elements' ), '1.0', true );
    }

    public function load_module() {
        if ( Plugin::$instance->experiments->is_feature_active( 'container' ) ) {
            foreach ( $this->modules as $module ) {
                include_once ALPUS_FLEXBOX_PATH . 'inc/modules/' . $module . '/init.php';
            }
        }
    }
}

new Alpus_Flexbox;

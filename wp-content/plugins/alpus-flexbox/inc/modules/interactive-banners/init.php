<?php

// Direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Plugin;

class Alpus_Interactive_Banners {
	/**
	 * The Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
        add_action( 'elementor/widgets/register', array( $this, 'register_new_nested' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_widget_script' ), 9999 );
	}

	/**
	 * Register new nested elements
	 * 
	 * @since 1.0.0
	 */
    public function register_new_nested( $widgets_manager ) {
        if ( Plugin::$instance->experiments->is_feature_active( 'nested-elements' ) ) {
            include_once ALPUS_FLEXBOX_PATH . 'inc/modules/interactive-banners/widget.php';
            $widgets_manager->register( new Alpus_Nested_Interactive_Banners() );
		}
    }

	public function register_widget_script() {
		wp_register_style( 'alpus-el-interactive-banners', ALPUS_FLEXBOX_URI .'inc/modules/interactive-banners/interactive-banners.min.css', array(), ALPUS_FLEXBOX_VERSION );
		wp_register_script( 'alpus-el-interactive-banners', ALPUS_FLEXBOX_URI . 'inc/modules/interactive-banners/interactive-banners.min.js', array( 'jquery', 'elementor-frontend' ), '1.0.0', true );
	}
}

new Alpus_Interactive_Banners;

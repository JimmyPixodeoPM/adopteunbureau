<?php

// Direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;
use Elementor\Modules\NestedElements\Controls\Control_Nested_Repeater;

class Alpus_Nested_Interactive_Banners extends Widget_Nested_Base {

	public function get_name() {
		return 'alpus-nested-interactive-banners';
	}

	public function get_title() {
		return esc_html__( 'Alpus Interactive Banners', 'alpus-flexbox' );
	}

	public function get_icon() {
		return 'alpus-elementor-widget-icon alpus-widget-icon-ibanners';
	}

	public function get_categories() {
		return array( 'layout' );
	}

	public function get_script_depends() {
		return array( 'alpus-el-interactive-banners' );
	}
	
	public function get_style_depends() {
		return array( 'alpus-el-interactive-banners' );
	}

	public function get_keywords() {
		return array( 'nested', 'interactive', 'banner', 'flexbox', 'container', 'hover', 'mouse', 'cursor', 'split' );
	}

	protected function get_default_children_placeholder_selector() {
		return '.alpus-nested-interactive-banners';
	}

    protected function banner_item_container( int $index ) {
		return array(
			'elType'   => 'container',
			'settings' => array(
				'_title'        => sprintf( __( 'Banner #%s', 'alpus-flexbox' ), $index ),
				'content_width' => 'full',
				'background_background' => 'classic',
				'background_color' => $index > 1 ? '#ccc' : '#666',
				'padding'       => array(
					'unit'     => 'px',
					'top'      => '0',
					'right'    => '0',
					'bottom'   => '0',
					'left'     => '0',
					'isLinked' => true,
				),
            ),
        );
	}

	protected function get_default_children_title() {
		return esc_html__( 'Banner #%d', 'alpus-flexbox' );
	}

    protected function get_default_repeater_title_setting_key() {
		// return 'slide_title';
		return '';
	}

	protected function get_default_children_elements() {
		return array(
			$this->banner_item_container( 1 ),
			$this->banner_item_container( 2 ),
        );
	}

    protected function register_controls() {

        $this->start_controls_section(
            'section_banners',
            array(
                'label' => esc_html__( 'Banners', 'alpus-flexbox' ),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            )
        );
		
			$this->add_control(
				'direction',
				array(
					'label'   => esc_html__( 'Direction', 'alpus-flexbox' ),
					'type'                   => Controls_Manager::CHOOSE,
					'default'                => 'horizontal',
					'options' => array(
						'horizontal' => array(
							'title' => esc_html__( 'Horizontal', 'alpha-core' ),
							'icon' => 'eicon-arrow-right',
						),
						'vertical' => array(
							'title' => esc_html__( 'Vertical', 'alpha-core' ),
							'icon' => 'eicon-arrow-down',
						)
					)
				)
			);
		
       		$repeater = new Repeater();

			$this->add_control( 
				'items', 
				array(
					'label'   => esc_html__( 'Items', 'alpus-flexbox' ),
					'type'    => Control_Nested_Repeater::CONTROL_TYPE,
					'fields'  => $repeater->get_controls(),
					'default' => array(
						array(),
						array(),
					),
					'button_text' => esc_html__( 'Add Item', 'alpus-flexbox' ),
				)
			);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
		if ( empty( $settings['items'] ) ) {
			return;
		}

		$items_count = count( $settings['items'] );

		$items_html = '';
		foreach ( $settings['items'] as $index => $item ) {
			// Banners Content.
			ob_start();
			$this->print_child( $index );
			$item_html = ob_get_clean();
			$items_html .= '<div class="ibanner-item">' . $item_html . '</div>';
		}
		?>
		<div class="alpus-nested-interactive-banners" data-direction="<?php echo esc_attr( $settings['direction'] ); ?>">
			<?php echo $items_html;// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php
    }

	protected function content_template() {
		?>
		<#
            view.addRenderAttribute( 'ibanner-wrapper', 'class', 'alpus-nested-interactive-banners' );
            view.addRenderAttribute( 'ibanner-wrapper', 'data-direction', settings.direction );
		#>
		<div {{{ view.getRenderAttributeString( 'ibanner-wrapper' ) }}}>
		</div>
		<?php
	}
}

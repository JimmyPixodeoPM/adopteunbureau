<?php

// Direct load is not allowed
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Modules\NestedElements\Base\Widget_Nested_Base;
use Elementor\Modules\NestedElements\Controls\Control_Nested_Repeater;

class Alpus_Nested_Image_Accordion extends Widget_Nested_Base {

	public function get_name() {
		return 'alpus-nested-image-accordion';
	}

	public function get_title() {
		return esc_html__( 'Alpus Image Accordion', 'alpus-flexbox' );
	}

	public function get_icon() {
		return 'alpus-elementor-widget-icon alpus-widget-icon-image-accordions';
	}

	public function get_categories() {
		return array( 'layout' );
	}

	public function get_script_depends() {
		return array( 'alpus-el-image-accordion' );
	}

	public function get_style_depends() {
		return array( 'alpus-el-image-accordion' );
	}

	public function get_keywords() {
		return array( 'nested', 'image', 'accordion', 'flexbox', 'container', 'image' );
	}

	protected function get_default_children_placeholder_selector() {
		return '.alpus-nested-ia-wrapper';
	}

	protected function accordion_item_container( int $index ) {
		return array(
			'elType'   => 'container',
			'settings' => array(
				'_title'                => sprintf( __( 'Accordion #%s', 'alpus-flexbox' ), $index ),
				'content_width'         => 'full',
				'background_background' => 'classic',
				'background_image'      => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'background_position'   => 'center center',
				'background_size'       => 'cover',
				'padding'               => array(
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
		return esc_html__( 'Accordion #%d', 'alpus-flexbox' );
	}

	protected function get_default_repeater_title_setting_key() {
		// return 'slide_title';
		return '';
	}

	protected function get_default_children_elements() {
		return array(
			$this->accordion_item_container( 1 ),
			$this->accordion_item_container( 2 ),
		);
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_accordions',
			array(
				'label' => esc_html__( 'Accordions', 'alpus-flexbox' ),
				'tab'   => Controls_Manager::TAB_LAYOUT,
			)
		);

			$this->add_control(
				'active_behavior',
				array(
					'label'   => esc_html__( 'Active Behavior', 'alpus-flexbox' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'hover',
					'options' => array(
						'hover' => esc_html__( 'On Hover', 'alpus-flexbox' ),
						'click' => esc_html__( 'On Click', 'alpus-flexbox' ),
					),
				)
			);

			$this->add_responsive_control(
				'direction',
				array(
					'label'     => esc_html__( 'Direction', 'alpus-flexbox' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'row',
					'options'   => array(
						'row'    => esc_html__( 'Horizontal', 'alpus-flexbox' ),
						'column' => esc_html__( 'Vertical', 'alpus-flexbox' ),
					),
					'selectors' => array(
						'{{WRAPPER}} .alpus-nested-ia-wrapper' => '--alpha-ia-direction: {{VALUE}};',
					),
				)
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'is_active',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => __( 'Active as Default', 'alpha-core' ),
					'description' => esc_html__( 'This item will be active at first page load.', 'alpus-flexbox' ),
				)
			);

			$this->add_control(
				'items',
				array(
					'label'       => esc_html__( 'Items', 'alpus-flexbox' ),
					'type'        => Control_Nested_Repeater::CONTROL_TYPE,
					'fields'      => $repeater->get_controls(),
					'default'     => array(
						array(),
						array(),
					),
					'button_text' => esc_html__( 'Add Item', 'alpus-flexbox' ),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_general',
			array(
				'label' => esc_html__( 'General', 'alpus-flexbox' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'acc_height',
				array(
					'label'      => esc_html__( 'Height', 'alpus-flexbox' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px', '%', 'em', 'rem', 'vh', 'custom' ),
					'range'      => array(
						'px' => array(
							'min'  => 0,
							'max'  => 1000,
							'step' => 5,
						),
						'%'  => array(
							'min' => 0,
							'max' => 100,
						),
					),
					'default'    => array(
						'unit' => 'px',
						'size' => 1000,
					),
					'selectors'  => array(
						'{{WRAPPER}} .alpus-nested-ia-wrapper' => '--alpha-ia-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'hover_size',
				array(
					'label'     => esc_html__( 'Hover Item Size', 'alpus-flexbox' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => array(
						'px' => array(
							'min'  => 2,
							'max'  => 10,
							'step' => 1,
						),
					),
					'selectors' => array(
						'{{WRAPPER}} .alpus-nested-ia-wrapper' => '--alpha-ia-active-size: {{SIZE}};',
					),
				)
			);

			$this->add_responsive_control(
				'overlay_color',
				array(
					'label'     => esc_html__( 'Overlay Color', 'alpus-flexbox' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .alpus-nested-ia-wrapper' => '--alpha-ia-overlay-color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'hover_overlay_color',
				array(
					'label'     => esc_html__( 'Hover Overlay Color', 'alpus-flexbox' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => 'rgba(0, 0, 0, .3)',
					'selectors' => array(
						'{{WRAPPER}} .alpus-nested-ia-wrapper' => '--alpha-ia-hover-overlay-color: {{VALUE}};',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['items'] ) ) {
			return;
		}
		$direction = is_rtl() ? 'rtl' : 'ltr';

		$items_count = count( $settings['items'] );

		$items_html = '';
		foreach ( $settings['items'] as $index => $item ) {
			// Accordion Content.
			ob_start();
			$this->print_child( $index );
			$item_html   = ob_get_clean();
			$items_html .= '<div class="ia-item' . ( 'yes' == $item['is_active'] ? ' active' : '' ) . '">' . $item_html . '</div>';
		}
		?>
		<div class="alpus-nested-ia-wrapper<?php echo ' active-on-' . $settings['active_behavior']; ?>">
			<?php echo $items_html;// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php
	}

	protected function content_template() {
		?>
		<#
			view.addRenderAttribute( 'ia-wrapper', 'class', 'alpus-nested-ia-wrapper' );
			view.addRenderAttribute( 'ia-wrapper', 'class', 'active-on-' + settings.active_behavior );
			
			var activeIndex = [];
			_.each( settings.items, function( item, index ) {
				if ('yes' == item.is_active) {
					activeIndex.push(index);
				}
			} )
			view.addRenderAttribute( 'ia-wrapper', 'data-active', activeIndex.join(',') );
		#>
		<div {{{ view.getRenderAttributeString( 'ia-wrapper' ) }}}>
		</div>
		<?php
	}
}

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

class Alpus_Nested_Hscroller extends Widget_Nested_Base {

	public function get_name() {
		return 'alpus-nested-hscroller';
	}

	public function get_title() {
		return esc_html__( 'Alpus Horizontal Scroller', 'alpus-flexbox' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return array( 'layout' );
	}

	public function get_script_depends() {
		return array( 'alpus-el-hscroller', 'alpus-gsap', 'alpus-scroll-trigger' );
	}
	
	public function get_style_depends() {
		return array( 'alpus-el-hscroller' );
	}

	public function get_keywords() {
		return array( 'nested', 'horizontal scroller', 'flexbox', 'container', 'image' );
	}

	protected function get_default_children_placeholder_selector() {
		return '.alpus-horizontal-scroller-items';
	}

    protected function item_container( int $index ) {
		return array(
			'elType'   => 'container',
			'settings' => array(
				'_title'        => sprintf( __( 'Item #%s', 'alpus-flexbox' ), $index ),
				'content_width' => 'full',
				'padding'       => array(
					'unit'      => 'px',
					'top'       => '0',
					'right'     => '0',
					'bottom'    => '0',
					'left'      => '0',
					'isLinked'  => true,
				),
            ),
        );
	}

	protected function get_default_children_title() {
		return esc_html__( 'Item #%d', 'alpus-flexbox' );
	}

    protected function get_default_repeater_title_setting_key() {
		return '';
	}

	protected function get_default_children_elements() {
		return array(
			$this->item_container( 1 ),
			$this->item_container( 2 ),
        );
	}

    protected function register_controls() {

        $this->start_controls_section(
            'section_items',
            array(
                'label' => esc_html__( 'Items', 'alpus-flexbox' ),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            )
        );
		
			$this->add_control(
				'v_align',
				array(
					'label'   => esc_html__( 'Vertical alignment', 'alpus-flexbox' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'center',
					'options' => array(
						'flex-start' => array(
							'title' => esc_html__( 'Top', 'alpus-flexbox' ),
							'icon'  => 'eicon-v-align-top',
						),
						'center' => array(
							'title' => esc_html__( 'Middle', 'alpus-flexbox' ),
							'icon'  => 'eicon-v-align-middle',
						),
						'flex-end' => array(
							'title' => esc_html__( 'Bottom', 'alpus-flexbox' ),
							'icon'  => 'eicon-v-align-bottom',
                        ),
					),
                    'selectors' => array(
						'.elementor-element-{{ID}} .alpus-horizontal-scroller-items' => 'align-items: {{VALUE}};',
					),
				)
			);

            $this->add_responsive_control(
                'items_spacing',
                [
                    'label'      => esc_html__( 'Items Spacing', 'alpus-flexbox' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                    'selectors'  => [
                        '.elementor-element-{{ID}} .alpus-horizontal-scroller-items > *' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

			$this->add_responsive_control(
				'scroller_count',
				[
					'label'              => esc_html__( 'Item Count', 'alpus-flexbox' ),
					'type'               => Controls_Manager::NUMBER,
					'min'                => 1,
					'max'                => 10,
					'step'               => 1,
					'desktop_default'    => 3,
					'tablet_default'     => 1,
					'frontend_available' => true,
					'render_type'        => 'template',
					'selectors'          => [
                        '.elementor-element-{{ID}} .alpus-horizontal-scroller-items' => '--alpus-hscroll-width: {{SIZE}};',
                    ],
				]
			);
          

            $this->add_responsive_control(
                'scroller_padding',
                [
                    'label'      => esc_html__( 'Scroller Padding', 'alpus-flexbox' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                    'selectors'  => [
                        '.elementor-element-{{ID}} .alpus-horizontal-scroller-scroll' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
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

        $hscroll_options = array();
        $hscroll_options['lg'] = ! empty( $settings['scroller_count'] ) ? $settings['scroller_count'] : 3;
        $hscroll_options['md'] = ! empty( $settings['scroller_count_tablet'] ) ? $settings['scroller_count_tablet'] : 1;
        if ( ! empty( $settings['scroller_count_mobile'] ) ) {
            $hscroll_options['sm'] = $settings['scroller_count_mobile'];
        }

		?>
        <div class="alpus-horizontal-scroller-wrapper" data-plugin-hscroll="<?php echo esc_attr( json_encode( $hscroll_options ) ); ?>">
            <div class="alpus-horizontal-scroller">
                <div class="alpus-horizontal-scroller-scroll">
                    <div class="alpus-horizontal-scroller-items">
                    <?php
                        foreach ( $settings['items'] as $index => $item ) {
                            $this->print_child( $index );
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
		<?php
    }

	protected function content_template() {
		?>
		<#
            let hscroll_options = {};
			hscroll_options['lg'] = settings.scroller_count ? settings.scroller_count : 3;
			hscroll_options['md'] = settings.scroller_count_tablet ? settings.scroller_count_tablet : 1;
			if ( settings.scroller_count_mobile ) {
				hscroll_options['sm'] = settings.scroller_count_mobile;
			}
            view.addRenderAttribute( 'horizontal-wrapper', 'data-plugin-hscroll', JSON.stringify( hscroll_options ) );
		#>
		<div class="alpus-horizontal-scroller-wrapper" {{{ view.getRenderAttributeString( 'horizontal-wrapper' ) }}}>
            <div class="alpus-horizontal-scroller">
                <div class="alpus-horizontal-scroller-scroll">
                    <div class="alpus-horizontal-scroller-items">
                    </div>
                </div>
            </div>
        </div>
		<?php
	}
}

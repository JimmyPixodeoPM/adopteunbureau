<?php
/**
 * Class to handle product taxonomy validation
 *
 * @package  conditional-payment-methods-for-woocommerce/includes/rules/
 * @since    2.0.0
 * @version  1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WC_CPM_By_Taxonomy' ) ) {

	/**
	 * Class for Validating Product taxonomy in Conditional Payment Methods For WooCommerce
	 */
	class WC_CPM_By_Taxonomy {

		/**
		 * Variable to hold instance of this class
		 *
		 * @var $instance
		 */
		private static $instance = null;

		/**
		 * Variable to hold taxonomy prefix string
		 *
		 * @var $taxonomy_prefix
		 */
		private static $taxonomy_prefix = 'taxonomy_';

		/**
		 * Constructor
		 */
		public function __construct() {
			add_filter( 'cpm_available_rule_fields', array( $this, 'get_rule_fields' ), 11, 1 );
			add_action( 'wp_ajax_cpm_get_taxonomy_list', array( $this, 'get_taxonomy_list' ) );
		}

		/**
		 * Get single instance of this class
		 *
		 * @return Payment_Gateway_Restrictions_For_WooCommerce Singleton object of this class
		 */
		public static function get_instance() {

			// Check if instance is already exists.
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Handle call to functions which is not available in this class
		 *
		 * @param string $function_name The function name.
		 * @param array  $arguments Array of arguments passed while calling $function_name.
		 * @return result of function call
		 */
		public function __call( $function_name, $arguments = array() ) {

			global $wc_cpm_controller;

			if ( ! is_callable( array( $wc_cpm_controller, $function_name ) ) ) {
				return;
			}

			if ( ! empty( $arguments ) ) {
				return call_user_func_array( array( $wc_cpm_controller, $function_name ), $arguments );
			} else {
				return call_user_func( array( $wc_cpm_controller, $function_name ) );
			}
		}


		/**
		 * Get taxonomy rule fields
		 *
		 * @param array $fields Rule fields array.
		 * @return array $fields updated rule fields array.
		 */
		public function get_rule_fields( $fields = array() ) {
			$available_taxonomies = get_object_taxonomies( 'product', 'objects' );

			if ( ! empty( $available_taxonomies ) ) {
				foreach ( $available_taxonomies as $taxonomy ) {
					$slug = ( ! empty( $taxonomy->name ) ) ? $taxonomy->name : '';
					if ( empty( $slug ) || ( ! empty( $slug ) && false !== stripos( $slug, 'pa_' ) ) ) {
						continue;
					}

					$labels = ( ! empty( $taxonomy->labels ) ) ? $taxonomy->labels : null;
					$label  = '';
					if ( ! empty( $labels ) ) {
						$label = ( ! empty( $labels->singular_name ) ) ? $labels->singular_name : '';
					}

					$values = ( 'product_type' === $slug ) ? $this->get_all_product_types() : $this->get_all_taxonomies( $slug );

					if ( empty( $values ) ) {
						continue;
					}

					$fields[ self::$taxonomy_prefix . $slug ] = array(
						'title'  => ( false !== stripos( $label, 'Product' ) ) ? $label : __( 'Product', 'conditional-payment-methods-for-woocommerce' ) . ' ' . strtolower( $label ),
						'type'   => 'string',
						'values' => $values,
					);
				}
			}
			return $fields;
		}

		/**
		 * Get all available product types
		 *
		 * @return array $types array of product types.
		 */
		private function get_all_product_types() {
			$types = array_merge(
				wc_get_product_types(),
				array(
					'virtual'      => __( 'Virtual', 'conditional-payment-methods-for-woocommerce' ),
					'downloadable' => __( 'Downloadable', 'conditional-payment-methods-for-woocommerce' ),
				)
			);
			ksort( $types );
			return $types;
		}

		/**
		 * Get terms by taxonomy
		 *
		 * @param string $taxonomy taxonomy for which terms are to be fetched.
		 * @return array $taxonomies array of taxonomy terms.
		 */
		private function get_all_taxonomies( $taxonomy = '' ) {

			if ( empty( $taxonomy ) ) {
				return array();
			}

			$taxonomies = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
					'fields'     => 'id=>name',
				)
			);

			if ( ! is_wp_error( $taxonomies ) ) {
				return $taxonomies;
			}

			return array();
		}

		/**
		 * Validate a given rule
		 *
		 * @param array $rule Rule array.
		 * @return boolean $validate flag for the rule validity.
		 */
		public function validate( $rule ) {

			$validate = false;

			if ( ! empty( WC()->cart ) ) {
				foreach ( WC()->cart->get_cart() as $item => $values ) {
					switch ( $rule['field'] ) {
						case ( false !== stripos( $rule['field'], 'product_type' ) ):
							if ( in_array( 'variable', $rule['value'], true ) ) {
								$rule['value'][] = 'variation';
							}
							$product_id = ! empty( $values['variation_id'] ) ? $values['variation_id'] : $values['product_id'];
							$validate   = $this->product_type_rule_validation( $rule, $product_id );
							if ( $validate ) {
								return $validate;
							}
							break;
						case ( false !== stripos( $rule['field'], self::$taxonomy_prefix ) ):
							$validate = $this->product_taxonomy_rule_validation( $rule, $values['product_id'] );
							if ( $validate ) {
								return $validate;
							}
							break;
					}
				}
			}
			return $validate;
		}

		/**
		 * Get the taxonomy name from given string
		 *
		 * @param string $taxonomy taxonomy string.
		 * @return string taxonomy name
		 */
		private function get_taxonomy_name( $taxonomy = '' ) {
			return substr( $taxonomy, strlen( self::$taxonomy_prefix ) );
		}

		/**
		 * Validate a given taxonomy rule
		 *
		 * @param array $rule Rule array.
		 * @param int   $product_id id of the product.
		 * @return boolean
		 */
		private function product_taxonomy_rule_validation( $rule = array(), $product_id = 0 ) {
			if ( empty( $product_id ) || empty( $rule['field'] ) || empty( $rule['operator'] ) || empty( $rule['value'] ) ) {
				return false;
			}

			$product_id = intval( $product_id );
			$field      = ( ! empty( $rule['field'] ) ) ? $this->get_taxonomy_name( $rule['field'] ) : '';

			if ( empty( $field ) ) {
				return false;
			}

			return ( 'in' === $rule['operator'] ) ? has_term( $rule['value'], $field, $product_id ) : ! has_term( $rule['value'], $field, $product_id );
		}

		/**
		 * Validate a given product type rule
		 *
		 * @param array $rule Rule array.
		 * @param int   $product_id id of the product.
		 * @return boolean
		 */
		private function product_type_rule_validation( $rule = array(), $product_id = 0 ) {
			$validate = false;
			$value    = ( ! empty( $rule['value'] ) ) ? $rule['value'] : array();

			if ( empty( $product_id ) || empty( $rule['operator'] ) || empty( $value ) ) {
				return $validate;
			}

			$product = wc_get_product( intval( $product_id ) );

			if ( ! $product instanceof WC_Product ) {
				return $validate;
			}

			switch ( true ) {
				case ( in_array( $product->get_type(), $value, true ) ):
					$validate = true;
					break;

				case ( $product->is_downloadable() && in_array( 'downloadable', $value, true ) ):
					$validate = true;
					break;

				case ( $product->is_virtual() && in_array( 'virtual', $value, true ) ):
					$validate = true;
					break;

				default:
					$validate = false;
					break;
			}

			return ( 'in' === $rule['operator'] ) ? $validate : ! $validate;
		}

		/**
		 * Get terms based on searched string
		 *
		 * @return array $response response array
		 */
		public function get_taxonomy_list() {

			check_ajax_referer( CPM_AJAX_SECURITY, 'security' );

			$page     = ( ! empty( $_REQUEST['page'] ) ) ? absint( sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) ) : 1;
			$taxonomy = ( ! empty( $_REQUEST['taxonomy'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['taxonomy'] ) ) : '';
			$search   = ( ! empty( $_REQUEST['search'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['search'] ) ) : '';
			$limit    = ( ! empty( $_REQUEST['limit'] ) ) ? absint( sanitize_text_field( wp_unslash( $_REQUEST['limit'] ) ) ) : 5;

			if ( empty( $taxonomy ) ) {
				return array();
			}

			$response = array(
				'load_more' => true,
				'data'      => array(),
			);

			$terms = get_terms(
				array(
					'taxonomy'   => $this->get_taxonomy_name( $taxonomy ),
					'hide_empty' => false,
					'search'     => $search,
					'number'     => $limit,
					'offset'     => ( $page - 1 ) * $limit,
					'fields'     => 'id=>name',
				)
			);

			if ( count( $terms ) < $limit ) {
				$response['load_more'] = false;
			}

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $key => $value ) {
					$response['data'][] = array(
						'id'   => $key,
						'text' => $value,
					);
				}
			}
			wp_send_json( $response );
		}
	}
}

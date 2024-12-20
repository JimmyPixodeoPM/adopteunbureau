<?php
	// Get Meta Values
	wp_reset_postdata();
	global $porto_settings, $porto_layout;

	$header_is_side   = porto_header_type_is_side();
	$porto_banner_pos = porto_get_meta_value( 'banner_pos' );
	$wrapper          = porto_get_wrapper_type();

	$is_fixed  = ( 'below_header' == $porto_banner_pos || 'fixed' == $porto_banner_pos || porto_get_meta_value( 'header_view' ) == 'fixed' ) || 'fixed' == $porto_settings['header-view'];
	
	$hd_layout = porto_header_builder_layout();
	if ( 'header_builder_p' == $porto_settings['header-type-select'] ) {
		if ( isset( $hd_layout['type'] ) && 'absolute' == $hd_layout['type'] ) {
			$is_fixed =  true;
		} else if ( isset( $hd_layout['type'] ) && -1 == $hd_layout['type'] ) {
		} else {
			$is_fixed = false;
		}
	}
	if ( porto_show_archive_filter() ) {
		if ( 'fullwidth' == $porto_layout ) {
			$porto_layout = 'left-sidebar';
		}
		if ( 'widewidth' == $porto_layout ) {
			$porto_layout = 'wide-left-sidebar';
		}
	}
	$side_position = '';
	if ( $header_is_side ) {
		$side_position  = empty( $porto_settings['header-side-position'] ) ? 'left' : 'right';
		if ( isset( $hd_layout['side_header_pos'] ) ) {
			$side_position = $hd_layout['side_header_pos'] ? 'right' : 'left';
		}
		// if ( is_rtl() ) {
		// 	if ( 'right' == $side_position ) {
		// 		$side_position = 'left';
		// 	} else {
		// 		$side_position = 'right';
		// 	}
		// }
	}


	$breadcrumbs       = $porto_settings['show-breadcrumbs'] ? porto_get_meta_value( 'breadcrumbs', true ) : false;
	$page_title        = $porto_settings['show-pagetitle'] ? porto_get_meta_value( 'page_title', true ) : false;
	$content_top       = porto_get_meta_value( 'content_top' );
	$content_inner_top = porto_get_meta_value( 'content_inner_top' );

	$content_top_tracking       = 'meta-content_top';
	$content_inner_top_tracking = 'meta-content_inner_top';
	if ( is_array( $content_top ) ) {
		$content_top_tracking = $content_top[1];
		$content_top = $content_top[0];
	}
	if ( is_array( $content_inner_top ) ) {
		$content_inner_top_tracking = $content_inner_top[1];
		$content_inner_top = $content_inner_top[0];
	}

if ( is_front_page() ) {
	$breadcrumbs = false;
	$page_title  = false;
}

	do_action( 'porto_before_wrapper' );
?>

	<div class="page-wrapper<?php echo ! $header_is_side ? '' : ' side-nav', 'right' == $side_position ? ' side-nav-right' : ''; echo ( isset( $porto_settings['sticky-header-effect'] ) && 'scrollup' == $porto_settings['sticky-header-effect'] ? ' sticky-scroll-up': '' ); ?>"><!-- page wrapper -->
		<?php
		global $porto_block_template;
		if ( empty( $porto_block_template ) ) :
			do_action( 'porto_wrapper_start' );
			if ( 'before_header' == $porto_banner_pos ) {
				porto_banner( 'banner-before-header' );
			}
				do_action( 'porto_before_header' );
			?>

			<?php if ( porto_get_meta_value( 'header', true ) && 'hide' != $porto_settings['header-view'] ) : ?>
				<?php
					$header_wrapper_class_escaped = 'header-wrapper';
				if ( 'wide' == $porto_settings['header-wrapper'] ) {
					$header_wrapper_class_escaped .= ' wide';
				}
				if ( isset( $porto_settings['sticky-header-effect'] ) && 'reveal' == $porto_settings['sticky-header-effect'] ) {
					$header_wrapper_class_escaped .= ' header-reveal';
				}
				if ( ! ( $header_is_side && 'boxed' == $wrapper ) && $is_fixed ) {
					$header_wrapper_class_escaped .= ' fixed-header';
					if ( ! empty( $porto_settings['header-fixed-show-bottom'] ) ) {
						$header_wrapper_class_escaped .= ' header-transparent-bottom-border';
					}
				}
				if ( $header_is_side ) {
					$header_wrapper_class_escaped .= ' header-side-nav side-nav-wrap pin-wrapper';
				}
				?>
				<!-- header wrapper -->
				<div class="<?php echo esc_attr( $header_wrapper_class_escaped ); ?>">
					<?php if ( porto_get_wrapper_type() != 'boxed' && 'boxed' == $porto_settings['header-wrapper'] ) : ?>
					<div id="header-boxed">
					<?php endif; ?>
					<?php
					if ( isset( $porto_header_escaped ) ) {
						echo porto_filter_output( $porto_header_escaped );
					} else {
						get_template_part( 'header/header' );
					}
					?>

					<?php if ( porto_get_wrapper_type() != 'boxed' && 'boxed' == $porto_settings['header-wrapper'] ) : ?>
					</div>
					<?php endif; ?>
				</div>
				<!-- end header wrapper -->
			<?php endif; ?>

			<?php 

			if ( 'side' == porto_get_header_type() ) : ?>
				<div class="content-wrapper">
			<?php endif; ?>

			<?php
				do_action( 'porto_before_banner' );
			if ( 'before_header' != $porto_banner_pos ) {
				porto_banner( ( 'fixed' == $porto_banner_pos && 'boxed' !== $wrapper ) ? 'banner-fixed' : '' );
			}
		endif;
			do_action( 'porto_after_banner' );

			$main_class         = array();
			$main_content_class = array( 'main-content' );

		if ( in_array( $porto_layout, porto_options_both_sidebars() ) ) {
			$main_class[]   = 'column3';
			$mobile_sidebar = porto_get_meta_value( 'mobile_sidebar' );
			if ( 'yes' == $mobile_sidebar ) {
				$mobile_sidebar = true;
			} elseif ( 'no' == $mobile_sidebar ) {
				$mobile_sidebar = false;
			} else {
				$mobile_sidebar = ! empty( $porto_settings['show-mobile-sidebar'] ) ? true : false;
			}
			if ( $mobile_sidebar ) {
				$main_content_class[] = 'col-md-8 col-lg-6';
			} else {
				$main_content_class[] = 'col-lg-6';
			}
		} elseif ( in_array( $porto_layout, porto_options_sidebars() ) ) {
			$main_class[]         = 'column2';
			$main_class[]         = 'column2-' . str_replace( 'wide-', '', $porto_layout );
			$main_content_class[] = 'col-lg-9';
		} else {
			$main_class[]         = 'column1';
			$main_content_class[] = 'col-lg-12';
		}

		if ( porto_is_wide_layout( $porto_layout ) ) {
			$main_class[] = 'wide clearfix';
		} else {
			$main_class[] = 'boxed';
		}
		if ( ! $breadcrumbs && ! $page_title ) {
			$main_class[] = 'no-breadcrumbs';
		}
		if ( porto_get_wrapper_type() != 'boxed' && 'boxed' == $porto_settings['main-wrapper'] ) {
			$main_class[] = 'main-boxed';
		}
		?>

		<div id="main" class="<?php echo esc_attr( implode( ' ', $main_class ) ); ?>"><!-- main -->

			<?php
				do_action( 'porto_before_content_top' );
			if ( $content_top ) :
				?>
				<div id="content-top"><!-- begin content top -->
					<?php
					foreach ( explode( ',', $content_top ) as $block ) {
						echo do_shortcode( '[porto_block name="' . esc_attr( $block ) . '" tracking="' . $content_top_tracking . '"]' );
					}
					?>
				</div><!-- end content top -->
				<?php
			endif;
			do_action( 'porto_after_content_top' );

			if ( 'boxed' == $wrapper || 'fullwidth' == $porto_layout || 'left-sidebar' == $porto_layout || 'right-sidebar' == $porto_layout || 'both-sidebar' == $porto_layout ) {
				echo '<div class="container">';
				if ( class_exists( 'WC_Vendors' ) ) {
					porto_wc_vendor_header();
				}
			} else {
				echo '<div class="container-fluid">';
			}

				do_action( 'porto_before_content' );

				global $porto_shop_filter_layout;
			?>

			<div class="row main-content-wrap<?php echo isset( $porto_shop_filter_layout ) && 'horizontal' == $porto_shop_filter_layout ? ' porto-products-filter-body' : ''; ?>">

			<!-- main content -->
			<div class="<?php echo esc_attr( implode( ' ', $main_content_class ) ); ?>">

			<?php
				wp_reset_postdata();
				do_action( 'porto_before_content_inner_top' );
			if ( $content_inner_top ) :
				?>
					<div id="content-inner-top"><!-- begin content inner top -->
					<?php
					foreach ( explode( ',', $content_inner_top ) as $block ) {
						echo do_shortcode( '[porto_block name="' . esc_attr( $block ) . '" tracking="' . $content_inner_top_tracking . '"]' );
					}
					?>
					</div><!-- end content inner top -->
				<?php endif;
				do_action( 'porto_after_content_inner_top' );
			?>

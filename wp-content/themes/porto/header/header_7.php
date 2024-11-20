<?php
global $porto_settings, $porto_layout;
?>
<header id="header" class="header-7 logo-center<?php echo empty( $porto_settings['logo-overlay'] ) || empty( $porto_settings['logo-overlay']['url'] ) ? '' : ' logo-overlay-header'; ?>">
	<?php if ( $porto_settings['show-header-top'] ) : ?>
	<div class="header-top">
		<div class="container">
			<div class="header-left">
				<?php
				// show social links
				echo porto_header_socials();
				?>
			</div>
			<div class="header-right">
				<?php
				// show welcome message
				if ( $porto_settings['welcome-msg'] ) {
					echo '<span class="welcome-msg">' . do_shortcode( $porto_settings['welcome-msg'] ) . '</span>';
				}
				?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="header-main">
		<div class="container">
			<div class="header-left">
				<div id="main-menu">
					<?php echo porto_main_menu(); ?>
				</div>
			</div>
			<div class="header-center">
				<?php echo porto_logo(); ?>
			</div>
			<div class="header-right">
				<div>
					<?php echo porto_mobile_toggle_icon(); // show mobile toggle ?>

					<?php
					// show currency and view switcher
					$currency_switcher = porto_currency_switcher();
					$view_switcher     = porto_view_switcher();

					if ( $currency_switcher || $view_switcher ) {
						echo '<div class="switcher-wrap">';
					}

					echo porto_filter_output( $view_switcher );

					echo porto_filter_output( $currency_switcher );

					if ( $currency_switcher || $view_switcher ) {
						echo '</div>';
					}

					// show top navigation
					$top_nav = porto_top_navigation();
					echo porto_filter_output( $top_nav );

					// show contact info and mini cart
					$contact_info = $porto_settings['header-contact-info'];
					if ( $contact_info ) {
						echo '<div class="header-contact">';
						echo do_shortcode( $contact_info );
					}
					if ( ! empty( $porto_settings['header-woo-icon'] ) ) {
						if ( in_array( 'account', $porto_settings['header-woo-icon'] ) && class_exists( 'Woocommerce' ) ) {
							echo porto_account_menu( '' );
						}
						if ( in_array( 'wishlist', $porto_settings['header-woo-icon'] ) ) {
							echo porto_wishlist( '' );
						}
					}
					if ( $contact_info ) {
						echo '</div>';
					}
					?>
					<div class="block-nowrap">
						<?php
						// show search form
						echo porto_search_form();
						?>
					</div>
					<?php echo porto_minicart(); ?>
				</div>

				<?php get_template_part( 'header/header_tooltip' ); ?>

			</div>
		</div>
		<?php get_template_part( 'header/mobile_menu' ); ?>
	</div>
</header>

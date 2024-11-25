<?php

// Social Share
global $porto_settings;

if ( ! $porto_settings['share-enable'] ) {
	return;
}

echo '<div class="share-links">';

$nofollow = ' ';
if ( $porto_settings['share-nofollow'] ) {
	$nofollow = ' rel="noopener noreferrer nofollow"';
} else {
	$nofollow = ' rel="noopener noreferrer"';
}

$image     = wp_get_attachment_url( get_post_thumbnail_id() );
$permalink = esc_url( apply_filters( 'the_permalink', get_permalink() ) );

$wishlist_page = function_exists( 'yith_wcwl_is_wishlist_page' ) && yith_wcwl_is_wishlist_page() ? true : false;
if ( class_exists( 'YITH_WCWL' ) && is_user_logged_in() ) {
	global $post;
	if ( get_option( 'yith_wcwl_wishlist_page_id' ) == $post->ID ) {
		if ( empty( $share_link_url ) ) {
			$wishlist_id = ( YITH_WCWL()->last_operation_token ) ? YITH_WCWL()->last_operation_token : ( isset( YITH_WCWL()->details['wishlist_id'] ) ? YITH_WCWL()->details['wishlist_id'] : '' );
			if ( $wishlist_id ) {
				$permalink .= ( '/' == substr( $permalink, -1 ) ? '' : '/' ) . 'view/' . $wishlist_id;
			}

			$permalink = esc_url( urlencode( $permalink ) );
		} else {
			$permalink = urlencode( $share_link_url );
		}
	}
}

if ( $wishlist_page && ! is_user_logged_in() ) {
	$permalink = urlencode( $share_link_url );
}

$title = esc_attr( get_the_title() );
if ( porto_is_ajax() && isset( $_GET['action'] ) ) {
	$tooltip = ' data-bs-tooltip';
} else {
	$page_share_pos = ( isset( $porto_settings['page-share-pos'] ) && $porto_settings['page-share-pos'] ) ? $porto_settings['page-share-pos'] : '';
	$position       = '';

	if ( $page_share_pos ) {
		if ( 'left' == $page_share_pos ) {
			$position = 'right';
			if ( is_rtl() ) {
				$position = 'left';
			}
		} else {
			$position = 'left';
			if ( is_rtl() ) {
				$position = 'right';
			}
		}
	} else {
		$position = 'bottom';
	}

	$tooltip = " data-bs-tooltip data-bs-placement='" . esc_attr( $position ) . "'";
}

$extra_attr = 'target="_blank" ' . $nofollow . $tooltip;

if ( $porto_settings['share-facebook'] ) :
	?><a href="https://www.facebook.com/sharer.php?u=<?php
		echo porto_filter_output( $permalink );
		if ( $wishlist_page && ! empty( $share_link_title ) ) {
			echo '&p[title]=' . esc_attr( $share_link_title );
		}
	?>" <?php echo porto_filter_output( $extra_attr ); ?> title="<?php esc_attr_e( 'Facebook', 'porto' ); ?>" class="share-facebook<?php echo ! $wishlist_page ? '' : ' facebook'; ?>"><?php esc_html_e( 'Facebook', 'porto' ); ?></a>
	<?php
endif;

if ( $porto_settings['share-twitter'] ) :
	?>
	<a href="https://twitter.com/intent/tweet?text=<?php
	if ( $wishlist_page && ! empty( $share_summary ) ) {
		echo esc_attr( $share_summary );
	} else {
		echo urlencode( $title );
	}
	?>&amp;url=<?php echo porto_filter_output( $permalink ); ?>" <?php echo porto_filter_output( $extra_attr ); ?> title="<?php esc_attr_e( 'X', 'porto' ); ?>" class="share-twitter<?php echo ! $wishlist_page ? '' : ' twitter'; ?>"><?php esc_html_e( 'Twitter', 'porto' ); ?></a>
	<?php
endif;

if ( $porto_settings['share-linkedin'] ) :
	?>
	<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo porto_filter_output( $permalink ); ?>&amp;title=<?php echo urlencode( $title ); ?>" <?php echo porto_filter_output( $extra_attr ); ?> title="<?php esc_attr_e( 'LinkedIn', 'porto' ); ?>" class="share-linkedin"><?php esc_html_e( 'LinkedIn', 'porto' ); ?></a>
	<?php
endif;

if ( $porto_settings['share-googleplus'] ) :
	?>
	<a href="https://plus.google.com/share?url=<?php echo porto_filter_output( $permalink ); ?>" <?php echo porto_filter_output( $extra_attr ); ?> title="<?php esc_attr_e( 'Google +', 'porto' ); ?>" class="share-googleplus"><?php esc_html_e( 'Google +', 'porto' ); ?></a>
	<?php
endif;

if ( $porto_settings['share-pinterest'] ) :
	?>
	<a href="https://pinterest.com/pin/create/button/?url=<?php echo porto_filter_output( $permalink ); ?>&amp;<?php
	if ( $wishlist_page && ! empty( $share_summary ) ) {
		echo 'description=' . esc_attr( $share_summary ) . '&amp;';
	}
	?>media=<?php
	if ( $wishlist_page && ! empty( $share_image_url ) ) {
		echo urlencode( $share_image_url );
	} else {
		echo esc_url( $image );
	}
	?>" <?php echo porto_filter_output( $extra_attr ); ?> title="<?php esc_attr_e( 'Pinterest', 'porto' ); ?>" class="share-pinterest<?php echo ! $wishlist_page ? '' : ' pinterest'; ?>"><?php esc_html_e( 'Pinterest', 'porto' ); ?></a>
	<?php
endif;

if ( $porto_settings['share-email'] ) :
	?>
	<a href="mailto:?subject=<?php
	if ( $wishlist_page && ! empty( $share_link_title ) ) {
		echo esc_attr( $share_link_title );
	} else {
		echo urlencode( $title );
	}
	?>&amp;body=<?php 
	echo porto_filter_output( $permalink );
	if ( $wishlist_page && ! empty( $share_link_title ) ) {
		echo '&amp;title=' . esc_attr( $share_link_title );
	}
	?>" <?php echo porto_filter_output( $extra_attr ); ?> title="<?php esc_attr_e( 'Email', 'porto' ); ?>" class="share-email<?php echo ! $wishlist_page ? '' : ' email'; ?>"><?php esc_html_e( 'Email', 'porto' ); ?></a>
	<?php
endif;

if ( $porto_settings['share-vk'] ) :
	?>
	<a href="https://vk.com/share.php?url=<?php echo porto_filter_output( $permalink ); ?>&amp;title=<?php echo urlencode( $title ); ?>&amp;image=<?php echo esc_url( $image ); ?>&amp;noparse=true" <?php echo porto_filter_output( $extra_attr ); ?> title="<?php esc_attr_e( 'VK', 'porto' ); ?>" class="share-vk"><?php esc_html_e( 'VK', 'porto' ); ?></a>
	<?php
endif;

if ( $porto_settings['share-xing'] ) :
	?>
	<a href="https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url=<?php echo porto_filter_output( $permalink ); ?>" <?php echo porto_filter_output( $extra_attr ); ?> title="<?php esc_attr_e( 'Xing', 'porto' ); ?>" class="share-xing"><?php esc_html_e( 'Xing', 'porto' ); ?></a>
	<?php
endif;

if ( $porto_settings['share-tumblr'] ) :
	?>
	<a href="http://www.tumblr.com/share/link?url=<?php echo porto_filter_output( $permalink ); ?>&amp;name=<?php echo urlencode( $title ); ?>&amp;description=<?php echo urlencode( get_the_excerpt() ); ?>" <?php echo porto_filter_output( $extra_attr ); ?> title="<?php esc_attr_e( 'Tumblr', 'porto' ); ?>" class="share-tumblr"><?php esc_html_e( 'Tumblr', 'porto' ); ?></a>
	<?php
endif;

if ( $porto_settings['share-reddit'] ) :
	?>
	<a href="http://www.reddit.com/submit?url=<?php echo porto_filter_output( $permalink ); ?>&amp;title=<?php echo urlencode( $title ); ?>" <?php echo porto_filter_output( $extra_attr ); ?> title="<?php esc_attr_e( 'Reddit', 'porto' ); ?>" class="share-reddit"><?php esc_html_e( 'Reddit', 'porto' ); ?></a>
	<?php
endif;

if ( $porto_settings['share-whatsapp'] ) :
	if ( $wishlist_page && ! empty( $share_link_title ) ) {
		$title = $share_link_title;
	}
	?>
	<a href="whatsapp://send?text=<?php echo rawurlencode( $title ) . ' - ' . porto_filter_output( $permalink ); ?>" data-action="share/whatsapp/share" <?php echo porto_filter_output( $nofollow . $tooltip ); ?> title="<?php esc_attr_e( 'WhatsApp', 'porto' ); ?>" class="share-whatsapp<?php echo ! $wishlist_page ? '' : ' whatsapp'; ?>" style="display:none"><?php esc_html_e( 'WhatsApp', 'porto' ); ?></a>
	<?php
endif;

echo '</div>';

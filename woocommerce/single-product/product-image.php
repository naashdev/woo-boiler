<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post, $product, $woocommerce;
?>
<div class="col c-2-5">
	<div class="product-images">
		<?php
			/*if ( has_post_thumbnail() ) {
				$attachment_count = count( $product->get_gallery_attachment_ids() );
				$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
				$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
				$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
					'title'	 => $props['title'],
					'alt'    => $props['alt'],
				) );
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $props['url'], $props['caption'], $image ), $post->ID );
			} else {
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
			}

			do_action( 'woocommerce_product_thumbnails' );*/

			$attachment_ids = $product->get_gallery_attachment_ids();
			function get_product_images($ids, $size, $classes) {

				global $post, $product, $woocommerce;

				if ( $ids ) {
					echo '<ul class="' . $classes . '">';

					if ($size == 'large') {
						$filter = apply_filters('single_product_large_thumbnail_size', 'shop_single');
					} else {
						$filter = apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' );
					}

					// Print product feature image
					if ( has_post_thumbnail() ) {
						$attachment_count = count( $product->get_gallery_attachment_ids() );
						$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
						$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
						$image       = '<img src="' . wp_get_attachment_image_src( get_post_thumbnail_id(), $filter )[0] . '" title="' . $props["title"] . '" alt="' . $props["alt"] . '">';
						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<li><a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s">%s</a></li>', $props['url'], $props['caption'], $image ), $post->ID );
					}

					// Print thumbnails
					foreach ( $ids as $attachment_id ) {

						$image_link = wp_get_attachment_url( $attachment_id );

						if ( ! $image_link )
							continue;

						$image_title 	= esc_attr( get_the_title( $attachment_id ) );
						$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

						$image       = '<img src="' . wp_get_attachment_image_src( $attachment_id, $filter )[0] . '" title="' . $props["title"] . '" alt="' . $props["alt"] . '">';

						$image_class = esc_attr( implode( ' ', $classes ) );

						echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li><a href="%s" class="%s" title="%s">%s</a></li>', $image_link, $image_class, $image_caption, $image ), $attachment_id, $post->ID, $image_class );

					}

					echo '</ul>';
				}

			}

			get_product_images($attachment_ids, 'large', 'product-slider js-product-slider');
			get_product_images($attachment_ids, 'thumbnail', 'thumbnails');
		?>
	</div>
</div>

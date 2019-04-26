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
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;
$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . $placeholder,
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );
?>


<!-- <div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;"> -->


	<!-- <figure class="woocommerce-product-gallery__wrapper">
		<?php
		$attributes = array(
			'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
			'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
			'data-src'                => $full_size_image[0],
			'data-large_image'        => $full_size_image[0],
			'data-large_image_width'  => $full_size_image[1],
			'data-large_image_height' => $full_size_image[2],
		);

		if ( has_post_thumbnail() ) {
			$html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
			$html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
			$html .= '</a></div>';
		} else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html .= '</div>';
		}

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );

		do_action( 'woocommerce_product_thumbnails' );
		?>
	</figure> -->


	<div class="gallery-without-sidebar">
		<div class="slider flexslider">
			
		<div class="flex-viewport" style="overflow: hidden; position: relative;">
			<ul class="slides">
				<li class=""><img src="<?php echo get_template_directory_uri(); ?>/images/photos/homeware/8.jpg" alt="" draggable="false"></li>
				<li class=""><img src="<?php echo get_template_directory_uri(); ?>/images/photos/homeware/7.jpg" alt="" draggable="false"></li>
				<li class=""><img src="<?php echo get_template_directory_uri(); ?>/images/photos/homeware/6.jpg" alt="" draggable="false"></li>
				<li class=""><img src="<?php echo get_template_directory_uri(); ?>/images/photos/homeware/5.jpg" alt="" draggable="false"></li>
				<li class=""><img src="<?php echo get_template_directory_uri(); ?>/images/photos/homeware/4.jpg" alt="" draggable="false"></li>
				<li class=""><img src="<?php echo get_template_directory_uri(); ?>/images/photos/homeware/3.jpg" alt="" draggable="false"></li>
			</ul>
		</div>
		<ul class="flex-direction-nav"><li class="flex-nav-prev"><a class="flex-prev" href="#"><i class="fa fa-angle-left"></i></a></li><li class="flex-nav-next"><a class="flex-next flex-disabled" href="#" tabindex="-1"><i class="fa fa-angle-right"></i></a></li></ul></div>
		<div class="carousel flexslider">
			
		<div class="flex-viewport" style="overflow: hidden; position: relative;"><ul class="slides" style="width: 1200%; transition-duration: 0s; transform: translate3d(0px, 0px, 0px);">
				<li class="" style="width: 13.3333px; margin-right: 0px; float: left; display: block;"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/photos/homeware/8.jpg" alt="" draggable="false"></a></li>
				<li style="width: 13.3333px; margin-right: 0px; float: left; display: block;" class=""><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/photos/homeware/3.jpg" alt="" draggable="false"></a></li>
				<li style="width: 13.3333px; margin-right: 0px; float: left; display: block;" class=""><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/photos/homeware/2.jpg" alt="" draggable="false"></a></li>
				<li style="width: 13.3333px; margin-right: 0px; float: left; display: block;" class=""><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/photos/homeware/4.jpg" alt="" draggable="false"></a></li>
				<li style="width: 13.3333px; margin-right: 0px; float: left; display: block;" class=""><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/photos/homeware/5.jpg" alt="" draggable="false"></a></li>
				<li style="width: 13.3333px; margin-right: 0px; float: left; display: block;" class="flex-active-slide"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/photos/homeware/7.jpg" alt="" draggable="false"></a></li>
			</ul></div></div>
	</div>





<!-- </div> -->

<?php 


require_once(__DIR__.'/inc/classes/class.Header_Top_Walker.php');
require_once(__DIR__.'/inc/classes/class.Walker_Admin_Nav_Menu.php');
require_once(__DIR__.'/inc/classes/class.Walker_Nav_Menu_Frontend.php');

add_action('after_setup_theme', 'kute_functionalities');

function kute_functionalities(){

	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('woocommerce');


	register_nav_menus(array(
		'header-top' => 'Header Top Menu',
		'header-main' => 'Header Main Menu',
	));

}


add_action('wp_enqueue_scripts', 'kute_design_files');

function kute_design_files(){
	wp_enqueue_style('font-awesome', get_theme_file_uri().'/css/libs/font-awesome.min.css');
	wp_enqueue_style('bootstrap', get_theme_file_uri().'/css/libs/bootstrap.min.css');
	wp_enqueue_style('bootstrap-theme', get_theme_file_uri().'/css/libs/bootstrap-theme.css');
	wp_enqueue_style('fancybox', get_theme_file_uri().'/css/libs/jquery.fancybox.css');
	wp_enqueue_style('jquery-ui', get_theme_file_uri().'/css/libs/jquery-ui.min.css');
	wp_enqueue_style('owl.carousel', get_theme_file_uri().'/css/libs/owl.carousel.css');
	wp_enqueue_style('owl.transitions', get_theme_file_uri().'/css/libs/owl.transitions.css');
	wp_enqueue_style('owl.theme', get_theme_file_uri().'/css/libs/owl.theme.css');
	wp_enqueue_style('mCustomScrollbar', get_theme_file_uri().'/css/libs/jquery.mCustomScrollbar.css');
	wp_enqueue_style('animate', get_theme_file_uri().'/css/libs/animate.css');
	wp_enqueue_style('hover', get_theme_file_uri().'/css/libs/hover.css');
	wp_enqueue_style('color-orange', get_theme_file_uri().'/css/color-orange.css');

	wp_enqueue_style('kute_styles', get_stylesheet_uri());
	wp_enqueue_style('responsive', get_theme_file_uri().'/css/responsive.css');
	wp_enqueue_style('browser', get_theme_file_uri().'/css/browser.css');



	wp_enqueue_script('bootstrap', get_theme_file_uri().'/js/libs/bootstrap.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script('fancybox', get_theme_file_uri().'/js/libs/jquery.fancybox.js', array('jquery'), '1.0', true );

	wp_enqueue_script('jquery-ui', get_theme_file_uri().'/js/libs/jquery-ui.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script('owl-carousel', get_theme_file_uri().'/js/libs/owl.carousel.js', array('jquery'), '1.0', true );
	wp_enqueue_script('bootstrap', get_theme_file_uri().'/js/libs/bootstrap.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script('mCustomScrollbar', get_theme_file_uri().'/js/libs/jquery.mCustomScrollbar.js', array('jquery'), '1.0', true );
	wp_enqueue_script('wow', get_theme_file_uri().'/js/libs/wow.js', array('jquery'), '1.0', true );
	wp_enqueue_script('popup', get_theme_file_uri().'/js/libs/popup.js', array('jquery'), '1.0', true );
	wp_enqueue_script('theme', get_theme_file_uri().'/js/theme.js', array('jquery'), '1.0', true );
	wp_enqueue_script('custom', get_theme_file_uri().'/js/custom.js', array('jquery'), '1.0', false );


}

add_filter('wp_edit_nav_menu_walker', function(){
	return 'Walker_Megamenu_Class';
});



add_action('wp_update_nav_menu_item', function($one, $two){
	update_post_meta($two, '_submenu_type', $_POST['menu-item-submenu-type'][$two]);
}, 10, 2);



// header menu callback function 

function default_header_menu_callback(){
	echo sprintf("<a href='%s'>Home</a>", home_url() );
}

// main menu callback function 

function default_main_menu_callback(){
	echo sprintf("<ul><li><a href='%s'>Home</a></li></ul>", home_url() );
}


// external files for admin panel 

add_action('admin_enqueue_scripts', 'external_admin_scripts');

function external_admin_scripts(){
	wp_enqueue_media();
	wp_enqueue_script('admin_external', get_theme_file_uri().'/js/admin.js', array('jquery'), '1.0', true);
}

add_action('wp_update_nav_menu_item', function($dbid, $menuid){
	update_post_meta($menuid, '_submenu_image', $_POST['menu-item-submenu-image'][$menuid]);
}, 10, 2);






// removing wrapper start and closing 

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper');
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end');



add_action('woocommerce_before_main_content', 'kuteshop_shop_wrapper_start', 10);

function kuteshop_shop_wrapper_start(){
	echo '<div id="content"><div class="content-page"><div class="container">
';
}

add_action('woocommerce_after_main_content', 'kuteshop_shop_wrapper_end', 10);

function kuteshop_shop_wrapper_end(){
	echo "</div></div></div>";
}

// changing bread cumb output 

add_filter('woocommerce_breadcrumb_defaults', 'kuteshop_shop_breadcumb');

function kuteshop_shop_breadcumb( $breadcumb ){

	$breadcumb['wrap_before'] = '<div class="bread-crumb radius">';
	$breadcumb['wrap_after'] = '</div>';
	$breadcumb['delimiter'] = '';

	return $breadcumb;

}


add_filter('woocommerce_show_page_title', function(){
	return false;
});



remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);


remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);



add_filter('woocommerce_pagination_args', function( $pagination ){

	$pagination['type'] = "plain";

	return $pagination;

});



remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);

add_action('woocommerce_before_shop_loop_item', 'kute_template_loop_product_link_open', 10);

function kute_template_loop_product_link_open(){
	echo '<a href="' . get_the_permalink() . '" class="product-thumb-link">';
}



add_action('woocommerce_before_shop_loop_item_title', 'kute_template_shop_thumbnail', 10);

function kute_template_shop_thumbnail(){
	?>
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

		<?php 

			global $post, $product;

			$attachment_ids = $product->get_gallery_image_ids();

			$product_image_id = get_post_thumbnail_id( $post->ID );


			


			if($attachment_ids != array()){
				$num = 1;
				foreach($attachment_ids as $single_id){

					
					if($num == 1){
						$class = 'class="active"';
					}else{
						$class = NULL;
					}
					echo '<img data-color="'.get_post_meta($single_id, '_product_image_color', true).'" '.$class.' src="'.wp_get_attachment_image_src($single_id, 'shop_single')[0].'" alt="">';

					$num++;
				}
			}else{
				echo '<img data-color="'.get_post_meta($product_image_id, '_product_image_color', true).'" class="active" src="'.wp_get_attachment_image_src($product_image_id, 'shop_single')[0].'" alt="">';
			}
			


			

		 ?>

		
	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	<a href="<?php the_permalink(); ?>" class="quickview-link plus fancybox.iframe"><span>quick view</span></a>
	<?php
}






// add additional field to image uploader 

add_filter('attachment_fields_to_edit', 'kute_edit_product_image_fields', 10, 2);

function kute_edit_product_image_fields( $form_fields, $post ){

	$form_fields['product_color'] = array(
		'label' => 'Color',
		'input' => 'text',
		'value' => get_post_meta($post->ID, '_product_image_color', true),
		'helps' => 'add product color here'
	);
	

	return $form_fields;

}


add_filter('attachment_fields_to_save', 'kute_save_product_image_fields', 10, 2);


function kute_save_product_image_fields($post, $form_fields){

	if( isset( $form_fields['product_color'] ) ){
		update_post_meta($post['ID'], '_product_image_color', $form_fields['product_color']);
	}
		


}



// shop page product title 

add_action('woocommerce_shop_loop_item_title', 'kute_shop_page_product_title', 10);

function kute_shop_page_product_title(){
	?>
		<h3 class="product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<?php
}



// change price format 

add_filter('woocommerce_format_sale_price', 'kute_format_price_change', 10, 3);

function kute_format_price_change($price, $regular_price, $sale_price){
	$price = '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins><del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del> ';
	return $price;
}



// blank price

add_action('woocommerce_after_shop_loop_item_title', 'kute_button_icons', 15);

function kute_button_icons(){
	?>
		<div class="product-extra-link">
			<?php 

			global $product;

			$args = array(
				'quantity' => 1,
				'class'    => implode( ' ', array_filter( array(
						'product_type_' . $product->get_type(),
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				) ) ),
			);


			wc_get_template( 'loop/add-to-cart.php', $args ); ?>
			<a href="#" class="wishlist-link"><i class="fa fa-heart" aria-hidden="true"></i><span>Wishlist</span></a>
			<a href="#" class="compare-link"><i class="fa fa-refresh" aria-hidden="true"></i><span>Compare</span></a>
		</div>
	<?php
}



// add to cart icon 

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);


// catelog ordering 

remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);



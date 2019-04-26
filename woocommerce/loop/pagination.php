<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}
?>

	<?php

		global $product;

		$pp_page = isset( $_GET['per_page'] ) ? $_GET['per_page'] : 0;

		$totalproduct = $wp_query->found_posts;

		$currentpage = max( 1, get_query_var( 'paged' ) );

		if($pp_page == 0){
			$totalpage = $wp_query->max_num_pages;
		}else{
			$totalpage = ceil( $totalproduct / $pp_page );
		}


		$paginate = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
			'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
			'format'       => '',
			'add_args'     => false,
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'total'        => $totalpage,
			'prev_text'    => '<i class="fa fa-caret-left" aria-hidden="true"></i>',
			'next_text'    => '<i class="fa fa-caret-right" aria-hidden="true"></i>',
			'type'         => 'list',
			'end_size'     => 0,
			'mid_size'     => 3,
		) ) );



		$paginate = str_replace('page-numbers current', 'current-page', $paginate);
		$paginate = str_replace('span', 'a', $paginate);

		echo $paginate;
	?>


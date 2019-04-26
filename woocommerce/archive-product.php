<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>


	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

	<div class="col-md-3 col-sm-4 col-xs-12">
		<?php
			/**
			 * woocommerce_sidebar hook.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
		?>
	</div>
	<div class="col-md-9 col-sm-8 col-xs-12">

    	<div class="content-grid-boxed">

	    	<div class="sort-pagi-bar clearfix">
				<div class="view-type pull-left">
					<a href="grid-boxed-banner.html" class="grid-view active"></a>
					<a href="list-boxed-banner.html" class="list-view"></a>
				</div>
				<div class="sort-paginav pull-right">
					<div class="sort-bar select-box">
						<label>Sort By:</label>
						<form class="woocommerce-ordering" method="get">
							<select name="orderby" class="orderby">
								<?php 

								$catalog_orderby_options = array(
									'menu_order' => __( 'Position', 'woocommerce' ),
									'popularity' => __( 'Popular', 'woocommerce' ),
									'rating'     => __( 'Rating', 'woocommerce' ),
									'date'       => __( 'Recent', 'woocommerce' ),
									'price'      => __( 'Price', 'woocommerce' ),
									
								);

								$orderby = isset( $_GET['orderby'] ) ? $_GET['orderby'] : '';

								foreach ( $catalog_orderby_options as $id => $name ) : ?>
									<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
								<?php endforeach; ?>
							</select>
							<?php wc_query_string_form_fields( null, array( 'orderby', 'submit' ) ); ?>
						</form>

					</div>
					<div class="show-bar select-box">
						<label>Show:</label>
						<form class="woocommerce-ordering" method="get">
							<select name="per_page" class="orderby">
								<?php 
								global $wp_query;
								$total = $wp_query->found_posts;
								$last_num = 0;
								$per_page = isset( $_GET['per_page'] ) ? $_GET['per_page'] : get_option('posts_per_page');
								for( $num = 1; $num <= $total; $num++ ) : ?>
									<?php if ($num % 5 === 0): ?>
										<option value="<?php echo $num; ?>" <?php selected($per_page, $num) ?>>
											<?php echo $num; ?>
										</option>
									<?php $last_num = $num; ?>
									<?php endif; ?>
									
								<?php endfor; ?>

								<?php if ($last_num != $total): ?>
									<option value="<?php echo $total; ?>" <?php echo $num; ?>" <?php selected($per_page, $total) ?>><?php echo $total; ?></option>
								<?php endif ?>
									
								
							</select>
						</form>
					</div>
					<div class="pagi-bar">
					
						<?php
							/**
							 * woocommerce_after_shop_loop hook.
							 *
							 * @hooked woocommerce_pagination - 10
							 */
							do_action( 'woocommerce_after_shop_loop' );
						?>
					</div>
					
				</div>
			</div>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked wc_print_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php 

				$per_page = isset( $_GET['per_page'] ) ? $_GET['per_page'] : get_option('posts_per_page');

				$products = new WP_Query(array(
					'post_type' => 'product',
					'posts_per_page' => $per_page
				));

				while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php
						/**
						 * woocommerce_shop_loop hook.
						 *
						 * @hooked WC_Structured_Data::generate_product_data() - 10
						 */
						do_action( 'woocommerce_shop_loop' );
					?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php
				/**
				 * woocommerce_no_products_found hook.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			?>

		<?php endif; ?>
		</div>
	</div>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	

<?php get_footer( 'shop' ); ?>

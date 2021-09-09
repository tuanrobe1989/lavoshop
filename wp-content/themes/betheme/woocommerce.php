<?php
/**
 * The template for displaying woocommerce.
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

get_header( 'shop' );
?>

<div id="Content">
	<div class="content_wrapper clearfix">

		<div class="sections_group">

			<div class="entry-content" itemprop="mainContentOfPage">
				<?php
				if(is_product()){
					// for single product
					get_template_part( 'template-single-product' );
				}else{
					// for archive
					get_template_part( 'template-shop-archive' );
				}
				?>

			</div>

		</div>

		<?php get_sidebar(); ?>

	</div>
</div>


<?php get_footer( 'shop' );

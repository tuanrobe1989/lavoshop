<?php
/**
 * Single Template
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

if( get_post_meta(get_the_ID(), 'mfn_template_type', true) == 'default' ){
	get_header();
}else{
	get_header( 'shop' );
}
?>

<div id="Content">
	<div class="content_wrapper clearfix">

		<div class="sections_group">

			<div class="entry-content" itemprop="mainContentOfPage">

				<div class="product">
				<?php

					$mfn_builder = new Mfn_Builder_Front(get_the_ID());
					$mfn_builder->show();
					
				?>
				</div>

			</div>

		</div>

		<?php get_sidebar(); ?>

	</div>
</div>

<?php 
if( get_post_meta(get_the_ID(), 'mfn_template_type', true) == 'default' ){
	get_footer();
}else{
	get_footer( 'shop' );
}

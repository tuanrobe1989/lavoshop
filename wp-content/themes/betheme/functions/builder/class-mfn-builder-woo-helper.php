<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

class Mfn_Builder_Woo_Helper {

  public static function get_woo_cat_image($attr, $cat){
  	$output = '';
  	if($attr['image'] == 1){
  		$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
			if(isset($thumbnail_id) && !empty($thumbnail_id)){
				$output .= wp_get_attachment_image( $thumbnail_id );
			}else{
				$output .= wc_placeholder_img();
			}
		}
		return $output;
  }

  public static function get_woo_cat_title($attr, $cat){
  	$output = '';
  	if($attr['title'] == 1){
			$output .= '<'.$attr['title_tag'].' class="woocommerce-loop-category__title">'.$cat->name; 
			if(isset($attr['count']) && $attr['count'] == 1){ $output .= '<mark class="count">('.$cat->count.')</mark>'; }
			$output .= '</'.$attr['title_tag'].'>';
		}
		return $output;
  }

  public static function get_woo_product_title($product, $attr = false){

  	$output = '<div class="mfn-li-product-row mfn-li-product-row-title">'; 
  	$output .= '<'.$attr['title_tag'].' class="title"><a href="'.get_permalink($product->get_id()).'">'.get_the_title($product->get_id()).'</a></'.$attr['title_tag'].'>';
  	if ( wc_review_ratings_enabled() ) {
			$output .= wc_get_rating_html( $product->get_average_rating() );
		}
  	$output .= '</div>';
  	
		return $output;
  }

  public static function sample_item($type){
		$post = false;
		$posts = get_posts( array('post_type' => $type, 'numberposts' => 1, 'orderby' => 'ID', 'order' => 'ASC' ) );

		if( isset($posts) && count($posts) > 0 ){
			$post = $posts[0];
		}

		return $post;
	}

  public static function get_woo_product_image($product, $attr = false){
  	$output = '<div class="mfn-li-product-row mfn-li-product-row-image">'; 
  	$shop_images = mfn_opts_get( 'shop-images' );

  	if( $product->is_in_stock() && (! mfn_opts_get('shop-catalogue')) && (! in_array($product->get_type(), array('external', 'grouped', 'variable'))) ){
			$image_frame = 'double';
		} else {
			$image_frame = false;
		}

  	if( $shop_images == 'plugin' ){

			$output .= '<a href="'. apply_filters( 'the_permalink', get_permalink($product->get_id()) ) .'" class="product-loop-thumb">';
				remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
				ob_start();
				do_action( 'woocommerce_before_shop_loop_item_title' );
				$output .= ob_get_clean();

			$output .= '</a>';

		} elseif( $shop_images == 'secondary') {
			// Show secondary image on hover

			$output .= '<div class="hover_box hover_box_product product-loop-thumb" ontouchstart="this.classList.toggle(\'hover\');" >';

			if(mfn_opts_get('shop-wishlist') && mfn_opts_get('shop-wishlist-position') == 1){
						$output .= '<span href="#" data-id="'.$product->get_id().'" class="mfn-wish-button mfn-abs-top"><i class="icon-heart-empty-fa"></i><i class="icon-heart-fa"></i></span>';
						}

						ob_start();
		
		wc_get_template( 'single-product/sale-flash.php');
		
		$output .= ob_get_clean();

				$output .= '<a href="'. apply_filters( 'the_permalink', get_permalink($product->get_id()) ) .'">';
					$output .= '<div class="hover_box_wrapper">';

						if( has_post_thumbnail($product->get_id()) ){
							$output .= get_the_post_thumbnail( $product->get_id(), 'shop_catalog', array( 'class' => 'visible_photo scale-with-grid' ) );
						} elseif ( wc_placeholder_img_src() ) {
							$output .= wc_placeholder_img( 'shop_catalog' );
						}

						if( $attachment_ids = $product->get_gallery_image_ids() ) {
							if( isset( $attachment_ids['0'] ) ){
								$secondary_image_id = $attachment_ids['0'];
								$output .= wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'hidden_photo scale-with-grid' ) );
							}
						}

					$output .= '</div>';
				$output .= '</a>';

				if( ! $product->is_in_stock() && $soldout = mfn_opts_get( 'shop-soldout' ) ){
					$output .= '<span class="soldout"><h4>'. $soldout .'</h4></span>';
				}

			$output .= '</div>';

		} else {

			$output .= '<div class="image_frame scale-with-grid product-loop-thumb" ontouchstart="this.classList.toggle(\'hover\');">';

			if(mfn_opts_get('shop-wishlist') && mfn_opts_get('shop-wishlist-position') == 1){
				$output .= '<span href="#" data-id="'.$product->get_id().'" class="mfn-wish-button mfn-abs-top"><i class="icon-heart-empty-fa"></i><i class="icon-heart-fa"></i></span>';
			}

			ob_start();
		
		wc_get_template( 'single-product/sale-flash.php');

		$output .= ob_get_clean();

				$output .= '<div class="image_wrapper">';

				$output .= '<a href="'. apply_filters( 'the_permalink', get_permalink($product->get_id()) ) .'">';
					$output .= '<div class="mask"></div>';

					if( has_post_thumbnail($product->get_id()) ){
						$output .= get_the_post_thumbnail( $product->get_id(), 'shop_catalog', array( 'class' => 'scale-with-grid' ) );
					} elseif ( wc_placeholder_img_src() ) {
						$output .= wc_placeholder_img( 'shop_catalog' );
					}

				$output .= '</a>';

				$output .= '<div class="image_links '. esc_attr($image_frame) .'">';
					if( $product->is_in_stock() && (! mfn_opts_get('shop-catalogue')) && (! in_array($product->get_type(), array('external', 'grouped', 'variable'))) ){
						if( $product->supports( 'ajax_add_to_cart' ) ){
							$output .= '<a rel="nofollow" href="'. apply_filters('add_to_cart_url', esc_url($product->add_to_cart_url())) .'" data-quantity="1" data-product_id="'. esc_attr($product->get_id()) .'" class="add_to_cart_button ajax_add_to_cart product_type_simple"><i class="icon-basket"></i></a>';
						} else {
							$output .= '<a rel="nofollow" href="'. apply_filters('add_to_cart_url', esc_url($product->add_to_cart_url())) .'" data-quantity="1" data-product_id="'. esc_attr($product->get_id()) .'" class="add_to_cart_button product_type_simple"><i class="icon-basket"></i></a>';
						}
					}
					$output .= '<a class="link" href="'. apply_filters('the_permalink', get_permalink($product->get_id())) .'"><i class="icon-link"></i></a>';

					if(mfn_opts_get('shop-wishlist') && mfn_opts_get('shop-wishlist-position') == 1){
						$output .= '<a href="#" data-id="'.$product->get_id().'" class="mfn-wish-button link"><i class="icon-heart-empty-fa"></i><i class="icon-heart-fa"></i></a>';
						}



				$output .= '</div>';

				$output .= '</div>';


				if( ! $product->is_in_stock() && $soldout = mfn_opts_get( 'shop-soldout' ) ){
					$output .= '<span class="soldout"><h4>'. $soldout .'</h4></span>';
				}

				$output .= '<a href="'. apply_filters( 'the_permalink', get_permalink($product->get_id()) ) .'"><span class="product-loading-icon added-cart"></span></a>';

			$output .= '</div>';
		}

		$output .= '</div>';
		return $output;
  }

  public static function get_woo_product_price($product, $attr = false){

  	ob_start();
		mfn_display_custom_attributes($product->get_id());
		$output = ob_get_clean();

  	$output .= '<div class="mfn-li-product-row mfn-li-product-row-price">'; 
  	$output .= '<p class="price">'.$product->get_price_html().'</p>';
  	$output .= '</div>';
		return $output;
  }

  public static function get_woo_product_description($product, $attr = false){
  	$output = '';
		$output .= '<div class="mfn-li-product-row mfn-li-product-row-description">'; 
		$output .= '<p class="excerpt">'.get_the_excerpt($product->get_id()).'</p>';
		$output .= '</div>';
		return $output;
  }

  public static function get_woo_product_button($product, $attr = false){
  	$output = '';
		$output .= '<div class="mfn-li-product-row mfn-li-product-row-button">'; 
		$classes = '';
		$product->is_purchasable() ? $classes .= 'add_to_cart_button' : null;
		$product->supports( 'ajax_add_to_cart' ) ? $classes .= ' ajax_add_to_cart' : null;
		$output .= apply_filters(
        'woocommerce_loop_add_to_cart_link',
        sprintf(
            '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s</a>',
            esc_url(  $product->add_to_cart_url() ),
            esc_attr( $product->get_id() ),
            esc_attr( $product->get_sku() ),
            $classes,
            esc_attr( $product->get_type() ),
            esc_html( $product->add_to_cart_text() )
        ),
        $product
    );
    if(mfn_opts_get('shop-wishlist') && mfn_opts_get('shop-wishlist-position') == 0){
		$output .= '<a href="#" data-id="'.$product->get_id().'" class="mfn-wish-button tooltip tooltip-txt" data-tooltip="Add to wishlist"><i class="icon-heart-empty-fa"></i><i class="icon-heart-fa"></i></a>';
		}
		$output .= '</div>';
  	
		return $output;
  }

  public static function sample_products_loop($attr) {
  	$sample_loop = new WP_Query( 
  		array(
  			'post_type' => 'product',
  			'posts_per_page' => $attr['products']
  		)
  	);
  	return $sample_loop;
  }

  public static function productslist($product, $attr, $classes) {
  	$order = str_replace(' ', '', $attr['order']);
		$order_arr = explode(',', $order);
		// if ( empty( $product ) || ! $product->is_visible() )  return;
		$output = '<li class="'.implode(' ', wc_get_product_class( $classes, $product )).'">';

		if(isset($order_arr) && is_iterable($order_arr)){
			foreach($order_arr as $el){
				
				if( !isset($attr[$el]) || (isset($attr[$el]) && $attr[$el] == 1) ){
					$fun_name = 'get_woo_product_'.$el;
					$output .= self::$fun_name($product, $attr);
				}
			}
		}
		$output .= '</li>';			
		return $output;
  }

  public static function getDiscount($product) {
  	$percent = 0;
  	if( $product->is_type('variable') ){
  		$percentages = array();
	    $prices = $product->get_variation_prices();
	    foreach( $prices['price'] as $key => $price ){
	      if( $prices['regular_price'][$key] !== $price ){
	        $percentages[] = round(100 - ($prices['sale_price'][$key] / $prices['regular_price'][$key] * 100));
	      }
	    }
	    $percent = round(max($percentages));
  	}elseif($product->get_regular_price() && $product->get_sale_price()){
			$percent = round( (1 - ($product->get_sale_price() / $product->get_regular_price()))*100);
  	}
  	return $percent.'%';
  }

}
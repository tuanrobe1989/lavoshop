import '../sass/main.scss';
import 'jquery-match-height';
import 'lazysizes';
import 'lazysizes/plugins/parent-fit/ls.parent-fit';

function createCookie(name, value, minutes) {
    if (minutes) {
        var date = new Date();
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else {
        var expires = "";
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

jQuery(document).ready(function () {
    if (jQuery('.product-small').length > 0) {
        jQuery('.title-wrapper').matchHeight();
        jQuery('.post-item .box-text').matchHeight();
        jQuery('.product-small > .col-inner').matchHeight();
        if (jQuery('.product-small.product-title').length > 0) {
            jQuery('.product-small.product-title').matchHeight();
        }
        if (jQuery('.product-small .price-wrapper').length > 0) {
            jQuery('.product-small .price-wrapper').matchHeight();
        }
    }
    jQuery.magnificPopup.instance.close = function () {
        jQuery.magnificPopup.proto.close.call();
        if (jQuery.magnificPopup.instance.wrap) {
            var curLightbox = jQuery.magnificPopup.instance.wrap;
            if (curLightbox.find('.promoform').length > 0) {
                createCookie("promoform", 1, 5);
            }
        }
    };

})

var timeoutCart;

jQuery( function( $ ) {
	jQuery('.woocommerce').on('change', 'input.qty', function(){

		if ( timeoutCart !== undefined ) {
			clearTimeout( timeoutCart );
		}

		timeoutCart = setTimeout(function() {
			jQuery("[name='update_cart']").trigger("click");
		}, 500 );

	});
} );
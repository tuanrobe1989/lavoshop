import '../sass/main.scss';
import 'jquery-match-height';
import 'lazysizes';
import 'lazysizes/plugins/parent-fit/ls.parent-fit';
jQuery(document).ready(function(){
    jQuery('.product-small > .col-inner').matchHeight();
    jQuery('.title-wrapper').matchHeight();
    jQuery('.post-item .box-text').matchHeight();
    if(jQuery('.product-small.product-title').length > 0){
        jQuery('.product-small.product-title').matchHeight();
    }
    if(jQuery('.product-small .price-wrapper').length > 0){
        jQuery('.product-small .price-wrapper').matchHeight();
    }
    
})
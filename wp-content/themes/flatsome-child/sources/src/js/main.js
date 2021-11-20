import '../sass/main.scss';
import 'jquery-match-height';
jQuery(document).ready(function(){
    jQuery('.product-small > .col-inner').matchHeight();
    jQuery('.title-wrapper').matchHeight();
    jQuery('.post-item .box-text').matchHeight();
})
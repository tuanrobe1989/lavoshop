<?php
// Add custom Theme Functions hereadd_filter( 'upload_mimes', 'my_myme_types', 1, 1 );
add_filter( 'upload_mimes', 'my_myme_types', 1, 1 );
add_filter( 'mine_types', 'my_myme_types', 1, 1 );
function my_myme_types( $mime_types ) {
    $mime_types['webp'] = 'image/webp';
    return $mime_types;
}
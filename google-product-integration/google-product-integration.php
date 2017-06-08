<?php 
/**
 * @package Google Product Integration
 * @version 0.1
 */
/*
Plugin Name: Google Shopping Product Integration
Description: Push Woocommerce products to googles shopping service
Author: John Bland
Version: 0.1
Author URI: http://johnisbland.com
*/

//Define the product feed php page
function products_feed_rss2() {
 $rss_template = ( __DIR__ ) . '/product-feed.php';
 load_template ( $rss_template );
}

//Add the product feed RSS
add_action('do_feed_products', 'products_feed_rss2', 10, 1);

//Update the Rewrite rules
add_action('init', 'my_add_product_feed');

//function to add the rewrite rules
function my_rewrite_product_rules( $wp_rewrite ) {
 $new_rules = array(
 'feed/(.+)' => 'index.php?feed='.$wp_rewrite->preg_index(1)
 );
 $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}

//add the rewrite rule
function my_add_product_feed( ) {
 global $wp_rewrite;
 add_action('generate_rewrite_rules', 'my_rewrite_product_rules');
 $wp_rewrite->flush_rules();
}

require_once( 'custom-fields-code.php' );
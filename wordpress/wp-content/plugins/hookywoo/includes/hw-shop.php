<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
add_action( 'woocommerce_before_main_content', 'HookyWoo_before_shop_page_content' );
function HookyWoo_before_shop_page_content() {
	echo '<div class="hw-before-shop-page-content">' . get_option( 'before_shop_page_content' ) . '</div>';
}
/*Add content below Shop title 
** Other default Woo Hooks using woocommerce_archive_description
woocommerce_taxonomy_archive_description', 10 
woocommerce_product_archive_description', 10 
*/
add_action( 'woocommerce_archive_description', 'HookyWoo_below_shop_page_title' );
function HookyWoo_below_shop_page_title() {
	echo '<div class="hw-below-shop-title">' . get_option( 'shop_page_description' ) . '</div>';
}

/*Add content before shop loop product
** Other default Woo Hooks using woocommerce_before_shop_loop_item
woocommerce_template_loop_product_link_open', 10 
woocommerce_template_loop_product_link_close', 5
woocommerce_template_loop_add_to_cart', 10
*/
add_action( 'woocommerce_before_shop_loop_item', 'HookyWoo_above_loop_product_image' );
function HookyWoo_above_loop_product_image() {
	echo '<div class="hw-above-loop-image">' . get_option( 'before_loop_product_image' ) . '</div>';
}

/*Add content after loop product image and below title
** Other default Woo Hooks using woocommerce_shop_loop_item_title
woocommerce_template_loop_product_title', 10
*/
add_action( 'woocommerce_shop_loop_item_title', 'HookyWoo_after_loop_product_image', 5 );
function HookyWoo_after_loop_product_image() {
	echo '<div class="hw-after-loop-image">' . get_option( 'after_loop_product_image' ) . '</div>';
}

/*Add content after loop product title
** Other default Woo Hooks using woocommerce_shop_loop_item_title
woocommerce_template_loop_rating', 5
woocommerce_template_loop_price', 10
*/
add_action( 'woocommerce_after_shop_loop_item_title', 'HookyWoo_after_loop_product_title', 5 );
function HookyWoo_after_loop_product_title() {
	echo '<div class="hw-after-loop-title">' . get_option( 'after_loop_product_title' ) . '</div>';
}

/*Add content before add to cart button
** Other default Woo Hooks using woocommerce_after_shop_loop_item
woocommerce_template_loop_product_link_close', 5
woocommerce_template_loop_add_to_cart', 10 
*/
add_action( 'woocommerce_after_shop_loop_item', 'HookyWoo_before_loop_product_cart_button' );
function HookyWoo_before_loop_product_cart_button() {
	echo '<div class="hw-before-loop-item-cart-button">' . get_option( 'before_loop_product_cart_button' ) . '</div>';
}

/*Add content after shop loop
** Other default Woo Hooks using woocommerce_after_main_content
woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
*/
add_action( 'woocommerce_after_main_content', 'HookyWoo_after_shop_loop', 5 );
function HookyWoo_after_shop_loop() {
	echo '<div class="hw-after-shop-loop">' . get_option( 'after_main_shop_content' ) . '</div>';
}
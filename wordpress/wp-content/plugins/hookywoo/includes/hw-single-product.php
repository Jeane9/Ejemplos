<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
//Add content before Product Title
add_action( 'woocommerce_single_product_summary', 'HookyWoo_before_title_content', 3 );
function HookyWoo_before_title_content() {
  echo '<div class="hw-before-title">' . get_option( 'before_product_title' ) . '</div>';
}

//Add content after Short Description
add_action( 'woocommerce_before_add_to_cart_form', 'HookyWoo_after_short_description_content' );
function HookyWoo_after_short_description_content() {
	echo '<div class="hw-after-short-description">' . get_option( 'after_short_description' ) . '</div>';
}

//Add content before Variations
add_action( 'woocommerce_before_variations_form', 'HookyWoo_before_variations_content' );
function HookyWoo_before_variations_content() {
	echo '<div class="hw-before-variations">' . get_option( 'before_variations_content' ) . '</div>';
}

//Add content after Add to Cart button
add_action( 'woocommerce_after_add_to_cart_button', 'HookyWoo_after_add_to_cart_content' );
function HookyWoo_after_add_to_cart_content() {
	echo '<div class="hw-after-cart">' . get_option( 'after_add_to_cart_button' ) . '</div>';
}

//Add content after Variations
add_action( 'woocommerce_after_variations_form', 'HookyWoo_after_variations_content' );
function HookyWoo_after_variations_content() {
	echo '<div class="hw-after-variations">' . get_option( 'after_variations_content' ) . '</div>';
}

//Add content before Product Meta
add_action( 'woocommerce_product_meta_start', 'HookyWoo_before_product_meta_content' );
function HookyWoo_before_product_meta_content() {
	echo '<div class="hw-before-product-meta">' . get_option( 'before_product_meta' ) . '</div>';
}

//Add content after Product Meta
add_action( 'woocommerce_product_meta_end', 'HookyWoo_after_product_meta_content' );
function HookyWoo_after_product_meta_content() {
	echo '<div class="hw-after-product-meta">' . get_option( 'after_product_meta' ) . '</div>';
}

//Add content before Product Tabs
add_action( 'woocommerce_after_single_product_summary', 'HookyWoo_before_product_tabs_content' );
function HookyWoo_before_product_tabs_content() {
	echo '<div class="hw-before-product-tabs">' . get_option( 'before_tabs_section' ) . '</div>';
}

//Add content after Product
add_action( 'woocommerce_after_single_product', 'HookyWoo_after_product_content' );
function HookyWoo_after_product_content() {
	echo '<div class="hw-after-product">' . get_option( 'after_product_content' ) . '</div>';
}






















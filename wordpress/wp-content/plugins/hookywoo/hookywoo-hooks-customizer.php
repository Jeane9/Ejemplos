<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Plugin Name: HookyWoo WooCommerce Hooks Customizer
 * Plugin URI: https://github.com/RidgeviewTech/HookyWoo-Pro/settings
 * Description: WYSIWYG Editor for WooCommerce Hooks
 * Author: Jason Robie
 * Author URI: https://ridgeviewtechnology.com/
 * Version: 1.4.1
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

class HookyWoo_Plugin {

  public function __construct() {
    // Hook into the admin menu
    add_action( 'admin_menu', array( $this, 'create_plugin_settings_page' ) );

      // Add Settings and Fields
    add_action( 'admin_init', array( $this, 'setup_sections' ) );
    add_action( 'admin_init', array( $this, 'setup_single_page_fields' ) );
    add_action( 'admin_init', array( $this, 'setup_shop_page_fields' ) );
    add_action( 'admin_enqueue_scripts', 'hookywoo_styles' );
    add_action( 'wp_enqueue_scripts', 'hookywoo_styles' );
      function hookywoo_styles() {
        wp_register_style( 'hookywoo_styles',  plugin_dir_url( __FILE__ ) . 'css/style.css' );
        wp_enqueue_style( 'hookywoo_styles' );
    }

      include_once( plugin_dir_path( __FILE__ ) . 'includes/hw-shop.php' );
      include_once( plugin_dir_path( __FILE__ ) . 'includes/hw-single-product.php' );
  }

  public function create_plugin_settings_page() {
    // Add the menu item and page
    $page_title = 'HookyWoo Settings Page';
    $menu_title = 'HookyWoo Settings';
    $capability = 'manage_options';
    $slug = 'hookywoo_settings_page';
    $callback = array( $this, 'hookywoo_plugin_settings_page_content' );

    add_submenu_page( 'woocommerce', $page_title, $menu_title, $capability, $slug, $callback );
  }

  public function hookywoo_plugin_settings_page_content( $active_tab = '' ) {?>
    <div class="wrap">
      <h2>HookyWoo WooCommerce Hooks Customization</h2><?php
         if( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ){
           $this->admin_notice(); 
         } ?>
      <?php if( isset( $_GET[ 'tab' ] ) ) {
        $active_tab = $_GET[ 'tab' ];
      } else if( $active_tab == 'shop_page_options' ) {
        $active_tab = 'shop_page_options';
      } else {
        $active_tab = 'single_page_options';
      } ?>
    
      <h2 class="nav-tab-wrapper">
        <a href="?page=hookywoo_settings_page&tab=single_page_options" class="nav-tab <?php echo $active_tab == 'single_page_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Single Product Page Options', 'hookywoo' ); ?></a>
        <a href="?page=hookywoo_settings_page&tab=shop_page_options" class="nav-tab <?php echo $active_tab == 'shop_page_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Shop/Archive Page Options', 'hookywoo' ); ?></a>
      </h2>
    
      <form method="post" action="options.php">
        <?php
          if( $active_tab == 'single_page_options' ) {
            settings_fields( 'single_product_page_section' );
            do_settings_sections( 'single_product_page_section' );
          } elseif( $active_tab == 'shop_page_options' ) {
            settings_fields( 'shop_archive_page_section' );
            do_settings_sections( 'shop_archive_page_section' );
          }  
          submit_button();
        ?>
      </form>
    </div> <?php }
    
  public function admin_notice() { ?>
      <div class="notice notice-success is-dismissible">
          <p>Hooray! Your settings have been updated!</p>
      </div><?php
  }

  public function setup_sections() {
      add_settings_section( 'single_product_page_section', '', array( $this, 'single_product_section_callback' ) , 'single_product_page_section' );
      add_settings_section( 'shop_archive_page_section', '', array( $this, 'shop_section_callback' ), 'shop_archive_page_section' );
  }
  public function single_product_section_callback() { ?>
        <h1>Single Product Customization Section</h1>
        <h2 class="hookywoo">Custom Hook locations are highlighted in bold, green, italic font</h2>
        <h3 class="hookywoo">Use the WYSIWYG editor titles to know where you want your content to appear</h3>
        <?php echo '<img src="' . plugins_url( 'images/single-product.png', __FILE__ ) . '" > ';
      }
  public function shop_section_callback() { ?>       
        <h1>Shop/Archive Page Customization Section</h1>
        <h2 class="hookywoo">Custom Hook locations are highlighted in bold, green, italic font</h2>
        <h3 class="hookywoo">Use the WYSIWYG editor titles to know where you want your content to appear</h3>
        <?php echo '<img src="' . plugins_url( 'images/shop.png', __FILE__ ) . '" > ';
       }

  public function setup_single_page_fields() {
    include ( plugin_dir_path( __FILE__ ) . 'includes/single-page-fields.php' );
  }
  public function setup_shop_page_fields() {
    include ( plugin_dir_path( __FILE__ ) . 'includes/shop-page-fields.php' );
  }

  public function field_callback( $arguments ) {
    $value = get_option( $arguments['uid'] );
    if( ! $value ) {
        $value = $arguments['default'];
    }
    switch( $arguments['type'] ){
        case 'text':
        case 'textarea':
            printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="3" cols="50">%3$s</textarea>', $arguments['uid'], $arguments['placeholder'], $value );
            break;
    }
    if( $helper = $arguments['helper'] ){
        printf( '<span class="helper"> %s</span>', $helper );
    }
    if( $supplemental = $arguments['supplemental'] ){
        printf( '<p class="description">%s</p>', $supplemental );
    }
  }
}
new HookyWoo_Plugin();
}
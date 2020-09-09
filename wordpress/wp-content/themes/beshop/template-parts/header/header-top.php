<?php
/**
 * Template part for displaying header top bar
 *
 * @link https://wpthemespace.com/product/beshop
 *
 * @package BeShop
 */
$beshop_topbar_mtext = get_theme_mod( 'beshop_topbar_mtext', esc_html__('Welcome to Our Website','beshop') );
$beshop_topbar_menushow = get_theme_mod( 'beshop_topbar_menushow',1 );
$beshop_topbar_search = get_theme_mod( 'beshop_topbar_search',1 );


?>

<div class="beshop-tophead bg-dark text-light pt-1 pb-1">
	<div class="container">
		<div class="row">
		<?php if($beshop_topbar_mtext): ?>
			<div class="col-lg-auto">
				<span class="bhtop-text pt-2"><?php echo esc_html($beshop_topbar_mtext); ?></span>
			</div>
		<?php endif; ?>
		<?php if($beshop_topbar_menushow && has_nav_menu( 'btop-menu' )): ?>
			<div class="col-lg-auto ml-auto">
				<div class="top-menu list-hide text-white">
					<?php 
						wp_nav_menu(
							array(
								'theme_location' => 'btop-menu',
								'menu_id'        => 'btop-menu',
								'menu_class'     => 'btop-menu',
								'depth'          => 1,							
							)
						);
					 ?>
				</div>
			</div>
			<?php endif; ?>
		<?php if($beshop_topbar_search): ?>
			<div class="col-lg-auto <?php if(empty($beshop_topbar_menushow) || !has_nav_menu( 'btop-menu' )): ?>ml-auto<?php endif; ?>">
				<div class="header-top-search">
					<?php get_search_form(); ?>
				</div>
			</div>
		<?php endif; ?>
		</div>
	</div>
</div>
<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BeShop
 */
$beshop_topfooter_show = get_theme_mod( 'beshop_topfooter_show', 1 );

?>
<?php if( is_active_sidebar( 'footer-widget' ) && $beshop_topfooter_show ): ?>
	<div class="footer-top mt-5 pb-5 pt-5 bg-dark">
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<?php dynamic_sidebar( 'footer-widget' ) ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

	<footer id="colophon" class="site-footer text-center">
		<div class="site-info">
			<div class="row">
			<div class="col-xs-12 col-sm-4">
				<h6>Contáctanos</h6>
				<br>
				<a href="https://api.whatsapp.com/send?phone=51970200510&text=Hola,%20%C2%BFme%20podr%C3%ADa%20brindar%20informaci%C3%B3n%20de%20sus%20productos?%F0%9F%98%8A">
					<i class="fab fa-whatsapp fa-4x" title="pokorastore"></i>
					<p> 970200510</p>
				</a>

			</div>
			<div class="col-xs-12 col-sm-4">
				<h6>Síguenos: @pokorastore</h6>
				<br>
				<a href="https://www.facebook.com/pokorastore/" title="pokorastore">
					<i class="fab fa-facebook fa-4x"></i>
				</a>
				<!-- <a href="https://instagram.com/pokorastore?igshid=1dgu7jn978ynw" title="pokorastore"> 
					<i class="fab fa-instagram fa-4x"></i>
				</a> -->
			</div>
			<div class="col-xs-12 col-sm-4">
				<h6>Síguenos: @pokorastore</h6>
				<br>
				<!-- <a href="https://www.facebook.com/pokorastore/" title="pokorastore">
					<i class="fab fa-facebook fa-4x"></i>
				</a> -->
				<a href="https://instagram.com/pokorastore?igshid=1dgu7jn978ynw" title="pokorastore"> 
					<i class="fab fa-instagram fa-4x"></i>
				</a>
			</div>
			</div>
		</div>
			<p class="footer-copyright">&copy;
				<?php
					echo date_i18n(
					/* translators: Copyright date format, see https://www.php.net/date */
					_x( 'Y', 'copyright date format', 'beshop' )
					);
				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			</p><!-- .footer-copyright -->
			
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php
	if ( function_exists( 'beshop_woocommerce_header_cart' ) ) {
		beshop_woocommerce_header_cart();
	}
?>
<?php wp_footer(); ?>

</body>
</html>
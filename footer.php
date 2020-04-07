<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

$the_theme = wp_get_theme();
$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_sidebar( 'footerfull' ); ?>   

<div class="wrapper" id="wrapper-footer">
	<!--write post Modal -->
	<?php if ( is_user_logged_in() ) { ?>
	<button class="btn alt-button" type="button" data-toggle="modal" data-target="#postModal">Add a post</button>	
	<div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="the-greeting" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <button type="button" class="close" data-dismiss="modal" id="closer" aria-label="Close">
	          <span aria-hidden="true">Close <span class="close-x">X</span></span>
	        </button>
	      <div class="modal-header">
	        <h2 class="modal-title" id="the-greeting">Hi</h2>       
	      </div>
	      <div class="modal-body">
	        <div id="the-person"></div>
	        <?php echo do_shortcode('[gravityform id="1" title="false" description="false"]');?>
	      </div>
	      <div class="modal-footer">        
	      </div>
	    </div>
	  </div>
	</div>
    <!-- END Modal -->
<?php } ?>
	<footer class="<?php echo esc_attr( $container ); ?>">
		<div class="row" id="insta-pot"></div>
		<a class="btn btn-primary" href="https://www.instagram.com/explore/tags/fotofika2020/">See More Fika Fotos</a>
		<div class="row" id="footer">
		

							<div class="footer-widget col-md-3">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer - far left") ) : ?><?php endif;?>
							</div>
							<div class="footer-widget col-md-3">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer - medium left") ) : ?><?php endif;?>
							</div>
							<div class="footer-widget col-md-3">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer - medium right") ) : ?><?php endif;?>
							</div>
							<div class="footer-widget col-md-3">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer - far right") ) : ?><?php endif;?>
							</div>	
											


		</div><!-- row end -->

	</div><!-- container end -->

</footer><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>


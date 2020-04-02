<?php
/**
 * Partial template for content in challenge.php
 *
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>		

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php the_content(); ?>

		<!--should be repeater field with artist, paragraph statement saying why they matter, maybe repeater field of URLs to their sites/videos etc. -->
		<?php get_the_artists();?>

		<?php get_the_tutorials();?>
		<!--should be repeater field with title, concept, link -->
		<?php echo get_the_vocab_words();?>
		
		<h2 id="challenges" class="magic-topics">&nbsp;</h2>
		<div class="daily assignment row">
				<?php 
					$daily_tag = acf_fetch_daily_challenge_hashtag();
					echo acf_fetch_daily_challenge_description($daily_tag);?>
				<?php		 
				 	echo challenge_submission_structure($daily_tag);
				 ?>
				<?php echo do_shortcode('[elfsight_instagram_feed source="' . acf_fetch_daily_challenge_hashtag_tag() . '" limit="32" widget_title=""]')?>
				 <?php 
						get_challenges(get_the_title(), $daily_tag);				
					?>
		</div>
			<div class="daily assignment row">
				<div class="weekly assignment">	

			<?php 
				$weekly_tag = acf_fetch_weekly_challenge_hashtag();
				echo acf_fetch_weekly_challenge_description($weekly_tag);
			?>
			
			<?php 
				echo challenge_submission_structure($weekly_tag);
			?>

			<?php echo do_shortcode('[elfsight_instagram_feed source="' . acf_fetch_weekly_challenge_hashtag() . '" limit="32" widget_title=""]')?>				
					 
				<?php 
						get_challenges(get_the_title(), $weekly_tag);
					?>
		</div>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<!--CONTACT Modal -->
	<div class="modal fade" id="submissionModal" tabindex="-1" role="dialog" aria-labelledby="submitWork" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <button type="button" class="close" data-dismiss="modal" id="closer" aria-label="Close">
	          <span aria-hidden="true">Close <span class="close-x">X</span></span>
	        </button>
	      <div class="modal-header">
	        <h2 class="modal-title" id="submitWork">Submit Work</h2>       
	      </div>
	      <div class="modal-body">
	        <div id="the-person"></div>
	        <?php echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]');?>
	      </div>
	      <div class="modal-footer">        
	      </div>
	    </div>
	  </div>
	</div>
	    <!-- END Modal -->

	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

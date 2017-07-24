<?php get_header(); ?>

	<main role="main">
	<!-- section -->

		<div class='container'>
			<?php if (have_posts()): while (have_posts()) : the_post(); ?>

				<div class='row'>
					<div class='col s12'>
							<!-- article -->
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
								<!-- post thumbnail -->
<!-- 								<?php if ( has_post_thumbnail()) : // Check if Thumbnail exists ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
										<?php the_post_thumbnail(); // Fullsize image for the single post ?>
									</a>
								<?php endif; ?> -->
								<!-- /post thumbnail -->					
								
								
								<?php the_content(); // Dynamic Content ?>
					
								
								<hr>
								<p><?php the_tags('Tags: ', ', '); ?></p>
								<!-- <p><?php _e( 'This post was written by ', 'html5blank' ); the_author(); ?></p> -->

						
							</article>
							<!-- /article -->
					</div>
				</div>

			<?php endwhile; ?>
					
			<?php else: ?>
		
				<!-- article -->
				<article>
		
					<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>
		
				</article>
				<!-- /article -->
		
			<?php endif; ?>
			

		</div>

	</main>

<?php get_template_part( 'prefoot' );?>	

<?php get_footer(); ?>

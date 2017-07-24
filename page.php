<?php 

get_header(); ?>

	<main role="main">
		<div class="container">
			

			        	<section id='pageContent'>				
							<?php while ( have_posts() ) : the_post(); ?>
								<?php the_content(); ?>
							<?php endwhile; ?>
						</section>

		</div>		
	</main>

<?php get_template_part( 'prefoot' );?>


<?php get_footer(); ?>



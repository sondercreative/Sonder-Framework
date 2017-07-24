<?php get_header(); ?>

	<main role="main">
		<div class="container">
			<div class="row">
			<div class="col s12 m8 l8">
				<!-- section -->
				<section>

				<h1><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>

				<?php get_template_part('loop'); ?>

				<?php get_template_part('pagination'); ?>

				</section>
				<!-- /section -->
			</div>
			<div class="col s12 m4 l4">
				<?php get_sidebar(); ?>
			</div>
		</div>		
	</main>




<?php get_footer(); ?>

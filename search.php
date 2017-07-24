<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>
			<div class='container'>
				<div class='row'>
					<div class='col m8'>
			
						<?php get_template_part('loop'); ?>
			
						<?php get_template_part('pagination'); ?>
					</div>
					<div class='col m4'>
						<h4>Didn't find what you were looking for?</h4>
						<p>Try your search again:</p>
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
		</section>
		<!-- /section -->
	</main>



<?php get_footer(); ?>

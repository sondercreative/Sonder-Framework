<?php get_header(); ?>

	<main role="main">
		<div class="container">

			<div class='row'>
				<div class='col s12 m12 l9'>
					<!-- section -->
					<section>

					<?php get_template_part('loop'); ?>

					<?php get_template_part('pagination'); ?>

					</section>
					<!-- /section -->
				</div>
				<div class='col s12 m12 l3'>
					<?php get_sidebar(); ?>
				</div>
			</div>

		</div>
	</main>



<?php get_footer(); ?>

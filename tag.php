<?php get_header(); ?>

	<main role="main">
		<div class="container">

			<div class='row'>
				<div class='col l9'>
					<!-- section -->
					<section>

					<h1><?php _e( 'Tag: ', 'html5blank' ); echo single_tag_title('', false); ?></h1>

					<?php get_template_part('loop'); ?>

					<?php get_template_part('pagination'); ?>

					</section>
					<!-- /section -->
				</div>
				<div class='col l3 m12 s12'>
				
					<?php get_sidebar(); ?>
				</div>
			</div>

		</div>
	</main>



<?php get_footer(); ?>

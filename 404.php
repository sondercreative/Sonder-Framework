<?php get_header(); ?>

	<main role="main">
		<!-- section -->
		<section>
			<div class='container'>
				<div class='row'>
					<div class='col s8'>

			<article id="post-404">

				<h1><?php _e( 'Sorry', 'html5blank' ); ?></h1>


				<h4>This page may have moved or been deleted.<br><a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'html5blank' ); ?></a></h4>


			</article>
					</div>
					<div class='col s4'>
						<h4>Can't find what you were looking for?</h4>
						<p>Try Searching:</p>
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
		</section>
		<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer(); ?>

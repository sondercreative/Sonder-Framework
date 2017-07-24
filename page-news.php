<?php /* Template Name: News */ get_header(); ?>

	<main role="main">
		<section>
			<div class="container">

	        	<section id='pageContent'>				
					<?php while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; ?>
				</section>



				<div class="row filters valign-wrapper">
					<div class="col s12 m6 l6 newsFiltering">

						<select class="filters-select">
						  <option value="*">Show All</option>
						  <?php $cats = get_categories();
						  		foreach($cats as $cat){
						  			$name = $cat->name;
						  			$slug = $cat->slug;
						  			echo "<option value='.$slug'>$name</option>";
						  		}
						  ?>
						</select>
						
						<div class="loaderWrap">
							<div class="loader loaded"><img src="<?php echo get_bloginfo('template_url') ?>/img/ajax-loader.gif"></div>
						</div>
						
					</div>
				</div>

				<hr>


				<div class="row news-grid">

				    <?php
					    $args = array(
					     'post_type' => 'post',
					     'posts_per_page' => '6'
					    );
					    $blogURL = get_bloginfo('template_url');
					    $newsFeed = new WP_Query($args);
					    while($newsFeed->have_posts()) : $newsFeed->the_post();

						$copy = get_the_content();
						$copy = strip_tags($copy);
						$copy = preg_replace('/\[.*?\]|/', '', $copy);
						$copy = substr($copy,0,150);
						$categories = get_the_category();
						$catSlug = '';
						$id = get_the_ID();
						if ( ! empty( $categories ) ) {
						    foreach( $categories as $category ) {
						        $output .= '<a class="filter" data-filter=".' . esc_html( $category->slug ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
						    }
						    $catList =  trim( $output, $separator );
						}

						$catSlug .= esc_html( $category->slug ).' ';

						if ( has_post_thumbnail() ) {
							$thumb_id = get_post_thumbnail_id();
							$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'custom-size', true);
							$thumb_url = $thumb_url_array[0];
						} else {
							$thumb_url = $blogURL . "/img/thumb.jpg";
						}

					?>


		            <article class='col s12 m6 l6 newsItem <?php echo $catSlug ?>' id='<?php echo $id ?>'>

			              	<a href='<?php echo get_the_permalink(); ?>'>
			                  	<img src='<?php echo $thumb_url ?>' class='newsImage'>
			                </a>
			                <div class='newsDesc'>
			                    <h3><?php echo get_the_title(); ?></h3>
			                    <p class='postedin'><strong>Posted:</strong> <?php echo get_the_time('M j, Y'); ?></p>
			                    <p><?php echo $copy ?>... </p>
			                    <div class="readMore">
			                    	<a href='<?php echo get_the_permalink(); ?>' class="btn">Read More <i class='ion-chevron-right'></i></a>
			                    </div>
			                </div>

		            </article>  


					<?php endwhile; wp_reset_query();?>

				</div>
			
			</div>
		</section>
		<div class="center-align loadMoreNews"><button class="load btn">Load More <div class="loader loaded"><span class="ion-chevron-down"></span><img src="<?php echo get_bloginfo('template_url') ?>/img/ajax-loader-white.gif"></div></button></div>
	</main>		


	

<?php get_template_part( 'prefoot' );?>	

<?php get_footer(); ?>



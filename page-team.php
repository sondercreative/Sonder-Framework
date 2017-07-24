<?php /* Template Name: Team */ get_header(); ?>

	<main role="main">
		<section>
			<div class="container">

	        	<div id='pageContent'>				
					<?php while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; ?>
				</div>

				<div class="row news-grid team">
	 				<?php
					    $args = array(	
					     'post_type' => 'team-member',
					     'posts_per_page' => '-1'
					    );
					    $blogURL = get_bloginfo('template_url');
					    $teamfeed = new WP_Query($args);
					    while($teamfeed->have_posts()) : $teamfeed->the_post();

					?>


		            <div class='col s12 m6 l4 newsItem'>
		            		<div class="profImgWrap">
		            			<img src="<?php echo get_bloginfo('template_url'); ?>/img/smDots.png" class='smDots'>
			                  	<img src='<?php echo types_render_field("profileimg",array("url"=>true, "size"=>"profile-size")) ?>' class='teamImage'>
			                </div>
			                    <h3 class='teamTitle'><?php echo get_the_title(); ?><br>
			                    	 <span><?php echo types_render_field("position",array('raw'=>true)) ?></span>
			                    </h3>
			                   
			                
			                    <p class="teamdesc"><?php echo types_render_field("bio",array('raw'=>true)) ?></p>
			                
			                

		            </div>  


					<?php endwhile; wp_reset_query();?>
				</div>			

			</div>
		</section>
	</main>		


	

<?php get_template_part( 'prefoot' );?>	

<?php get_footer(); ?>



<?php 
/**
 * Template Name: Side Bar
 */
get_header(); ?>

	<main role="main">
		<div class="container">

			<!-- section -->
			<section>

				<div class='row'>
					<div class='col l3 m12 s12'>
				
					    <div class="childnav_toggle btn">
					      	<i class="ion-navicon"></i> Pages in this Section
					    </div>
						<div class='childNav'>

							
							<ul class='submenu'>
								<?php

								$parent = array_reverse(get_post_ancestors($post->ID));
								$first_parent = get_page($parent[0]);
								$parent_name = $first_parent->post_title;
								$parent_link = get_permalink($first_parent);
								echo "<li class='parentTitle'><a href='".$parent_link."'><strong>".$parent_name."</strong></a></li>";


								if(wp_get_post_parent_id( $post_ID )==0){
									$id = get_the_id($page->ID);
								}else if (wp_get_post_parent_id( wp_get_post_parent_id( $post_ID ) )==0){
									$id =  wp_get_post_parent_id( $post_ID );
								}else if (wp_get_post_parent_id( wp_get_post_parent_id( wp_get_post_parent_id( $post_ID )) )==0){
									$id = wp_get_post_parent_id( wp_get_post_parent_id( $post_ID ) );
								}else{
									$id = wp_get_post_parent_id( wp_get_post_parent_id( wp_get_post_parent_id( $post_ID ) ) );
								}
							
								wp_list_pages("child_of=$id&sort_column=ID&sort_column=menu_order&title_li="); 
								?>
							</ul>
						</div>
					</div>
					<div class='col l9'>
			        	<section id='pageContent'>				
							<?php while ( have_posts() ) : the_post(); ?>
								<?php the_content(); ?>
							<?php endwhile; ?>
						</section>
						<?php 
					if($pagename=='jobs-in-transportation'){
						$args = array('post_type'=>array('carrier','supplier'),'posts_per_page'=>'-1','orderby'=>'title','order'=>'ASC');	
					
		  		query_posts($args);
					while ( have_posts() ) : the_post();
						if(types_render_field("hiring")==1){
							$blogURL = get_bloginfo('template_url');
							$terms = get_the_terms($post->ID,'carrier-type');
							$typeName = '';
							$typeSlug = '';
							if($terms != ''){
								foreach($terms as $term):
									$typeName .= $term->name.'~';
									$typeSlug .= $term->slug.'~';
								endforeach;//Endforeach $term
							}
							$typeName = rtrim($typeName, "~");
							$typeSlug = rtrim($typeSlug, "~");
							if ( ! empty( $categories ) ) {
								foreach( $categories as $category ) {
									$output .= '<a class="filter" data-filter=".' . esc_html( $category->slug ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
									$catSlug .= esc_html( $category->slug ).' ';
								}
								$catList =  trim( $output, $separator ); 
							}
							$title = get_the_title();
							$copy = get_the_content();
							$logo = types_render_field( "logo", array( "output" => "raw"));

							if ($logo == ''){
								$logo = $blogURL . "/img/memberThumb.jpg";
							}
							$contact = types_render_field( "contact-info");
							$hireURL = types_render_field( "hiring-url");
							$supArray[] = array('title'=>$title,'content'=>$copy,'contact'=>$contact,'logo'=>$logo,'typeName'=>$typeName,'typeSlug'=>$typeSlug);
						}
					endwhile;
				wp_reset_query();
							
								
								foreach($supArray as $sup){

									$title= $sup['title'];
									$copy =$sup['content'];
									$logo =$sup['logo'];
									$contact =$sup['contact'];
									$typeName =$sup['typeName'];
									$typeSlug =$sup['typeSlug'];
									$tSlugClean = str_replace('~',' ',$typeSlug);
									$blogURL = get_bloginfo('template_url');
									echo "<div class='row port-item $tSlugClean'>
											<div class='col s12 m3 l2 membLogo'>
												<img src='$logo'>
											</div>
											<div class='col s12 m9 offset-m3 l7 membDesc'>
												<h3>$title</h3>
												<p>$copy</p>

												<a href='$hireURL' class='btn waves-effect waves-light'>Apply Now</a>
											</div>
											<div class='col s12 m9 offset-m3 l3 membCont'>
												<div class='contactContain'>
													$contact
												</div>
											</div>
										</div> ";
								}
							}
						?>
					</div>
				</div>

			</section>
			<!-- /section -->
		</div>		
	</main>

<?php get_template_part( 'prefoot' );?>


<?php get_footer(); ?>

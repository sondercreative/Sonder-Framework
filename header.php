<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php if(types_render_field("page-title") != ""){echo types_render_field("page-title",array('raw'=>true));} else {wp_title(''); }?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
		
		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php get_site_icon_url() ?>" rel="shortcut icon">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">



		<?php
			$metaKey = types_render_field("page-keywords");
			$metaDesc = types_render_field("page-description");

			global $post;
			$metaCopy = $post->post_content;
			$metaCopy = strip_tags($metaCopy);
			$metaCopy = preg_replace('/\[.*?\]|/', '', $metaCopy);
			$metaCopy = substr($metaCopy,0,155);

	        if($metaKey = types_render_field("page-keywords")) {
	            $metaKey = types_render_field("page-keywords",array('raw'=>true));
	        } else {
	            $metaKey = get_the_title();
	        }
	        if($metaDesc = types_render_field("page-description")) {
	            $metaDesc = types_render_field("page-description",array('raw'=>true));
	        } else {
	            $metaDesc = $metaCopy;
	        }

	        echo "
			<meta name='keywords' content='$metaKey'>
			<meta name='description' content='$metaDesc'>
	        "
		?>


		<!--Import Google Icon Font-->
      	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<?php wp_head(); ?>

	</head>


	<body <?php body_class(); ?> >

	<?php
	   $logo = get_theme_mod( 'themeslug_logo' );

        if($logo != ""){
			$link = get_bloginfo('url');
			$homeLink ="<a id='logo-container' href='$link' class='logoLink'><img src='$logo'></a>";
      
        } else {
			$link = get_bloginfo('url');
			$siteName = get_bloginfo('name');
           $homeLink ="<a id='logo-container' href='$link' class='homeLink'>$siteName</a>";
        }

		while ( have_posts() ) : the_post(); 
				$page_perma = wp_logout_url(get_the_permalink());
		endwhile; 
	?>
	

	<div class='navigation'>
		<div class='navbar-fixed'>
			<nav role='navigation' id='navHead'>
				<div class='nav-wrapper'>

					<div class="navBG">

							<?php $navDev = array('theme_location' => 'header-menu','fallback_cb' => 'wp_page_menu','items_wrap' => '

								<div class="navContain">
									<div class="row">
										<div class="col s8 m6 l2">
											<div class="homeLink">
											'.$homeLink.'
											</div>
										</div>

										<div class="col hide-on-med-and-down m10 mainMenu">
											<div class="navWrap">
												
												<ul class="hide-on-med-and-down desktopMenu" id="%1$s" class="%2$s">%3$s</ul>
												
											</div>
										</div>
										
											<div class="searchIcon"><a href="#" class=" search-act"><i class="ion-ios-search search-open"></i><i class="ion-ios-close-empty search-close"></i></a></div>

												<div class="searchWrap">
													<form role="search" action="'.$link.'" method="get" id="searchform">
														<input type="text" class="form-control" name="s" placeholder="Search"/>
														<button type="submit" class="form-control" alt="Search" /><i class="material-icons">search</i></button>
													</form>
												</div>

										<div class="mobile nav-actiavator col ">
											<button class="hamburger hamburger--spin" type="button">
											  <span class="hamburger-box">
												<span class="hamburger-inner"></span>
											  </span>
											</button>
										</div>
									</div>
								</div>

								<div class="mobileWrap hide-on-large-only"><ul id="%1$s" class="%2$s">%3$s</ul></div>
										
								</div>','walker' => new WPSE_78121_Sublevel_Walker); 	
										
				                wp_nav_menu($navDev);
										
							?>
					</div>
				</div>
			</nav>
		</div>
	</div>





		<?php 
		if(!is_front_page()){

				if(is_page()){
				$headContent = "<h1>".get_the_title()."</h1>";	
				}
				if(is_search()){
					$term =  get_search_query();
					$headContent ="<h1>Results for: $term</h1>";
					$headImage = esc_url( get_theme_mod('themeslug_header'));
				}
				if(is_tag()){
	        		$headContent = "<h1>Post search</h1>";
	      		}
				if(is_404()){
	        		$headContent = "<h1>404 - Page not found</h1>";
	      		}

		
			?>

				<div class="mainHead">

				    <div id="pageHead">  

				        <div class="container">
				          <div class="intro-wrap row">
				          		<div class="col s12 m12 l12">

						  	   <?php

						  	   	$headIntro = types_render_field("header-intro",array('raw'=>true));

								if(is_page()){
									echo "<h1>".get_the_title()."</h1><p class='headIntro'>$headIntro</p>";
									the_breadcrumb();
								}

								if(is_single()){
									echo "<h1>".get_the_title()."</h1>
									<p class='date'>Posted: <span>".get_the_time('F j, Y')."</span></p>
									<div id='breadcrumbs' class='viewAllPosts'><a href='".get_page_link(118)."'><span class='ion-chevron-left'></span> View All Posts</a></div>";	
								}

								if(is_search()){
									?><h1><?php echo sprintf( __( '%s Search Results for ', 'html5blank' ), $wp_query->found_posts ); echo get_search_query(); ?></h1><?php
								}
								
								if(is_archive()){
									if(is_category()){
										?><h1><?php _e( 'Categories for ', 'html5blank' ); single_cat_title(); ?></h1><?php
										the_breadcrumb();
									} else {
										?><h1><?php  _e( 'Archives', 'html5blank' ); ?></h1><?php
									}
								}

								if(is_tag()){
					        		echo "<h1>Post search</h1>";
					        		the_breadcrumb();
					      		}

								if(is_404()){
					        		echo "<h1>404 - Page not found</h1>";
					      		}

						  	   ?>

						  	   </div>

				          </div>
				        </div>

				    <?php if(is_single()){

				    	$thumbid = get_post_thumbnail_id($post->ID);
					    $imgsrc = wp_get_attachment_image_src($thumbid, 'full');
					    $src = $imgsrc[0];

				    	if ( $src != ""){ ?>

						<div class="singleHead" style="background-image: url(<?php echo $src ;?>);"></div>

				    <?php }} ?>

				    </div>

				</div>

			<?php
		} else {
			//FRONT PAGE HEADER
		 } ?>

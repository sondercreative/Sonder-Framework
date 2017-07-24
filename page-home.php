<?php
/**
 * Template Name: Home Page
 */

get_header(); ?>

<div class="mainHead homeHead">
  <div class="slider">
    <ul class="slides">


<?php 
  $args = array(
         'post_type' => 'home-slider',
         'posts_per_page' => 3,
         'orderby' =>'menu_order',
         'order'  => 'ASC'
         ); 

  $homeslides = new WP_Query($args);

      while($homeslides->have_posts()) : $homeslides->the_post();
        ?> 
        <li>
          <img src="<?php echo types_render_field( "background-image", array( "alt" => "%%ALT%%", "raw" => "true" ) ); ?>" class="plax plaxslow"> <!-- random image -->
          <div class="caption <?php echo types_render_field("slide-alignment", array("raw" => "true")).' '.types_render_field("vertical-align", array("raw" => "true")); ?>">
            <h3><?php echo get_the_title(); ?></h3>
            <div class="slideContent">
                <?php echo types_render_field( "slide-content", array( "suppress_filters" => "true" ) ); ?>
            </div>
          </div>
        </li>

<?php
      endwhile;
    wp_reset_query();
    ?>

    </ul>
  </div>   
</div>




<div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post();
      the_content();
    endwhile; endif; ?>
</div>




<?php get_template_part( 'prefoot' );?>

<?php get_footer(); ?>



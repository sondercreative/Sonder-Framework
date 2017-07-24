<?php
/*
 *  Author: Sonder Creative
 *  URL: sondercreative.ca
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 399, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');
    add_image_size('profile-size', 600, 600, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');


    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/



// class WPSE_78121_Sublevel_Walker extends Walker_Nav_Menu
// {
//     function start_lvl( &$output, $depth = 0, $args = array() ) {
//         $indent = str_repeat("\t", $depth);
//         $output .= "\n$indent<div class='sub-toggle'></div><div class='sub-menu-wrap'><ul class='sub-menu'>\n";
//     }
//     function end_lvl( &$output, $depth = 0, $args = array() ) {
//         $indent = str_repeat("\t", $depth);
//         $output .= "$indent</ul></div>\n";
//     }
// }




// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => '',
		'menu'            => 'main-nav',
		'container'       => 'div',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '<div class="toggle"></div>',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul class="mainMenu">%3$s</ul>',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}





// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

        // Move jQuery to the footer
        wp_scripts()->add_data( 'jquery', 'group', 1 );
        wp_scripts()->add_data( 'jquery-core', 'group', 1 );
        wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

        wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1', true); // Modernizr
        wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('materializescripts', get_template_directory_uri() . '/js/materialize.min.js', array('jquery'), '0.97.5', true); // Custom scripts
        wp_enqueue_script('materializescripts'); // Enqueue it!

        wp_register_script('isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array('jquery'), '1.0.0', true); // Custom scripts
        wp_enqueue_script('isotope'); // Enqueue it!

        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0', true); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!

        wp_localize_script( 'html5blankscripts', 'ajaxpagination', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ));

    }
}

add_action( 'wp_ajax_nopriv_load_posts', 'load_posts' );
add_action( 'wp_ajax_load_posts', 'load_posts' );


function load_posts() {
    $filter = $_POST['filters'];

    $filter = str_replace('.', '', $filter);

    $offset = $_POST['offset'];
    if($filter == "*"){
        $filter = "";
    }

     $args = array(
     'post_type' => 'post',
     'post_per_page' => '3',
     'category_name' => $filter,
     'post__not_in' => $offset,
      );

     $newsFeed = new WP_Query($args);

      while($newsFeed->have_posts()) : $newsFeed->the_post();
        $blogURL = get_bloginfo('template_url');
        $copy = get_the_content();
        $copy = strip_tags($copy);
        $copy = preg_replace('/\[.*?\]|/', '', $copy);
        $copy = substr($copy,0,150);
        $categories = get_the_category();
        $catSlug = '';

        if ( ! empty( $categories ) ) {
            foreach( $categories as $category ) {
                $output .= '<a class="filter" data-filter=".' . esc_html( $category->slug ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
            }
            $catList =  trim( $output, $separator );
        }
        $id = get_the_ID();
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
                    <p class='postedin'><strong>Posted:</strong> <?php echo get_the_time('M j, Y'); ?> in <?php echo $catlist ?></p>
                    <p><?php echo $copy ?>... </p>
                    <div class="readMore">
                        <a href='<?php echo get_the_permalink(); ?>' class="btn">Read More <i class='ion-chevron-right'></i></a>
                    </div>
                </div>

        </article>  

    <?php endwhile; wp_reset_query();
    
    // echo $filter;
    die();
}





// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('news-and-education')) {
         wp_register_script('newsscripts', get_template_directory_uri() . '/js/news-scripts.js', array('jquery'), '1.0.0', true); // Custom scripts
        wp_enqueue_script('newsscripts'); // Enqueue it!
    }

}

// Load HTML5 Blank styles
function html5blank_styles()
{
	wp_register_style('googleFonts','https://fonts.googleapis.com/css?family=Raleway:300,400,400i,700');
	wp_enqueue_style('googleFonts'); // Enqueue it!

    wp_register_style('normalize', get_template_directory_uri() . '/css/normalize.min.css', array(), '1.0', 'all');
    wp_enqueue_style('normalize'); // Enqueue it!

    wp_register_style('materializestyle', get_template_directory_uri() . '/css/materialize.min.css', array(), '1.0', 'all');
    wp_enqueue_style('materializestyle'); // Enqueue it!

    wp_register_style('ionicons', get_template_directory_uri() . '/css/ionicons.min.css', array(), '1.0', 'all');
    wp_enqueue_style('ionicons'); // Enqueue it!

    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('html5blank'); // Enqueue it!
	
    wp_register_style('css-minified', get_template_directory_uri() .'/css/minified.css.php',array(),'1.0','all');
    wp_enqueue_style('css-minified'); // Enqueue it
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Members Login Widget.', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Default Sidebar', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Footer Widget Area 
    register_sidebar(array(
        'name' => __('Footer Widget 1', 'html5blank'),
        'description' => __('Extra footer widget - Will appear right below content wrap', 'html5blank'),
        'id' => 'footer-widget-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Footer Widget Area 
    register_sidebar(array(
        'name' => __('Footer Widget 2', 'html5blank'),
        'description' => __('Social Media Row in footer', 'html5blank'),
        'id' => 'footer-widget-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Footer Widget Area 
    register_sidebar(array(
        'name' => __('Footer Widget 3', 'html5blank'),
        'description' => __('Secondary Footer Menu', 'html5blank'),
        'id' => 'footer-widget-3',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Footer Widget Area 
    register_sidebar(array(
        'name' => __('Footer Widget 4', 'html5blank'),
        'description' => __('Copyright Info', 'html5blank'),
        'id' => 'footer-widget-4',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// // Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
// function html5wp_custom_post($length)
// {
//     return 40;
// }

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
// add_action('init', 'create_post_type_html5'); // Add our HTML5 Blank Custom Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('log_in_out', 'log_in_out'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('login_form', 'login_form'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// // Create 1 Custom Post type for a Demo, called HTML5-Blank
// function create_post_type_html5()
// {
//     register_taxonomy_for_object_type('category', 'html5-blank'); // Register Taxonomies for Category
//     register_taxonomy_for_object_type('post_tag', 'html5-blank');
//     register_post_type('html5-blank', // Register Custom Post Type
//         array(
//         'labels' => array(
//             'name' => __('HTML5 Blank Custom Post', 'html5blank'), // Rename these to suit
//             'singular_name' => __('HTML5 Blank Custom Post', 'html5blank'),
//             'add_new' => __('Add New', 'html5blank'),
//             'add_new_item' => __('Add New HTML5 Blank Custom Post', 'html5blank'),
//             'edit' => __('Edit', 'html5blank'),
//             'edit_item' => __('Edit HTML5 Blank Custom Post', 'html5blank'),
//             'new_item' => __('New HTML5 Blank Custom Post', 'html5blank'),
//             'view' => __('View HTML5 Blank Custom Post', 'html5blank'),
//             'view_item' => __('View HTML5 Blank Custom Post', 'html5blank'),
//             'search_items' => __('Search HTML5 Blank Custom Post', 'html5blank'),
//             'not_found' => __('No HTML5 Blank Custom Posts found', 'html5blank'),
//             'not_found_in_trash' => __('No HTML5 Blank Custom Posts found in Trash', 'html5blank')
//         ),
//         'public' => true,
//         'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
//         'has_archive' => true,
//         'supports' => array(
//             'title',
//             'editor',
//             'excerpt',
//             'thumbnail'
//         ), // Go to Dashboard Custom HTML5 Blank post for supports
//         'can_export' => true, // Allows export in Tools > Export
//         'taxonomies' => array(
//             'post_tag',
//             'category'
//         ) // Add Category and Post Tags support
//     ));
// }




/*------------------------------------*\
	ShortCode Functions for Login
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function log_in_out($atts, $content = null) {

    if (is_user_logged_in()) {
      echo  " <a href='" .wp_logout_url(get_permalink())."'>Logout</a> ";
    }
    else {
         echo  " <a href='" .wp_logout_url(get_permalink())."'>Login</a> ";
     }
  

}

// Shortcode Demo with simple <h2> tag
function login_form($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{


$args = array(
    'echo'           => true,
    'remember'       => true,
    'redirect'       => site_url( '/members/' ),
    'form_id'        => 'loginform',
    'id_username'    => 'user_login',
    'id_password'    => 'user_pass',
    'id_remember'    => 'rememberme',
    'id_submit'      => 'wp-submit',
    'label_username' => __( 'Username' ),
    'label_password' => __( 'Password' ),
    'label_remember' => __( 'Remember Me' ),
    'label_log_in'   => __( 'Sign In' ),
    'value_username' => '',
    'value_remember' => false
);



wp_login_form( $args );

echo "<a href='"; echo wp_lostpassword_url(); echo "' class='lostPassword' title='Forgot Password'>Forgot Password?</a>";

}






/*------------------------------------*\
    Color Customizer
\*------------------------------------*/


function colourBrightness($hex, $percent) {
	// Work out if hash given
	$hash = '';
	if (stristr($hex,'#')) {
		$hex = str_replace('#','',$hex);
		$hash = '#';
	}
	/// HEX TO RGB
	$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
	//// CALCULATE 
	
	for ($i=0; $i<3; $i++) {
		// See if brighter or darker
		if ($percent > 0) {
			// Lighter
			$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
			
		} else {
			// Darker
			$positivePercent = $percent - ($percent*2);
			$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
		}
		// In case rounding up causes us to go to 256
		if ($rgb[$i] > 255) {
			$rgb[$i] = 255;
		}
	}
	
	//// RBG to Hex
	$hex = '';
	for($i=0; $i < 3; $i++) {
		// Convert the decimal digit to hex
		$hexDigit = dechex($rgb[$i]);
		// Add a leading zero if necessary
		if(strlen($hexDigit) == 1) {
		$hexDigit = "0" . $hexDigit;
		}
		// Append to the hex string
		$hex .= $hexDigit;
	}
	
	return $hash.$hex;
}
class WPSE_78121_Sublevel_Walker extends Walker_Nav_Menu
{
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class='sub-toggle'></div><div class='sub-menu-wrap'><ul class='sub-menu'>\n";
    }
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }
}
class MyTheme_Customize {
   /**
    * This hooks into 'customize_register' (available as of WP 3.4) and allows
    * you to add new sections and controls to the Theme Customize screen.
    * 
    * Note: To enable instant preview, we have to actually write a bit of custom
    * javascript. See live_preview() for more.
    *  
    * @see add_action('customize_register',$func)
    * @param \WP_Customize_Manager $wp_customize
    * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
    * @since MyTheme 1.0
    */
   public static function register ( $wp_customize ) {
		$theme_name = get_current_theme();
		
      //1. Define a new section (if desired) to the Theme Customizer
	  $wp_customize->add_section( 'themeslug_logo_section' , array(
			'title'       => __( 'Logo', $theme_name ),
			'priority'    => 30,
			'description' => 'Upload a logo to replace the default site name and description in the header',
		) );
		$wp_customize->add_section( 'primary_color_section' , array(
			'title'       => __( 'Primary Theme color', $theme_name ),
			'priority'    => 31,
			'description' => 'Replace theme default primary color',
		) );
		$wp_customize->add_section( 'secondary_color_section' , array(
			'title'       => __( 'Secondary Theme color', $theme_name ),
			'priority'    => 32,
			'description' => 'Replace theme default secondary color',
		) );
		$wp_customize->add_section( 'tertiary_color_section' , array(
			'title'       => __( 'Tertiary Theme color', $theme_name ),
			'priority'    => 33,
			'description' => 'Replace theme default tertiary color',
		) );
		
      


      //2. Register new settings to the WP database...	 
	$wp_customize->add_setting( 'themeslug_logo' );

	$wp_customize->add_setting( 'primary_color' );
	$wp_customize->add_setting( 'secondary_color' );
	$wp_customize->add_setting( 'tertiary_color',
	  array(
            'default' => '#ccc', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
         ) );
	$wp_customize->add_setting( 'primary_color',
	  array(
            'default' => '#c7a133', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
         ) );
		   $wp_customize->add_setting( 'secondary_color',
	  array(
            'default' => '#628b85', //Default setting/value to save
            'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
            'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
           
         ) );
	$wp_customize->add_setting( 'tertiary_color', //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
			array(
				'default' => '#a1b1bc', //Default setting/value to save
				'type' => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
			) 
		);
			
      //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
	  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_logo', array(
			'label'    => __( 'Logo', $theme_name ),
			'section'  => 'themeslug_logo_section',
			'settings' => 'themeslug_logo',
		) ) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
			'label'    => __( 'Primary color', $theme_name ),
			'section'  => 'colors',
			'settings' => 'primary_color',
			'priority' => 10,
		) ) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
			'label'    => __( 'Secondary color', $theme_name ),
			'section'  => 'colors',
			'settings' => 'secondary_color',
			'priority' => 10,
		) ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tertiary_color', array(
			'label'    => __( 'Tertiary color', $theme_name ),
			'section'  => 'colors',
			'settings' => 'tertiary_color',
			'priority' => 10,
		) ) );
		
			


      
      //4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
      $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
   		//css_to_var('primary_color');
    
   }

   /**
    * This will output the custom WordPress settings to the live theme's WP head.
    * 
    * Used by hook: 'wp_head'
    * 
    * @see add_action('wp_head',$func)
    * @since MyTheme 1.0
    */
   public static function header_output() {
      ?>
      <!--Customizer CSS--> 
      <style type="text/css">
           <?php self::generate_css($gold, 'color', 'primary_color'); ?> 
		   <?php self::generate_css($green, 'color', 'secondary_color'); ?> 
		   <?php self::generate_css($grey, 'color', 'tertiary_color'); ?> 
      </style> 
      <!--/Customizer CSS-->
      <?php
   }
   
   /**
    * This outputs the javascript needed to automate the live settings preview.
    * Also keep in mind that this function isn't necessary unless your settings 
    * are using 'transport'=>'postMessage' instead of the default 'transport'
    * => 'refresh'
    * 
    * Used by hook: 'customize_preview_init'
    * 
    * @see add_action('customize_preview_init',$func)
    * @since MyTheme 1.0
    */
   public static function live_preview() {
      wp_enqueue_script( 
           'mytheme-themecustomizer', // Give the script a unique ID
           get_template_directory_uri() . '/js/theme-customizer.js', // Define the path to the JS file
           array(  'jquery', 'customize-preview' ), // Define dependencies
           '', // Define a version (optional) 
           true // Specify whether to put in footer (leave this true)
      );
   }

    /**
     * This will generate a line of CSS for use in header output. If the setting
     * ($mod_name) has no defined value, the CSS will not be output.
     * 
     * @uses get_theme_mod()
     * @param string $selector CSS selector
     * @param string $style The name of the CSS *property* to modify
     * @param string $mod_name The name of the 'theme_mod' option to fetch
     * @param string $prefix Optional. Anything that needs to be output before the CSS property
     * @param string $postfix Optional. Anything that needs to be output after the CSS property
     * @param bool $echo Optional. Whether to print directly to the page (default: true).
     * @return string Returns a single line of CSS with selectors and a property.
     * @since MyTheme 1.0
     */
    public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( ! empty( $mod ) ) {
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return;
         }
      }
      return $return;
    }
	
}




add_action('wp_head', 'rand654_add_css');
function rand654_add_css() {
    if ( ! is_singular() ) {
        $id = get_the_ID(); // here you should change id to ID, of your post/page in loop
        if ( $id ) {
            $shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
            if ( ! empty( $shortcodes_custom_css ) ) {
                echo '<style type="text/css" data-type="vc_shortcodes-custom-css-'.$id.'">';
                echo $shortcodes_custom_css;
                echo '</style>';
            }
        }
    }
} 

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'MyTheme_Customize' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'MyTheme_Customize' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'MyTheme_Customize' , 'live_preview' ) );

function remove_wp_version() {
     return '';
}
 
add_filter('the_generator', 'remove_wp_version');
define('DISALLOW_FILE_EDIT', true);
function failed_login() {
     return 'The login information you have entered is incorrect.';
}
 
add_filter('login_errors', 'failed_login');
function css_to_var($modArr){
		global $mod;
		foreach($modArr as $mods){
			$modCol = get_theme_mod($mods);
			$mod[] = $modCol;
		}
		//$mod = get_theme_mod($mod_name);
		//echo 'the_mod'.$mod;
		return $mod;	
}



add_action("login_head", "my_login_head");
function my_login_head() {
	if(get_theme_mod('themeslug_logo')!=''){
	$logo = get_theme_mod('themeslug_logo');
	echo "
	<style>
	body.login #login h1 a {
		background: url('$logo') no-repeat scroll center top transparent;
		height: 90px;
		width:100%;
		background-size:contain;
	}
	
	</style>
	";
	}
}




/*------------------------------------*\
    Tiny MCE Adjustments
\*------------------------------------*/

function my_mce_before_init_insert_formats( $init_array ) {  
   // Define the style_formats array
$style_formats = array(  
       // Each array child is a format with it's own settings
       array(  
           'title' => 'Button',  
           'selector' => 'a',
           'classes' => 'btn waves-effect waves-light',
       ),
       array(  
           'title' => 'Arrow Link',  
           'selector' => 'a',
           'classes' => 'arw',
       ),
       array(  
           'title' => 'Lead Text',  
           'selector' => 'p',
           'classes' => 'lead',
       )
       
   );  
   // Insert the array, JSON ENCODED, into 'style_formats'
   $init_array['style_formats'] = json_encode( $style_formats );  
   
   return $init_array;  

}
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );


function my_mce_buttons_2( $buttons ) {
   array_unshift( $buttons, 'styleselect' );
   return $buttons;
}
// Register our callback to the appropriate filter
add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );







/*------------------------------------*\
    vpm_default_hidden_meta_boxes
\*------------------------------------*/


function vpm_default_hidden_meta_boxes( $hidden, $screen ) {
    // Grab the current post type
    $post_type = $screen->post_type;
    // If we're on a 'post'...
    if ( $post_type == 'post' ) {
        // Define which meta boxes we wish to hide
        $hidden = array(
            'authordiv',
            'revisionsdiv',
            'martygeocoder',
        );
        // Pass our new defaults onto WordPress
        return $hidden;
    }
    // If we are not on a 'post', pass the
    // original defaults, as defined by WordPress
    return $hidden;
}
add_action( 'default_hidden_meta_boxes', 'vpm_default_hidden_meta_boxes', 10, 2 );



/*------------------------------------*\
    Facebook OpenGraph Tags
\*------------------------------------*/

function fb_opengraph() {
    global $post;
 
    // if(is_single()) {
        if(has_post_thumbnail($post->ID)) {
            $img_src = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'medium');
        } else {
            $img_src = get_stylesheet_directory_uri() . '/img/opengraph_image.jpg';
        }
        if($excerpt = $post->post_excerpt) {
            $excerpt = strip_tags($post->post_excerpt);
            $excerpt = str_replace("", "'", $excerpt);
        } else {
            $excerpt = get_bloginfo('description');
        }
        ?>
 
    <meta property="og:title" content="<?php echo the_title(); ?>"/>
    <meta property="og:description" content="<?php echo $excerpt; ?>"/>
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="<?php echo the_permalink(); ?>"/>
    <meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
    <meta property="og:image" content="<?php echo $img_src; ?>"/>
 
<?php
    // } else {
    //     return;
    // }
}
add_action('wp_head', 'fb_opengraph', 5);





/*------------------------------------*\
    BREADCRUMBs
\*------------------------------------*/

 function the_breadcrumb() {
    global $post;
    echo '<ul id="breadcrumbs">';
    if (!is_home()) {
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
        echo 'Home';
        echo '</a></li><li class="separator"> / </li>';
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li><li class="separator"> / </li><li> ');
            if (is_single()) {
                echo '</li><li class="separator"> / </li><li>';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<li><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li> <li class="separator">/</li>';
                }
                echo $output;
                echo '<strong title="'.$title.'"> '.$title.'</strong>';
            } else {
                echo '<li><strong> '.get_the_title().'</strong></li>';
            }
        }
    }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
    elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
    elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
    elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
    elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
    echo '</ul>';
}





// Create Settings List

function theme_settings_page()
{
    ?>
        <div class="wrap">
        <h1>Theme Panel</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields("section");
                do_settings_sections("theme-options");      
                submit_button(); 
            ?>          
        </form>
        </div>
    <?php
}



function display_twitter_element(){?>
        <input type="text" name="twitter_url" id="twitter_url" value="<?php echo get_option('twitter_url'); ?>" />
<?php
}
function display_facebook_element()
{
    ?>
        <input type="text" name="facebook_url" id="facebook_url" value="<?php echo get_option('facebook_url'); ?>" />
    <?php
}
function display_instagram_element()
{
    ?>
        <input type="text" name="instagram_url" id="instagram_url" value="<?php echo get_option('instagram_url'); ?>" />
    <?php
}
function display_google_element()
{
    ?>
        <input type="text" name="google_url" id="google_url" value="<?php echo get_option('google_url'); ?>" />
    <?php
}
function display_linkedin_element()
{
    ?>
        <input type="text" name="linkedin_url" id="linkedin_url" value="<?php echo get_option('linkedin_url'); ?>" />
    <?php
}
function display_youtube_element()
{
    ?>
        <input type="text" name="youtube_url" id="youtube_url" value="<?php echo get_option('youtube_url'); ?>" />
    <?php
}


function display_theme_panel_fields()
{
    add_settings_section("section", "All Settings", null, "theme-options");
    add_settings_field("twitter_url", "Twitter Profile Url", "display_twitter_element", "theme-options", "section");
    add_settings_field("facebook_url", "Facebook Profile Url", "display_facebook_element", "theme-options", "section");
    add_settings_field("instagram_url", "Instagram Profile Url", "display_instagram_element", "theme-options", "section");
    add_settings_field("google_url", "Google Profile Url", "display_google_element", "theme-options", "section");
    add_settings_field("linkedin_url", "Linkedin Profile Url", "display_linkedin_element", "theme-options", "section");
    add_settings_field("youtube_url", "Youtube Profile Url", "display_youtube_element", "theme-options", "section");
    register_setting("section", "twitter_url");
    register_setting("section", "facebook_url");
    register_setting("section", "instagram_url");
    register_setting("section", "google_url");
    register_setting("section", "linkedin_url");
    register_setting("section", "youtube_url");
}
add_action("admin_init", "display_theme_panel_fields");



// Create Settings Menu Item
function add_theme_menu_item()
{
    add_menu_page("Social Settings", "Social Settings", "manage_options", "Social Settings", "theme_settings_page", null, 99);
}

add_action("admin_menu", "add_theme_menu_item");
function social_func( $atts ) {
        $facebook_url = get_option('facebook_url', false);
        $twitter_url = get_option('twitter_url', false);
        $linkedin_url = get_option('linkedin_url', false);
        $instagram_url = get_option('instagram_url', false);
        $youtube_url = get_option('youtube_url', false);
        $google_url = get_option('google_url', false);
        $facebookLink = "";
        $twitterLink = "";
        $linkedinLink = "";
        $intagramLink = "";
        $youtubeLink = "";
        $googleLink = "";

        if($facebook_url != ''){ $facebookLink = "<a href='$facebook_url'><span class='icon ion-social-facebook'></span></a> ";}
        if($twitter_url != ''){ $twitterLink = "<a href='$twitter_url'><span class='icon ion-social-twitter'></span></a> ";}
        if($linkedin_url != ''){ $linkedinLink = "<a href='$linkedin_url'><span class='icon ion-social-linkedin'></span></a> ";}
        if($instagram_url != ''){ $intagramLink = "<a href='$instagram_url'><span class='icon ion-social-instagram'></span></a> ";}
        if($youtube_url != ''){ $youtubeLink = "<a href='$youtube_url'><span class='icon ion-social-youtube'></span></a> ";}
        if($google_url != ''){  $googleLink = "<a href='$google_url'><span class='icon ion-social-googleplus'></span></a>";}

        return "<div class='socialIcons'>$facebookLink $twitterLink $linkedinLink $intagramLink $youtubeLink $googleLink</div>";
    
}

add_shortcode( 'social', 'social_func' );



function remove_menus(){
  
  remove_menu_page( 'edit-comments.php' );          //Comments
  
}
add_action( 'admin_menu', 'remove_menus' );
?>

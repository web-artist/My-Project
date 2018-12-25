<?php
include(get_template_directory() . '/constants.php');
include(get_template_directory() . '/classes.php');
include(get_template_directory() . '/media-importer.php');
include(get_template_directory() . '/functions-woo.php');

add_action('themecheck_checks_loaded', 'theme_disable_cheks');
function theme_disable_cheks()
{
    $disabled_checks = array('TagCheck');
    global $themechecks;
    foreach ($themechecks as $key => $check) {
        if (is_object($check) && in_array(get_class($check), $disabled_checks)) {
            unset($themechecks[$key]);
        }
    }
}

add_theme_support('automatic-feed-links');

if (!isset($content_width)) $content_width = 900;

remove_action('wp_head', 'wp_generator');

add_action('after_setup_theme', 'theme_localization');
function theme_localization()
{
    load_theme_textdomain('alor', get_template_directory() . '/languages');

}

add_action('widgets_init', 'awesome_register_sidebars');
function awesome_register_sidebars()
{
    register_sidebar(array(
        'name' => 'Cart area',
        'id' => 'cart-area',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="offscreen hide">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'id' => 'default-sidebar',
        'name' => __('Default Sidebar', 'alor'),
        'before_widget' => '<div class="widget %2$s" id="%1$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    register_sidebar(array(
        'id' => 'footer-sidebar',
        'name' => __('Footer Sidebar', 'alor'),
        'before_widget' => '<div class="widget %2$s " id="%1$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'id' => 'layer_sidebar',
        'name' => __('Layer Sidebar', 'alor'),
        'before_widget' => '<div class="widget %2$s" id="%1$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="arrowactive">',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'id' => 'custom_sidebar',
        'name' => __('Sidebar for Custom Tag', 'alor'),
        'before_widget' => '<div class="widget %2$s" id="%1$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="arrowactive">',
        'after_title' => '</h3>'
    ));
    register_sidebar(array(
        'id' => 'newsletter_sidebar',
        'name' => __('News letter Sidebar', 'alor'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    register_sidebar(array(
        'id' => 'popupnewsletter_sidebar',
        'name' => __('Popup letter Sidebar', 'alor'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    register_sidebar(array(
        'id' => 'emailsubscriber_sidebar',
        'name' => __('Email Subscriber Sidebar', 'alor'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(50, 50, true); // Normal post thumbnails
    add_image_size('brand_header_gallery', 276, 250, true);
    add_image_size('press_gallery_small', 263, 99999, false);
    add_image_size('camp_header_image', 325, 345, true);
    add_image_size('camp_footer_image', 912, 1209, true);
    add_image_size('home_gallery_image', 1800, 1000, true);
    add_image_size('shop_related_product', 158, 158, true);

    // Blog Featured Responsive
    add_image_size('blog_featured_responsive_640', 610, 320, true);
    add_image_size('blog_featured_responsive_768', 740, 320, true);
}

register_nav_menus(array(
    'header_location' => __('Header Location', 'alor'),
    'footer_location' => __('Footer Location', 'alor'),
    'left_location' => __('Left Location', 'alor'),
    'header_main' => __('Header Main Menu', 'alor'),
));


//add [email]...[/email] shortcode
function shortcode_email($atts, $content)
{
    $result = '';
    for ($i = 0; $i < strlen($content); $i++) {
        $result .= '&#' . ord($content{$i}) . ';';
    }
    return $result;
}

add_shortcode('email', 'shortcode_email');

// register tag [template-url]
function filter_template_url($text)
{
    return str_replace('[template-url]', get_bloginfo('template_url'), $text);
}

add_filter('the_content', 'filter_template_url');
add_filter('get_the_content', 'filter_template_url');
add_filter('widget_text', 'filter_template_url');

// register tag [site-url]
function filter_site_url($text)
{
    return str_replace('[site-url]', get_bloginfo('url'), $text);
}

add_filter('the_content', 'filter_site_url');
add_filter('get_the_content', 'filter_site_url');
add_filter('widget_text', 'filter_site_url');


/* Replace Standard WP Menu Classes */
function change_menu_classes($css_classes)
{
    $css_classes = str_replace("current-menu-item", "active", $css_classes);
    $css_classes = str_replace("current-menu-parent", "active", $css_classes);
    return $css_classes;
}

add_filter('nav_menu_css_class', 'change_menu_classes');

/* Replace Standard WP Body Classes and Post Classes */
function theme_body_class($classes)
{
    if (is_array($classes)) {
        foreach ($classes as $key => $class) {
            $classes[$key] = 'body-class-' . $classes[$key];
        }
    }

    return $classes;
}

add_filter('body_class', 'theme_body_class', 9999);

function theme_post_class($classes)
{
    if (is_array($classes)) {
        foreach ($classes as $key => $class) {
            $classes[$key] = 'post-class-' . $classes[$key];
        }
    }

    return $classes;
}

add_filter('post_class', 'theme_post_class', 9999);

//allow tags in category description
$filters = array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description');
foreach ($filters as $filter) {
    remove_filter($filter, 'wp_filter_kses');
}


//Make WP Admin Menu HTML Valid
function wp_admin_bar_valid_search_menu($wp_admin_bar)
{
    if (is_admin())
        return;

    $form = '<form action="' . esc_url(home_url('/')) . '" method="get" id="adminbarsearch"><div>';
    $form .= '<input class="adminbar-input" name="s" id="adminbar-search" tabindex="10" type="text" value="" maxlength="150" />';
    $form .= '<input type="submit" class="adminbar-button" value="' . __('Search', 'alor') . '"/>';
    $form .= '</div></form>';

    $wp_admin_bar->add_menu(array(
        'parent' => 'top-secondary',
        'id' => 'search',
        'title' => $form,
        'meta' => array(
            'class' => 'admin-bar-search',
            'tabindex' => -1,
        )
    ));
}

function fix_admin_menu_search()
{
    remove_action('admin_bar_menu', 'wp_admin_bar_search_menu', 4);
    add_action('admin_bar_menu', 'wp_admin_bar_valid_search_menu', 4);
}

add_action('add_admin_bar_menus', 'fix_admin_menu_search');

add_filter('wpcf7_form_class_attr', 'custom_form_class_attr');
/* load more post */function more_post_ajax(){$cat= 2358;	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	    $offset = $_POST["offset"];    $ppp = $_POST["ppp"];    header("Content-Type: text/html");		$args = array(    'post_type'             => 'product',    'post_status'           => 'publish',    'ignore_sticky_posts'   => 1,    'posts_per_page'        => $ppp,	'offset'                => $offset,	'paged'                 => $paged,	'meta_query'            => array(        array(            'key'           => '_visibility',            'value'         => array('catalog', 'visible'),            'compare'       => 'IN'        )    ),	'tax_query'             => array(        array(            'taxonomy'      => 'product_cat',            'field' => 'term_id',             'terms'         => $cat,            'operator'      => 'IN'         )    )	);	 $loop = new WP_Query( $args ); 		if($loop->have_posts()){	while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>      <li class="cus_col-sm-3 cat-item1 myproducts">                        <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">                        <?php woocommerce_show_product_sale_flash( $post, $product ); ?>                        <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>                        <h3><?php the_title(); ?></h3>                        <span class="price"><?php echo $product->get_price_html(); ?></span>                                        </a>                    <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>	</li>    <?php endwhile; ?>    <?php wp_reset_query();}else{	echo '<div class="col-md-12 no-more-posts"> No More Products Available. </div>';}		}	add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax'); add_action('wp_ajax_more_post_ajax', 'more_post_ajax');/* ****END*****  */


/* load more post ajax*/
function lazy_load_ajax(){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
    $offset = $_POST["offset"];  
	$ppp = $_POST["ppp"]; 
	$cat_id= $_POST["cat_id"];
	$cat_slug= $_POST["cat_slug"];
	header("Content-Type: text/html");	
	$args = array( 
	'post_type'             => 'product',
    'post_status'           => 'publish',
	'ignore_sticky_posts'   => 1,  
	'posts_per_page'        => $ppp,
	'offset'                => $offset,
	'paged'                 => $paged,	
	'meta_query'            => array(       
	array( 'key'           => '_visibility',
	'value'         => array('catalog', 'visible'), 
	'compare'       => 'IN'        
	)    
	),
	'tax_query'             => array( 
	array(    
	'taxonomy'      => 'product_cat',  
	'field' => 'term_id', 
	'terms'         => $cat_id,  
	'operator'      => 'IN'   
	)  
	)	
	);
	$pid = $product->id;
	$price = $product->price;
	$desc = get_post_meta($pid, 'description', true);
	$loop = new WP_Query( $args ); 		if($loop->have_posts()){ 
	while ( $loop->have_posts() ) : $loop->the_post(); 
	global $product; ?>  





<li class="cus_col-sm-3 cat-item1  myproducts" data-href="<?php the_permalink(); ?>">

    <?php if ($flag_first_item == 1) { ?>
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('shop_catalog'); ?></a>

        <div class="caption"><a href="<?php the_permalink(); ?>" style="display:block;"> &nbsp; </a>
            <p class="qik_view"><a href="#quick_view_content<?php echo $pid; ?>"
                                   class="qik_view_btn various"><?php echo __('QuickView', 'cpt'); ?></a></p>
            <p class="title"><a href="<?php the_permalink(); ?>" style="text-decoration:none;"><?php the_title(); ?></a>
            </p>
            <p class="prce">
                <?php echo $product->get_price_html(); ?>
            </p>
            <p class="desc">
                <a href="<?php the_permalink(); ?>" style="text-decoration:none;">
                    <?php echo substr($desc, 0, 140); ?>...
                </a>
            </p>
            <div class="bottom">
                <div class="wishlist_cls">
                    <?php
                    $add_to_wishlist = do_shortcode('[yith_wcwl_add_to_wishlist]');
                    echo $add_to_wishlist;
                    ?>

                </div>
                <div class="add">


                    <span><?php woocommerce_template_loop_add_to_cart($post, $product); ?></span>


                </div>
            </div>

        </div>
        <div class="hide-cls">
            <div id="quick_view_content<?php echo $pid; ?>"
                 class="quick_view_cls"> <?php do_action('woocommerce_single_product_summary'); ?></div>
        </div>
    <?php } else { ?>
        <?php the_post_thumbnail('shop_thumbnail'); ?>

        <div class="caption"><a href="<?php the_permalink(); ?>" style="display:block;"> &nbsp; </a>
            <p class="qik_view"><a href="#quick_view_content<?php echo $pid; ?>"
                                   class="qik_view_btn various"><?php echo __('QuickView', 'cpt'); ?></a></p>
            <p class="title"><a href="<?php the_permalink(); ?>" style="text-decoration:none;"><?php the_title(); ?></a>
            </p>
            <p class="prce">
                <?php echo $product->get_price_html(); ?>
            </p>
            <p class="desc">
                <a href="<?php the_permalink(); ?>" style="text-decoration:none;">
                    <?php echo substr($desc, 0, 140); ?>...
                </a>
            </p>
            <div class="bottom">
                <div class="wishlist_cls">
                    <?php
                    $add_to_wishlist = do_shortcode('[yith_wcwl_add_to_wishlist]');
                    echo $add_to_wishlist;
                    ?>
                </div>
                <div class="add">
                    <span><?php woocommerce_template_loop_add_to_cart($post, $product); ?></span>
                </div>
            </div>

        </div>
        <div class="hide-cls">
            <div id="quick_view_content<?php echo $pid; ?>"
                 class="quick_view_cls"><?php do_action('woocommerce_single_product_summary'); ?></div>
        </div>
    <?php } ?>

</li>
	<?php endwhile; ?>    <?php wp_reset_query();}
	}
add_action('wp_ajax_nopriv_lazy_load_ajax', 'lazy_load_ajax');
add_action('wp_ajax_lazy_load_ajax', 'lazy_load_ajax');
	/* ****END*****  */

/* infinite scroll */
function mytheme_infinite_scroll_init() {
add_theme_support( 'infinite-scroll', array(
'container' => 'content',
'render' => 'mytheme_infinite_scroll_render',
'footer' => 'wrapper',
) );
}
add_action( 'init', 'mytheme_infinite_scroll_init' );

function mytheme_infinite_scroll_render() {
get_template_part( 'loop' );
}

/* ***END*** */


function custom_form_class_attr($class)
{
    $class .= ' contact-form';
    return $class;
}

add_theme_support('woocommerce');

function breadcrumb_header()
{
  echo '<div class="breadcrumb">';
  echo '<div class="breadcrumbs" typeof="v:Breadcrumb">';

  if (function_exists('menu_breadcrumb')) {

      $menu_breadcrumb = new Custom_Menu_Breadcrumb('header_location');   // 'main' is the Menu Location
      $breadcrumb_array = $menu_breadcrumb->generate_trail();
      $breadcrumb_markup = $menu_breadcrumb->generate_markup($breadcrumb_array, ' /	');
      echo '<p class="menu-breadcrumb">';
      if ($breadcrumb_markup) {
          echo "<span><a href='" . get_site_url() . "'>" . __('Home', 'cpt') . "</a></span>  <span class=\"sep\"> / </span>" . $breadcrumb_markup;
      } else {
                woocommerce_breadcrumb();
      }
      echo '</p>';
  }
  echo '</div></div>';
}

add_filter('sod_ajax_layered_nav_containers', 'aln_add_custom_container');
function aln_add_custom_container($containers)
{
    $containers[] = '.custom';
    return $containers;
}

function wp_get_attachment_image_custom($attachment_id, $size = 'thumbnail', $icon = false, $attr = '')
{

    $html = '';
    $image = wp_get_attachment_image_src($attachment_id, $size, $icon);
    if ($image) {
        list($src, $width, $height) = $image;
        if (is_array($size))
            $size = join('x', $size);
        $attachment = get_post($attachment_id);
        $default_attr = array(
            'src' => $src,
            'class' => "attachment-$size",
            'alt' => trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true))), // Use Alt field first
        );
        if (empty($default_attr['alt']))
            $default_attr['alt'] = trim(strip_tags($attachment->post_excerpt)); // If not, Use the Caption
        if (empty($default_attr['alt']))
            $default_attr['alt'] = trim(strip_tags($attachment->post_title)); // Finally, use the title

        $attr = wp_parse_args($attr, $default_attr);
        $attr = apply_filters('wp_get_attachment_image_attributes', $attr, $attachment);
        $attr = array_map('esc_attr', $attr);
        $html = rtrim("<img ");
        foreach ($attr as $name => $value) {
            $html .= " $name=" . '"' . $value . '"';
        }
        $html .= ' />';
    }

    return $html;
}

if (isset($_GET['view'])) {
    add_filter('loop_shop_per_page', create_function('$cols', 'return -1;'));
} else {
    if (get_option('old_page')) {
        $paged = get_option('old_page');
        update_option('old_page', false);
        wp_redirect(add_query_arg(array('paged' => $paged)));
    }
    add_filter('loop_shop_per_page', create_function('$cols', 'return get_option( \'posts_per_page\' );'));
}


function custom_script_alor()
{
    wp_enqueue_script('custom-scroll', get_template_directory_uri() . '/js/jquery.mCustomScrollbar.concat.min.js');
    wp_enqueue_script('custom-slider', get_template_directory_uri() . '/js/jquery.flexslider-min.js');

    wp_enqueue_style('custom-scroll-css', get_template_directory_uri() . '/jquery.mCustomScrollbar.css');
    wp_enqueue_style('custom-slider-css', get_template_directory_uri() . '/flexslider.css');
}

add_action('wp_enqueue_scripts', 'custom_script_alor', 100);

function show_all_posts_from_media_type($query)
{
    if ($query->is_tax('media-type')):
        $query->set('posts_per_page', 999);
        return;
    endif;
}
add_action('pre_get_posts', 'show_all_posts_from_media_type');

/******* Collection Left Menu *************/
function my_get_menu_item_name($loc)
{
    global $wp;
    $arr = array();

    $cur_url = home_url(add_query_arg(array(), $wp->request));
    $locs = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object($locs[$loc]);

    if ($menu) {

        $items = wp_get_nav_menu_items($menu->term_id);


        foreach ($items as $k => $v) {
            // Check if this menu item links to the current page
            $path_info = pathinfo($items[$k]->url);
            if (strstr(trailingslashit($cur_url), $path_info['basename'])) {
                $arr['current_parent_menu'] = $items[$k]->menu_item_parent;

                $arr['current_menu'] = $items[$k]->ID;
                $arr['term_id'] = $menu->term_id;

                break;
            }
        }
    }
    if (count($arr) > 0)
        return $arr;
    else
        return false;
}

add_action('wp_head', 'include_header_layout_css');

$site_settings_arr = array();
function include_header_layout_css()
{
    global $post, $site_settings_arr;


    if (is_archive()) {
        $term = get_queried_object();
        //edit: useless? get_field('show_banner',$term->taxonomy . '_' . $term->term_id);

        if (function_exists('get_field') and get_field('show_banner', $term->taxonomy . '_' . $term->term_id)):
            $site_settings_arr['is_show_banner'] = get_field('show_banner', $term->taxonomy . '_' . $term->term_id);
        endif;

        if (function_exists('get_field') and get_field('display_caption', $term->taxonomy . '_' . $term->term_id)) {
            $site_settings_arr['is_display_caption'] = get_field('display_caption', $term->taxonomy . '_' . $term->term_id);
        }
        if (function_exists('get_field') and
            (empty(get_field('display_caption_position', $term->taxonomy . '_' . $term->term_id))
                or get_field('display_caption_position', $term->taxonomy . '_' . $term->term_id) == 'l')
        ) {
            $display_caption_position_cls = ' caption-left';
        } else {
            $display_caption_position_cls = ' caption-right';
        }

        $display_caption_custom_style = '';
        if (function_exists('get_field') and !empty(get_field('modified_caption_css', $term->taxonomy . '_' . $term->term_id))) {
            $display_caption_custom_style = "style='" . get_field('modified_caption_css', $term->taxonomy . '_' . $term->term_id) . "' ";
        }

        $is_show_mobile_banner = '';
        if (function_exists('get_field')) {
            $is_show_mobile_banner = get_field('is_show_mobile_banner', $term->taxonomy . '_' . $term->term_id);
        }
        $site_settings_arr['show_in_mobile'] = ($is_show_mobile_banner != 'y' ? 'hide-mobile-banner' : '');

        $site_settings_arr['cat_desc'] = '<div class="heading-catalog ' . $display_caption_position_cls . '" ' . $display_caption_custom_style . '><h2>' . single_cat_title("", false) . '</h2>
              ' . category_description() . '</div>';


    } else {


        if (function_exists('get_field') and get_field('show_banner', $post->ID)):
            $site_settings_arr['is_show_banner'] = get_field('show_banner', $post->ID);
        endif;

        if (function_exists('get_field') and get_field('display_caption', $post->ID)):
            $site_settings_arr['is_display_caption'] = get_field('display_caption', $post->ID);
        endif;

        $is_show_mobile_banner = '';

        if (function_exists('get_field') and get_field('is_show_mobile_banner', $post->ID)):
            $is_show_mobile_banner = get_field('is_show_mobile_banner', $post->ID);
        endif;

        $site_settings_arr['show_in_mobile'] = ($is_show_mobile_banner != 'y' ? 'hide-mobile-banner' : '');

    }


    if (function_exists('get_field') and get_field('header_layout', $post->ID)): ?>
        <link rel="stylesheet"
              href="<?php echo get_template_directory_uri(); ?>/header_<?php echo strtolower(get_field('header_layout', $post->ID)); ?>.css"
              type="text/css" media="all">
        <?php $site_settings_arr['layout'] = get_field('header_layout', $post->ID); ?>
    <?php elseif (is_archive()):

        ?>
        <link rel="stylesheet"
              href="<?php echo get_template_directory_uri(); ?>/header_<?php echo strtolower(get_field('header_layout', $term->taxonomy . '_' . $term->term_id)); ?>.css"
              type="text/css" media="all">
        <?php $site_settings_arr['layout'] = get_field('header_layout', $term->taxonomy . '_' . $term->term_id); ?>
    <?php elseif (function_exists('get_field') and get_field('default_header_layout', 'option')): ?>
        <link rel="stylesheet"
              href="<?php echo get_template_directory_uri(); ?>/header_<?php echo strtolower(get_field('default_header_layout', 'option')); ?>.css"
              type="text/css" media="all">
        <?php $site_settings_arr['layout'] = get_field('default_header_layout', 'option'); ?>
    <?php endif;


}

if (class_exists('Menu_Breadcrumb')) {
    class Custom_Menu_Breadcrumb extends Menu_Breadcrumb
    {

        private $assign_cururl;

        public function __construct($menu_location = '')
        {
            parent::__construct($menu_location);
        }

        public function setCustomUrl($url)
        {
            $this->assign_cururl = $url;
        }

        public function is_at_url($url = '')
        {
            global $wp;
            if (empty($url)) {
                return false;
            }


            if (!empty($this->assign_cururl)) {
                $current_url = $this->assign_cururl;
            } else {
                $current_url = home_url(add_query_arg(array(), $wp->request));
            }


            return trailingslashit($current_url) == $url;
        }

        public function get_current_menu_item_object()
        {
            $current_menu_item = false;
            if (empty($this->menu_items)) {
                return $current_menu_item;
            }
            // loop through the entire nav menu and determine whether any have a class="current" or are the current URL (e.g. a Custom Link was used)
            foreach ($this->menu_items as $menu_item) {
                // if WordPress was able to detect the current page
                if (is_array($menu_item->classes) && in_array('current', $menu_item->classes)) {
                    $current_menu_item = $menu_item;
                }
                // if the current URL matches a Custom Link

                if (!$current_menu_item && isset($menu_item->url) && $this->is_at_url($menu_item->url)) {
                    $current_menu_item = $menu_item;
                }
                if ($current_menu_item) {
                    break;
                }
            }

            return $current_menu_item;
        }

        public function generate_trail()
        {
            $current_menu_item = $this->get_current_menu_item_object();
            if (empty($current_menu_item)) {
                return '';
            }
            // there's at least one level
            $breadcrumb = array($current_menu_item);
            // work backwards from the current menu item all the way to the top
            while ($current_menu_item = $this->get_parent_menu_item_object($current_menu_item)) {
                $breadcrumb[] = $current_menu_item;
            }
            // since we worked backwards, we need to reverse everything
            $breadcrumb = array_reverse($breadcrumb);
            // add a level for each breadcrumb object
            $i = 1;
            foreach ($breadcrumb as $key => $val) {
                if (!isset($val->menu_breadcrumb_level)) {
                    $val->menu_breadcrumb_level = $i;
                    $breadcrumb[$key] = $val;
                }
                $i++;
            }
            return $breadcrumb;
        }


        public function get_parent_menu_item_object($current_menu_item)
        {
            $parent_menu_item = false;
            if (empty($this->menu_items)) {
                return $current_menu_item;
            }
            foreach ($this->menu_items as $menu_item) {
                if (absint($current_menu_item->menu_item_parent) == absint($menu_item->ID)) {
                    $parent_menu_item = $menu_item;
                    break;
                }
            }
            return $parent_menu_item;
        }
    }
}

if (function_exists('wpcf7_ajax_loader')) {
    add_action('wp_enqueue_scripts', 'wpcf7_modified_enqueue_scripts', 11);

    function wpcf7_modified_enqueue_scripts()
    {
        wp_deregister_script('contact-form-7');
        wp_enqueue_script('contact-form-7',
            get_bloginfo('stylesheet_directory') . '/js/scripts.js',
            array('jquery', 'jquery-form'), WPCF7_VERSION, true);

        $_wpcf7 = array(
            'loaderUrl' => wpcf7_ajax_loader(),
            'sending' => __('Sending ...', 'contact-form-7'));


        if (defined('WP_CACHE') && WP_CACHE)
            $_wpcf7['cached'] = 1;

        if (wpcf7_support_html5_fallback())
            $_wpcf7['jqueryUi'] = 1;

        wp_localize_script('contact-form-7', '_wpcf7', $_wpcf7);


        // No need for this on the Single Product page


    }
}


add_action('wp_enqueue_scripts', 'cpt_advanced_nav_scripts', 9);

function cpt_advanced_nav_scripts()
{


    // No need for this on the Single Product page
    if (!function_exists('is_product') or !is_product())
        wp_enqueue_script('pageloader', get_bloginfo('stylesheet_directory') . '/js/ajax_layered_nav.js', array('jquery'), '1.2.231', true);


    $html_containers = array(
        '#product_list',
        '.products',
        '#pagination-wrapper',
        '.woocommerce-pagination',
        '.woo-pagination',
        '.pagination',
        '.widget_layered_nav',
        '.widget_layered_nav_filters',
        '.woocommerce-ordering',
        '.sod-inf-nav-next',
        '.woocommerce-result-count',

    );

    $clickables = array(
        '.widget_layered_nav a',
        '.widget_layered_nav input[type="checkbox"]',
        '.widget_ajax_layered_nav_filters a'
    );

    $html_containers = apply_filters('sod_ajax_layered_nav_containers', $html_containers);
    $clickables = apply_filters('sod_ajax_layered_nav_clickables', $clickables);
    $order_by_form = apply_filters('sod_ajax_layered_nav_orderby', '.woocommerce-ordering');
    $products_container = apply_filters('sod_ajax_layered_nav_product_container', '#product_list');
    $inf_scroll_nav = apply_filters('sod_ajax_layered_nav_inf_scroll_nav', '.sod-inf-nav-next');
    $redirect = apply_filters('woocommerce_redirect_single_search_result', false) ? '1' : '0';
    $scroll = apply_filters('sod_ajax_layered_nav_scrolltop', true) ? '1' : '0';
    $offset = apply_filters('sod_ajax_layered_nav_offset', '150');
    $args = array(
        'loading_img' => get_bloginfo('stylesheet_directory') . '/images/loading.gif',
        'superstore_img' => get_bloginfo('stylesheet_directory') . '/images/ajax-loader.gif',
        'nextSelector' => apply_filters('sod_aln_inf_scroll_next', '.pagination a.next'),
        'navSelector' => apply_filters('sod_aln_inf_scroll_nav', '.pagination'),
        'itemSelector' => apply_filters('sod_aln_inf_scroll_item', '#main .product'),
        'contentSelector' => apply_filters('sod_aln_inf_scroll_content', '#main ul.products'),
        'loading_text' => __('Loading', 'sod_ajax_layered_nav'),
        'containers' => $html_containers,
        'triggers' => $clickables,
        'orderby' => $order_by_form,
        'product_container' => $products_container,
        'inf_scroll_nav' => $inf_scroll_nav,
        'search_page_redirect' => $redirect,
        'scrolltop' => $scroll,
        'offset' => $offset,
    );

    wp_localize_script('pageloader', 'ajax_layered_nav', $args);
}

/**
 * From 15-04-2016
 */
// wp_enqueue_style

add_action('wp_enqueue_scripts', 'alor_main_styles_scripts');

function alor_main_styles_scripts()
{
    global $post;
    $version = '0.4.3765.01';
    wp_enqueue_style('icon-font', get_template_directory_uri() . '/icon-font.css', array(), $version);
    wp_enqueue_style('fancybox', get_template_directory_uri() . '/fancybox.css', array(), $version);
    wp_enqueue_style('bootstrap-min', get_template_directory_uri() . '/bootstrap.min.css', array(), $version);
    wp_enqueue_style('all', get_template_directory_uri() . '/all.css', array(), $version);
    wp_enqueue_style('style-css', get_stylesheet_uri(), array(), $version);

    wp_enqueue_script('listing-paginate-js', get_template_directory_uri() . '/js/listing.paginate.js', array('jquery'), $version);
    wp_enqueue_script('fancybox-js', get_template_directory_uri() . '/js/jquery.fancybox.js', array('jquery'), $version);
    wp_localize_script('listing-paginate-js', 'ajaxObject', array('ajaxUrl' => admin_url('admin-ajax.php')));


    if (is_category() || is_author()) {
        $latest_post_id = $post->ID;
    } elseif (is_page_template('template-blog.php')) {
        $latest_post = get_posts(array(
            'posts_per_page' => 1,
            'post_status' => 'publish'
        ));
        $latest_post_id = $latest_post[0]->ID;
    }
    if (!empty($latest_post_id)) {
        wp_enqueue_script('featured-image-resize-js', get_template_directory_uri() . '/js/featured.image.resize.js', array('jquery'), $version);
        $image = get_field('extra_image_2', $latest_post_id);
        $src640 = $image['sizes']['blog_featured_responsive_640'];
        $src768 = $image['sizes']['blog_featured_responsive_768'];

        $src_array = array(
            'imageDefault' => $image['url'],
            'imageSrc640' => $src640,
            'imageSrc768' => $src768
        );
        wp_localize_script('featured-image-resize-js', 'valueObject', $src_array);
    }
}

// AJAX Load More

add_action('wp_ajax_load_more_posts', 'load_more_posts_callback');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_callback');

function load_more_posts_callback()
{
    $archiveType = $_POST['archiveType'];
    $archiveID = $_POST['archiveID'];
    $paged = $_POST['paged'];

    if ($archiveType == 'default') {
        $latest_post = get_posts(array(
            'posts_per_page' => 1,
            'post_status' => 'publish'
        ));
        $query = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'paged' => $paged,
            'post__not_in' => array($latest_post[0]->ID)
        ));
        if ($paged == $query->max_num_pages) {
            $response['last_page'] = 'yes';
        } else {
            $response['last_page'] = 'no';
        }
    }
    if ($archiveType == 'category') {
        $latest_post = get_posts(array(
            'posts_per_page' => 1,
            'post_status' => 'publish',
            'tax_query' => array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => array($archiveID)
            )
        ));
        $query = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'paged' => $paged,
            'post__not_in' => array($latest_post[0]->ID),
            'cat' => $archiveID
        ));
        if ($paged == $query->max_num_pages) {
            $response['last_page'] = 'yes';
        } else {
            $response['last_page'] = 'no';
        }
    }

    if ($archiveType == 'author') {
        $latest_post = get_posts(array(
            'posts_per_page' => 1,
            'post_status' => 'publish',
            'author' => $archiveID
        ));
        $query = new WP_Query(array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'paged' => $paged,
            'post__not_in' => array($latest_post[0]->ID),
            'author' => $archiveID
        ));
        if ($paged == $query->max_num_pages) {
            $response['last_page'] = 'yes';
        } else {
            $response['last_page'] = 'no';
        }
    }
    $response['html'] = '';
    while ($query->have_posts()) {
        $query->the_post();
        $response['html'] .= '<div class="itempst"><div class="left">';

        $categories = get_the_category();
        $response['html'] .= '<div class="itemtp">';
        if (!empty($categories)) {
            $response['html'] .= '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_attr($categories[0]->name) . '</a>';
        }
        $response['html'] .= ' | ' . get_the_date('M j, Y') . '' . '</div><h2><a href="' . get_permalink() . '">' . esc_attr(get_the_title()) . '</a></h2><div class="itemcnt">';

        $content = esc_attr(get_the_content());
        if (strlen($content) <= 35)
            $response['html'] .= '<p>' . strip_tags($content) . '</p>';
        else
            $response['html'] .= '<p>' . substr(strip_tags($content), 0, 160) . '....' . '</p><a href="' . get_permalink() . '">Read More</a>';

        $response['html'] .= '</div></div><div class="right">';

        $image = get_field('extra_image_1', get_the_ID());
        if (!empty($image)) {
            $response['html'] .= '<a href="' . get_permalink() . '"><img src="' . $image['url'] . '" alt="' . $image['alt'] . '"></a>';
        }

        $response['html'] .= '</div></div>';
    }
    wp_reset_query();

    echo json_encode($response);
    exit();
}

// Adding Product Category Metabox in "Post"

add_action('add_meta_boxes', 'alor_product_cat_metabox');

function alor_product_cat_metabox()
{
    add_meta_box('alor_product_cats', __('Product Categories', 'alor'), 'alor_product_cat_metabox_content', 'post', 'side');
}

function alor_product_cat_metabox_content($post)
{
    // $all_product_cats = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => false ) ); // Since WordPress v4.5.0
    $all_product_cats = get_terms('product_cat', array('hide_empty' => false)); // Before WordPress v4.5.0
    $product_cat_id = get_post_meta($post->ID, '_product_cat_id', true);

    if (!empty($all_product_cats)) : ?>
        <select name="product_cat_id" required>
            <option value="">Select</option>
            <?php foreach ($all_product_cats as $cat) : ?>
                <option value="<?php echo $cat->term_id; ?>" <?php if (!empty($product_cat_id) && ($cat->term_id == $product_cat_id)) echo 'selected'; ?>><?php echo $cat->name; ?></option>
            <?php endforeach; ?>
        </select>
    <?php else : ?>
        <p>No Product Categories Found!</p>
    <?php endif;
}

add_action('save_post', 'save_alor_product_cat_metabox_content');

function save_alor_product_cat_metabox_content($post_id)
{
    global $post, $_POST;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if ($post->post_type != 'post') return;

    update_post_meta($post->ID, '_product_cat_id', $_POST['product_cat_id']);
}

/**
 * Shortcode For Displaying Blog Section at Home Page
 */
add_shortcode('home-blog', 'alor_home_blog_shortcode_callback');

function alor_home_blog_shortcode_callback()
{
    $posts = get_posts(array(
        'posts_per_page' => 3,
        'post_type' => 'post',
        'post_status' => 'publish'
    ));
    $numposts = count($posts); ?>
    <?php if (!empty($posts)) : ?>
    <div class="row wearout">
        <div class="col-sm-12">
            <div class="wearhead">
                <h3><a href="<?php echo get_page_link(get_page_by_title('WHERE TO WEAR - BLOG')->ID); ?>">WHERE TO WEAR
                        - BLOG</a></h3>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?php
            $image1 = get_field('extra_image_1', $posts[0]->ID);
            if (!empty($image1)) :
                ?>
                <div class="wear_pic">
                    <a href="<?php echo get_permalink($posts[0]->ID); ?>"><img src="<?php echo $image1['url']; ?>"
                                                                               alt="<?php echo $image1['alt']; ?>"/></a>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="wear_cont">
                <h2>
                    <a href="<?php echo get_permalink($posts[0]->ID); ?>"><?php echo esc_attr($posts[0]->post_title); ?></a>
                </h2>
                <div class="wrcnt_tp">
                    <span><?php echo get_the_date('M j, Y', $posts[0]->ID); ?></span>
                    <small>by <a
                                href="<?php echo get_author_posts_url(get_the_author_meta('ID', $posts[0]->post_author), get_the_author_meta('user_nicename', $posts[0]->post_author)); ?>"><?php echo get_the_author_meta('display_name', $posts[0]->post_author); ?></a>
                    </small>
                </div>
                <?php
                $content = esc_attr($posts[0]->post_content);
                if (strlen($content) <= 200) {
                    echo '<p>' . get_excerpt($content, strlen($content)) . '</p>';
                } else {
                    echo '<p class="abc">' . substr(get_excerpt($content, 200), 0, 200) . '....' . '</p><a href="' . get_permalink($posts[0]->ID) . '">Read More</a>';
                }
                ?>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <?php if ($numposts >= 2) : ?>
                <div class="wer_ghCol">
                    <?php
                    $image2 = get_field('extra_image_1', $posts[1]->ID);
                    if (!empty($image2)) :
                        ?>
                        <a href="<?php echo get_permalink($posts[1]->ID); ?>"><img src="<?php echo $image2['url']; ?>"
                                                                                   alt="<?php echo $image2['alt']; ?>"/></a>
                    <?php endif; ?>
                    <h4>
                        <a href="<?php echo get_permalink($posts[1]->ID); ?>"><?php echo esc_attr($posts[1]->post_title); ?></a>
                    </h4>
                </div>
            <?php endif;
            if ($numposts == 3) : ?>
                <div class="wer_ghCol">
                    <?php
                    $image3 = get_field('extra_image_1', $posts[2]->ID);
                    if (!empty($image3)) :
                        ?>
                        <a href="<?php echo get_permalink($posts[2]->ID); ?>"><img src="<?php echo $image3['url']; ?>"
                                                                                   alt="<?php echo $image3['alt']; ?>"/></a>
                    <?php endif; ?>
                    <h4>
                        <a href="<?php echo get_permalink($posts[2]->ID); ?>"><?php echo esc_attr($posts[2]->post_title); ?></a>
                    </h4>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif;
}

/**
 * @global type $wpdb
 * @param type $cat_id
 * @return type
 */
function alor_get_cat_published_posts_count($cat_id)
{
    global $wpdb;

    $querystr = "
    SELECT count(*)
    FROM $wpdb->term_taxonomy, $wpdb->posts, $wpdb->term_relationships
    WHERE $wpdb->posts.ID = $wpdb->term_relationships.object_id
    AND $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id
    AND $wpdb->term_taxonomy.term_id = $cat_id
    AND $wpdb->posts.post_status = 'publish'
  ";
    $result = $wpdb->get_var($querystr);

    return !is_null($result) ? $result : 0;
}

/************* My File 12-05-2016 ******************/
function producttag_taxonomy_edit_meta_field($term)
{
    get_template_part('upload-scripts');
    // put the term ID into a variable
    $t_id = $term->term_id;
    $t_slug = $term->slug;

    $args = array('post_type' => 'product', 'posts_per_page' => -1, 'product_tag' => $t_slug);
    $query = get_posts($args);
    if ($query) {
        $temp = array();
        foreach ($query as $post) : setup_postdata($post);
            $terms = get_the_terms($post->ID, 'pa_category-type');
            foreach ($terms as $term) {
                if (!in_array($term->name, $temp)) {
                    $temp[] = $term->name;
                    $temp1[] = $term->term_id;
                    $temp2[] = $term->slug;
                }
            }
        endforeach;
    }
    // retrieve the existing value(s) for this meta field. This returns an array
    $cnt = count($temp);
    if ($temp) {
        for ($i = 0; $i < count($temp); $i++) {
            $return = '';
            $container = esc_attr(get_option("term_image_" . $i . "_" . $t_id)) ? '<img src="' . get_option("term_image_" . $i . "_" . $t_id) . '" style="max-width:300px;max-height: 150px;" alt="banner-image" />' : '';
            $slug = (get_option("term_slug_" . $i . "_" . $t_id)) ? get_option("term_slug_" . $i . "_" . $t_id) : $temp2[$i];
            $return .= '<tr class="form-field" valign="top"><th scope="row"><label>' . $temp[$i] . ' Image</label></th><td><div class="upload-image"><div class="upload-image-container">' . $container . '</div><!-- upload-image-container --><input class="regular-text up-image" readonly="readonly" id="term_image_' . $i . '" name="term_image_' . $i . '" type="hidden" value="' . get_option("term_image_" . $i . "_" . $t_id) . '" /><input class="regular-text" readonly="readonly" id="term_slug_' . $i . '" name="term_slug_' . $i . '" type="hidden" value="' . $slug . '" /><input class="button upload-button" type="button" value="Upload/Edit Image" class="thickbox" /> <input class="button remove-button" type="button" value="Remove image" /></div><!-- upload-image --></td></tr>';
            echo $return;
        }
        $temps1 = implode(",", $temp1);
        echo '<input class="regular-text up-image" id="term_cnt" name="term_cnt" type="hidden" value="' . $cnt . '" />';
        echo '<input class="regular-text up-image" id="term_ids" name="term_ids" type="hidden" value="' . $temps1 . '" />';
    }
}

add_action('product_tag_edit_form_fields', 'producttag_taxonomy_edit_meta_field', 10, 2);
function save_taxonomy_meta($term_id)
{
    if (isset($_POST['term_cnt'])) {
        $t_id = $term_id;
        for ($i = 0; $i < $_POST['term_cnt']; $i++) {
            if ($_POST['term_image_' . $i] != '' && get_option("term_image_" . $i . "_" . $t_id) != '') {
                update_option("term_image_" . $i . "_" . $t_id, $_POST['term_image_' . $i]);
                update_option("term_slug_" . $i . "_" . $t_id, $_POST['term_slug_' . $i]);
            } else if (($_POST['term_image_' . $i] == '' && get_option("term_image_" . $i . "_" . $t_id) != '')) {
                update_option("term_image_" . $i . "_" . $t_id, $_POST['term_image_' . $i]);
                update_option("term_slug_" . $i . "_" . $t_id, $_POST['term_slug_' . $i]);
            } else if (($_POST['term_image_' . $i] != '' && get_option("term_image_" . $i . "_" . $t_id) == '')) {
                update_option("term_image_" . $i . "_" . $t_id, $_POST['term_image_' . $i]);
                update_option("term_slug_" . $i . "_" . $t_id, $_POST['term_slug_' . $i]);
            } else if ($_POST['term_image_' . $i] != '') {
                add_option("term_image_" . $i . "_" . $t_id, $_POST['term_image_' . $i]);
                add_option("term_slug_" . $i . "_" . $t_id, $_POST['term_slug_' . $i]);
            }
        }
        if (get_option("term_cnt_$t_id")) {
            update_option("term_cnt_$t_id", $_POST['term_cnt']);
        } else {
            add_option("term_cnt_$t_id", $_POST['term_cnt']);
        }
    }
}

add_action('edited_product_tag', 'save_taxonomy_meta', 10, 2);



/********************18-05-2016*********************/
if (!function_exists('get_excerpt')) {
    function get_excerpt($phrase, $max_words)
    {
        $excerpt = $phrase;
        $excerpt = strip_tags($excerpt);
        $excerpt = strip_shortcodes($excerpt);
        $excerpt = preg_replace('/(?:<|&lt;).+?(?:>|&gt;)/', '', $excerpt);
        $excerpt = preg_replace(" (\[.*?\])", '', $excerpt);
        $excerpt = preg_replace('/<[^>]*>/', '', $excerpt);
        $excerpt = substr($excerpt, 0, $max_words);
        $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
        $excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));
        return $excerpt;
    }
}




/***********************remove pagination******************************

if( isset( $_GET['showall'] ) ){ 
    add_filter( 'loop_shop_per_page', create_function( '$cols', 'return -1;' ) ); 
} else {
    add_filter( 'loop_shop_per_page', create_function( '$cols', 'return -1;' ) );
}

*/
?>

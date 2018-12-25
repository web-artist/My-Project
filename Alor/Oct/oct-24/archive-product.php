<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.0.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

get_header('shop');


?>
<?php global $wp_query; //print_r($wp_query); 
$parent_menu_title = "";


?>
<?php

$menu_arr = my_get_menu_item_name('header_location');


if (is_array($menu_arr)) {


    $sub_menu_ar = wp_get_nav_menu_items($menu_arr['term_id']);


    // $submenulist='<ul class="hover-list" style="display: none;">';
    $submenulist = '<ul class="hover-list">';
    foreach ($sub_menu_ar as $k => $v) {
        // Check if this menu item links to the current page

        if ($sub_menu_ar[$k]->ID == $menu_arr['current_parent_menu']) {
            $parent_menu_title = $sub_menu_ar[$k]->title;
        }

        if ($sub_menu_ar[$k]->menu_item_parent == $menu_arr['current_parent_menu']) {

            $submenulist .= '<li><a href="' . $sub_menu_ar[$k]->url . '">' . $sub_menu_ar[$k]->title . '</a> </li>';
        }
    }
    $submenulist .= '</ul>';
}


?>
    <a class="lbp-inline-link-1" href="#" style="display:none;">Inline HTML Link Name</a>
    <div style="display:none">
        <div id="lbp-inline-href-1" style="padding: 10px;background: #fff;height:100%;">


        </div>
    </div>
<?php //query_posts(array('post_type'	=> 'product')); ?>
<?php
/**
 * woocommerce_before_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

//do_action('woocommerce_before_main_content');
?>
    <div class="wrp_inner">
<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
    <?php $term = get_queried_object();//print_r($term); ?>
    <?php if (is_product_category()) $display_type = get_woocommerce_term_meta($term->term_id, 'display_type', true); ?>
<?php endif; ?></div>

    <!-- <section id="content" class="container"> -->
<?php
global $wp_query;
?>

<?php 
if (is_search()) {

    ?>
    <h3 style="text-align:center; padding-bottom:10px;"><?php printf(__('Search Results For %s', 'woocommerce'), '<b>"' . get_search_query() . '"</b>'); ?></h3>
<?php } ?>
<?php
if (is_search() && $wp_query->post_count == 0) {
    $prdct_cat = get_terms('product_cat');
    $prdct_tag = get_terms('product_tag');
    $search_k = $_GET['s']; //search key

    foreach ($prdct_cat as $name) {
        $catpos = stripos($name->name, $search_k);
        if ($catpos !== false) {
            $cat_termslugs[] = $name->slug;
        }
    }

    foreach ($prdct_tag as $name) {
        $tagpos = stripos($name->name, $search_k);
        if ($tagpos !== false) {
            $tax_termslugs[] = $name->slug;
        }
    }

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'operator' => 'IN',
                'terms' => $cat_termslugs
            ),
            array(
                'taxonomy' => 'product_tag',
                'field' => 'slug',
                'operator' => 'IN',
                'terms' => $tax_termslugs
            )
        ),
    );

    $taxquery = new WP_Query($args);
	$total_post = $taxquery->found_posts;
if ($taxquery->have_posts()) : ?>

    <?php
    /**
     * woocommerce_before_shop_loop hook
     *
     * @hooked woocommerce_result_count - 20
     * @hooked woocommerce_catalog_ordering - 30
     */

    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    do_action('woocommerce_before_shop_loop');
    ?>
    <?php //woocommerce_product_loop_start(); ?>
    <?php breadcrumb_header() ?>
    <div class="row">
        <?php woocommerce_product_subcategories(); ?>
    </div>

    <?php if ((is_post_type_archive()) or (is_product_tag()) or (is_product_category() and (($display_type == 'products') or ($display_type == 'both') or ((!get_option('woocommerce_category_archive_display') or get_option('woocommerce_category_archive_display') == 'both') and !$display_type)))): ?>
    <?php
    ob_start();
    dynamic_sidebar('layer_sidebar');
    $layer_sidebar = ob_get_clean();

if (!empty($layer_sidebar)) {
    ?>
    <div class="row 1">
<?php }else { ?>
    <div class="full-width-blck ">
<?php } ?>
    <div class="catalog  scroll_parent_wrap3">
        <?php


        if (!empty($layer_sidebar)) {
            ?>

            <div class="left-side-blck">
                <div class="controls-panel">

                    <?php /* <h2><?php _e('Filters','alor'); ?></h2> */ ?>
                    <div class="menu">
                        <?php if (!empty($parent_menu_title)) { ?>
                            <div id="filter_cat_drp" class="widget">
                                <!--<h3 class="arrowdeactive"><?php // echo $parent_menu_title;?></h3>-->
                                <h3 class="arrowactive"><?php echo $parent_menu_title; ?></h3>
                                <?php echo $submenulist; ?>
                            </div>
                        <?php } ?>

                        <?php echo str_replace('<ul>', '<ul class="hover-list">', $layer_sidebar); ?>

                        <?php
                        remove_action('woocommerce_before_shop_loop', 'woocommerce_show_messages', 10);
                        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
                        //do_action( 'woocommerce_before_shop_loop' );
                        ?>
                    </div>
                    <?php
                    /**
                     * woocommerce_after_shop_loop hook
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    //do_action( 'woocommerce_after_shop_loop' );
                    ?>

                </div>
            </div>

        <?php } ?>
        <div id="product_list" class="right-side-blck">

            <ul class="products catalog-list">
                <?php
                $_GET['flag_first_item'] = 1;
                while ($taxquery->have_posts()) : $taxquery->the_post(); ?>

                    <?php woocommerce_get_template_part('content', 'product-list'); ?>

                    <?php $_GET['flag_first_item'] = $_GET['flag_first_item'] + 1; endwhile; // end of the loop. ?>
            <div  class="load-more-post div-height" style="display:none;"><?php $prdctop_cat= $wp_query->get_queried_object()->term_id;?><input type="hidden" id="cat_id" data-tax-terms="<?php echo $tax_termslugs?>" value="<?php echo $prdctop_cat ;?>"/></div>
			<div style="clear:both"></div>
			</ul>
				
				
        </div>
    </div>
</div>
<?php endif; ?>
<?php //woocommerce_product_loop_end(); ?>
    <script type="text/javascript">
        jQuery(window).trigger('initFadeList');
        jQuery(window).trigger('initTouchNav');
        jQuery(window).trigger('initRefreshHeight');
        jQuery(window).trigger('initFadeProducts');
    </script>
	

<?php
/**
 * woocommerce_after_shop_loop hook
 *
 * @hooked woocommerce_pagination - 10
 */
//    remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
//	do_action( 'woocommerce_after_shop_loop' );
?>

<?php elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>

    <?php woocommerce_get_template('loop/no-products-found.php'); ?>

<?php endif; ?>
<?php
} else {
?>
    <?php breadcrumb_header() ?>
    <div id="products">

<?php
/**
 * woocommerce_before_shop_loop hook
 *
 * @hooked woocommerce_result_count - 20
 * @hooked woocommerce_catalog_ordering - 30
 */
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
do_action('woocommerce_before_shop_loop');
?>
<?php
if (have_posts()) : ?>
    <div class="row">
        <?php woocommerce_product_subcategories(); ?>
    </div>
<?php if ((is_post_type_archive()) or (is_product_tag()) or (is_product_category() and (($display_type == 'products') or ($display_type == 'both') or ((!get_option('woocommerce_category_archive_display') or get_option('woocommerce_category_archive_display') == 'both') and !$display_type)))):
?>

<?php

if (is_active_sidebar('layer_sidebar') == 1){
?>
    <div class="row 2">
        <?php }else{ ?>
        <div class="full-width-blck ">
            <?php } ?>
            <div class="catalog  scroll_parent_wrap7">
                <?php
                if ((is_active_sidebar('layer_sidebar') == 1)) {
                    ?>
                    <div class="left-side-blck">
                        <div class="controls-panel">
                            <?php $source_tax = $_GET['source_tax']; ?>

                            <?php if (is_product_category()) { ?>

                                <?php
                                $current_term_id = get_queried_object_id();
                                $taxonomy_name = "product_cat";

                                $this_term = get_term($current_term_id, $taxonomy_name);
                                $parent_term = $this_term->parent;
                                $parent_term_object = get_term($parent_term, $taxonomy_name);
                                $parent_term_name = $parent_term_object->name;
                                $term_children = get_term_children($parent_term, $taxonomy_name);


                                ?>
                                <div class="menu">
                                    <div id="filter_cat_drp" class="widget">
                                        <h3 class="arrowdeactive"><?php if ($parent_term_name == "Gents") {
                                                echo "Mens";
                                            } elseif ($parent_term_name == "Ladies") {
                                                echo "Womens";
                                            } else {
                                                echo $parent_term_name;
                                            } ?></h3>
                                        <ul class="hover-list">

                                            <?php
                                            foreach ($term_children as $child) {
                                                $term = get_term_by('id', $child, $taxonomy_name);
                                                if ($term->count > 0) {
                                                    echo '<li><a href="' . get_term_link($child, $taxonomy_name) . '">' . $term->name . '</a></li>';
                                                }
                                            }

                                            ?>
                                        </ul>
                                    </div>
                                </div>


                            <?php } else {
                                dynamic_sidebar('custom_sidebar');
                            } ?>
                            <?php dynamic_sidebar('layer_sidebar'); ?>
                        </div>
                    </div>

                <?php } ?>
                <div id="product_list" class=" right-side-blck">
                    <ul class="catalog-list products">
                        <?php
                        $_GET['flag_first_item'] = 1;
                        while (have_posts()) : the_post(); ?>

                            <?php woocommerce_get_template_part('content', 'product'); ?>

                            <?php $_GET['flag_first_item'] = $_GET['flag_first_item'] + 1; endwhile; // end of the loop. 
                        ?>
						<div  class="load-more-post div-height" style="display:none;"><?php $prdcat_id= $wp_query->get_queried_object()->term_id;$term_slug = get_term_by('id', $prdcat_id, 'product_cat', 'ARRAY_A'); $term = get_term( $prdcat_id, 'product_cat' ); ?><input type="hidden" id="cat_id"  data-tax-terms="<?php echo $term_slug['slug'];?>" data-total-product=<?php echo  $term->count;?> value="<?php echo $prdcat_id ;?>"/></div>
						<div style="clear:both"></div>
                    </ul>
					
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <script type="text/javascript">
        jQuery(window).trigger('initFadeList');
        jQuery(window).trigger('initTouchNav');
        jQuery(window).trigger('initRefreshHeight');
        jQuery(window).trigger('initFadeProducts');


        jQuery(document).ready(function ($) {
            $('.controls-panel .widget h3').toggle(
                function () {
                    $(this).find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                    $(this).parent().find('div').slideUp();
                    $(this).parent().find('form').slideUp();
                    $(this).parent().find('ul').slideUp();
                }, function () {
                    $(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                    $(this).parent().find('div').slideDown();
                    $(this).parent().find('form').slideDown();
                    $(this).parent().find('ul').slideDown();
                }
            );
            $(".various").fancybox({
                maxWidth: 800,
                maxHeight: 600,
                fitToView: false,
                width: '70%',
                height: '70%',
                autoSize: false,
                closeClick: false,
                openEffect: 'none',
                closeEffect: 'none'
            });

            var value = $('.yith-wcan-list-price-filter > li:last-child > a > span:first-child').text();
            value = value.replace("-", "+");
            // can then use it as
            $(".yith-wcan-list-price-filter > li:last-child > a").text(value + ' +');

            if ($(window).width() <= 768) {
                $('.inner_cls #products .catalog li .caption').remove();
                $('.inner_cls #products .catalog li .hide-cls').remove();

                $('.inner_cls #products .catalog li a').on('click touchend', function (e) {
                    var el = $(this);
                    var link = el.attr('href');
                    window.location = link;
                });
            }
            if ($(window).width() >= 768 && $(window).width() <= 1024) {
                $('.inner_cls #products .catalog li .caption').remove();
                $('.inner_cls #products .catalog li .hide-cls').remove();

                $('.inner_cls #products .catalog li a').on('click touchend', function (e) {
                    var el = $(this);
                    var link = el.attr('href');
                    window.location = link;
                });
            }
        });
    </script>
    <?php
    /**
     * woocommerce_after_shop_loop hook
     *
     * @hooked woocommerce_pagination - 10
     */
    do_action('woocommerce_after_shop_loop');
    ?>

<?php elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>

    <?php woocommerce_get_template('loop/no-products-found.php'); ?>

<?php endif;
}

?>

<?php
/**
 * woocommerce_after_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');
?>

<?php
/**
 * woocommerce_sidebar hook
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');
?>

<script>
jQuery(function($){
	
	var ajaxUrl="<?php echo admin_url('admin-ajax.php')?>";
	var page=1;
	var cat_id = $("#cat_id").val();
	var cat_slug = $("#cat_id").attr("data-tax-terms");
	var cat_total_product = $("#cat_id").attr("data-total-product");
	var ppp=cat_total_product -13;
	
	if(cat_total_product > 13) {
	
  }
});
</script>
<style>
.woocommerce-pagination1{display:none;}
</style>
<?php get_footer('shop'); ?>
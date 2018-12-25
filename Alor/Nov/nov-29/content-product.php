<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version   3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if (empty($woocommerce_loop['loop']))
    $woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if (empty($woocommerce_loop['columns']))
    $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 4);

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}
// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if (0 == ($woocommerce_loop['loop'] - 1) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'])
    $classes[] = 'first';
if (0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'])
    $classes[] = 'last';

if (isset($_GET['flag_first_item'])) {
    $flag_first_item = $_GET['flag_first_item'];
}
?>

<?php
$pid = $product->id;
$price = $product->price;
//$src = wp_get_attachment_image_src( wp_get_attachment_image($pid, 'thumbnail'));
$desc = get_post_meta($pid, 'description', true);
//$image = $src[0];
//echo "src".$image;
//print_r($src);
?>


<li class="cus_col-sm-3 cat-item1 myproducts" data-href="<?php the_permalink(); ?>">

    <?php if ($flag_first_item == 1) { ?>
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('shop_catalog'); ?></a>

        <div class="caption"><a href="<?php the_permalink(); ?>" style="display:block;"> &nbsp; </a>
            <!--<p class="qik_view"><a href="#quick_view_content<?php //echo $pid; ?>"
                                   class="qik_view_btn various"><?php //echo __('QuickView', 'cpt'); ?></a></p>-->
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
                 class="quick_view_cls"> <?php echo do_shortcode('[cpt_quick_view product_id=' . $pid . ']'); ?></div>
        </div>
    <?php } else { ?>
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('shop_thumbnail'); ?></a>

        <div class="caption"><a href="<?php the_permalink(); ?>" style="display:block;"> &nbsp; </a>
            <!--<p class="qik_view"><a href="#quick_view_content<?php //echo $pid; ?>"
                                   class="qik_view_btn various"><?php //echo __('QuickView', 'cpt'); ?></a></p>-->
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
                 class="quick_view_cls"> <?php echo do_shortcode('[cpt_quick_view product_id=' . $pid . ']'); ?></div>
        </div>
		<div class="product-menu-order" style="display:none">
			<input type="hidden" name="menu-order-value" value="<?php echo $product->get_menu_order();?>" >
		</div>
    <?php } ?>
    <?php remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10); ?>
    <?php do_action('woocommerce_after_shop_loop_item'); ?>
</li>



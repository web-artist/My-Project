<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>

<?php
/**
 * woocommerce_before_single_product hook.
 *
 * @hooked wc_print_notices - 10
 */
/* diff - do_action( 'woocommerce_before_single_product' ); */
if (post_password_required()) {
    echo get_the_password_form();
    return;
}
?>


   

    <div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>


        <?php
        /**
         * woocommerce_show_product_images hook
         *
         * @hooked woocommerce_show_product_sale_flash - 10
         * @hooked woocommerce_show_product_images - 20
         */

        do_action('woocommerce_before_single_product_summary');
        ?>
    


        <div class="content scrolltop_cls col-sm-3 col-md-3">


            <?php
            /**
             * woocommerce_single_product_summary hook
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             * @hooked WC_Structured_Data::generate_product_data() - 60
             */

            /** start - diff */
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
            add_action('woocommerce_single_product_summary', 'woocommerce_upsell_display', 15);
            /** end - diff */
            do_action('woocommerce_single_product_summary');


            /**
             * woocommerce_after_single_product_summary hook
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_upsell_display - 15
             * @hooked woocommerce_output_related_products - 20
             */

            /** start - diff */
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
            add_action('woocommerce_after_single_product_summary', 'custom_woocommerce_cross_sell_display', 20);
            /** end - diff */

            do_action('woocommerce_after_single_product_summary');
            ?>
            
            <div class="product-warranty">
	            <img src="https://alor.com/wp-content/uploads/warranty.png" />
	        </div>
            
        </div>


    </div><!-- .summary -->
<div class="clear">

</div>

<div class="related-products-own col-sm-12 col-md-12">
<?php

//echo do_shortcode( '[related_products columns="4"]' );

?>
</div>

<?php do_action('woocommerce_after_single_product'); ?>


<script type="text/javascript">
    jQuery('.related-products-own section .add span a').text('View product');   

</script>

<style type="text/css">

.color-options-blk ul.ul-color-list li{
border: 1px solid;
}

.color-options-blk ul.ul-color-list {   
    vertical-align: middle;
    display: inline-flex;
}
#newsletterwidget-2 > h3 {
    margin-bottom: 25px;
}


.jssort03:nth-child(1) div {
    background: transparent !important;
    border: medium none !important;
}

.woocommerce-images {
  width: 70%;
}


@media (max-width: 1300px){
#product-191057 {
    width: 100%;
}
#slider2_container {
    width: 70% !important;
}
#slider2_container img {
    width: 100% !important;
    display: inline-block;
}

.woocommerce-images {
  width: 100%;
}

}


@media (max-width: 991px){
    .woocommerce-images {
    width: 100% !important;
    float: left;
}
.products.catalog-list li {
    width: 45% !important;
    margin: 5px 11px !important;
}
.products.catalog-list li .bottom {
    display: block !important;
}
#product-191057 {
    width: 100%;
}
.content.scrolltop_cls {
    width: 100%;
    right: 0;
}
}




@media (max-width: 767px){
    .woocommerce-images {
    width: 100% !important;
    float: none;
}
.products.catalog-list li {
    width: 43% !important;
    margin: 5px 11px !important;
}
.products.catalog-list li .bottom {
    display: block !important;
}

.content.scrolltop_cls {
    width: 100% !important;
    right: 0;
}
}

@media (min-width: 320px) and (max-width: 450px){
.products.catalog-list li {
    width: 100% !important;
    margin: 5px 11px !important;
}
}


</style>




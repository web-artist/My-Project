<?php
/**
	Template Name: Simple Product List
 * The Template for displaying simple product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     2.0.0
 */



get_header();


?>
<?php global $wp_query; //print_r($wp_query); 
$parent_menu_title = "";


?>


    
  <div id="products">
  <div class="row">
  <div class="catalog  scroll_parent_wrap7">
  <div id="product_list" class="right-side-blck1">

	<div class="yit-wcan-container post-listing">

            <ul class="products catalog-list">
 <h2>Products</h2>
<?php
	$cat= 986;
         $args = array(
    'post_type'             => 'product',
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => 1,
    'posts_per_page'        => -1,  	
    'tax_query'             => array(
        array(
            'taxonomy'      => 'product_cat',
            'field' => 'term_id', //This is optional, as it defaults to 'term_id'
            'terms'         => $cat,
            'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
        ),
		array(
        'taxonomy'        => 'pa_color',
        'field'           => 'slug',
        'terms'           =>  'grey',
        'operator'        => 'IN',
    ),
		array(
        'taxonomy'        => 'pa_diamonds',
        'field'           => 'slug',
        'terms'           =>  'yes',
        'operator'        => 'IN',
    )
    )
);
  $loop = new WP_Query( $args );
  $total_post = $loop->found_posts;
 //echo $total_post;
        while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

           

                <li class="cus_col-sm-3 cat-item1 myproducts">    

                    <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

                        <?php woocommerce_show_product_sale_flash( $post, $product ); ?>

                        <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>

                        <h3><?php the_title(); ?></h3>

                        <span class="price"><?php echo $product->get_price_html(); ?></span>                    

                    </a>

                    <?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>

                </li>

    <?php endwhile; ?>
    <?php wp_reset_query(); ?>
	<?php //if($total_post > 20){?>
	<div  class="load-more-post div-height"></div>
	<div style="clear:both"></div>
	<div id="clients" class= "infinite-scroll">
	<input type="hidden" id="total_post" data-cat="<?php echo $cat?>" value="<?php echo $total_post ;?>"/></div>
	<?php //}?>
</ul><!--/.products-->
</div>
</div>
</div>
</div>
<div id="full-content-loader" class="loader" style="display: none;text-align:center;padding-top: 30px;padding-bottom: 30px">
<div class="more-product">More product are loading..</div>
<br>
<img src="https://www.shareupproject.com/wp-content/uploads/2017/08/giphy.gif" width="" height="" />
</div>
</div>

<style>
.infinite-scroll{margin-top:3%}
#more_posts{ background: #fff none repeat scroll 0 0;
    border: 2px solid #8cc53e;
    border-radius: 17px;
    color: #8cc53e;
    cursor: pointer;
    font-size: 14px;
    font-weight: 700;
    padding: 10px;
	text-decoration: none;
}
.myproducts1{width:33% !important;}
</style>
<script>
/* jQuery(function($){
	
	var ajaxUrl="<?php echo admin_url('admin-ajax.php')?>";
	
	$(document).ready(function() {
				
				$.post(ajaxUrl,{
					alert("welcome to Alor");
				type: 'POST',
				action:"more_post_ajax",
				offset:8,
				ppp:8
				}).success(function(posts){
					
					page++;						
					$(".load-more-post").before(posts);					
				
				})

			
	});
	

	var page=2;var ppp=8;
	var post_total = $("#total_post").val();
	var set_offset = 16;
	$('.post-listing').append( '<span class="load-more"></span>' );
	var button = $('.post-listing .load-more');
	var page = 2;
	var loading = false;	
	var scrollHandling = {
	    allow: true,
	    reallow: function() {
	        scrollHandling.allow = true;
	    },
	    delay: 400 //(milliseconds) adjust to the highest acceptable value
	};
	
	

	$(window).scroll(function(){
		if(set_offset < post_total) {
		if( ! loading && scrollHandling.allow ) {
			
			scrollHandling.allow = false;
			setTimeout(scrollHandling.reallow, scrollHandling.delay);
			var offset = $(button).offset().top - $(window).scrollTop();
			if( 2000 > offset ) {
				
				loading = true;
				$(".loader").show();
				$.post(ajaxUrl,{
				type: 'POST',
				action:"more_post_ajax",
				offset:(page*ppp),
				ppp:ppp
				}).success(function(posts){
					
					page++;	
					set_offset = page*ppp;						
						
					$(".load-more-post").before(posts);					
					$(".loader").fadeOut("slow");
					
					loading = false;
				})

			}
		}
	}
	});	
	
}); */
</script>
<style>
.more-product {
    font-size: 14px;
    font-weight: bold;
    color: #000;
}
</style>
<?php get_footer(); ?>
<?php
/**
	Template Name: Simple Category Product 
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
$parent_menu_title = "";?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<script>
   $(window).scroll( function(){          
        $('.new').each( function(i){            
            var bottom_of_object = $(this).offset().top + $(this).outerHeight();
            var bottom_of_window = $(window).scrollTop() + $(window).height() + 900;
            if( bottom_of_window > bottom_of_object ){                
                $(this).animate({'opacity':'1'},800);                    
            }            
        });     
    });
  </script>
<style>
.products{ height:auto;}
.new{opacity:0;}
</style>
  <div id="products">
	 <div class="row">
     
			<?php woocommerce_product_subcategories(); ?>
	 </div>
	 <div class="row 2">        
        <div class="full-width-blck ">
		  <div class="catalog  scroll_parent_wrap7">
		  
		  <div class="left-side-blck">
                        <div class="controls-panel">
                            
                            
								<div class="menu">
                                    <div id="filter_cat_drp" class="widget         ">
                                        <h3 class="arrowdeactive" style="display: none;">Rings</h3>
                                        <ul class="hover-list">

                                            <li><a href="https://alor.com/product-category/gents/gents-cufflinks/">Cufflinks</a></li>
										</ul>
                                    </div>
                                </div>


                                                        <div class="widget yith-wcan-list-price-filter yith-woocommerce-ajax-product-filter" id="yith-woo-ajax-navigation-list-price-filter-3"><h3 class="arrowactive" style="display: none;">Price Filter<span class="widget-dropdown" data-toggle="open"></span></h3>    <ul class="yith-wcan-list-price-filter">
                    <li class="price-item">
                                                                <a class="yith-wcan-price-link yith-wcan-price-filter-list-link" href="#">
                    From: <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>0</span> To: <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>250</span>                </a>
            </li>
                    <li class="price-item">
                                                                <a class="yith-wcan-price-link yith-wcan-price-filter-list-link" href="#">
                    From: <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>250</span> To: <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>500</span>                </a>
            </li>
                    <li class="price-item">
                                                                <a class="yith-wcan-price-link yith-wcan-price-filter-list-link" href="#">
                    From: <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>750</span> To: <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>1,000</span>                </a>
            </li>
                    <li class="price-item">
                                                                <a class="yith-wcan-price-link yith-wcan-price-filter-list-link" href="#">
                    From: <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>1,000</span> To: <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>1,500</span>                </a>
            </li>
                    <li class="price-item">
                                                                <a class="yith-wcan-price-link yith-wcan-price-filter-list-link" href="#">
                    From: <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>1,500</span> To: <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>9,995</span>                </a>
            </li>
            </ul>
</div><div class="widget yith-woocommerce-ajax-product-filter yith-woo-ajax-navigation woocommerce widget_layered_nav" id="yith-woo-ajax-navigation-3"><h3 class="arrowactive" style="display: none;">Diamonds</h3><ul class="yith-wcan-list yith-wcan "><li><a href="#">yes</a> <small class="count">42</small><div class="clear"></div></li></ul></div>                        </div>
                    </div>

                
				
				
		  <div id="product_list" class="right-side-blck">
                    	<div style="">
	                    <a href="https://alor.com/product-category/black-friday/"><img src="https://alor.com/wp-content/uploads/banner-monday.jpg" class="img-responsive" /></a>
						</div>
          
          
			<div class="yit-wcan-container post-listing">
			 <ul class="products catalog-list"> 
			<?php 	$cat= 988;
					 $args = array(
				'post_type'             => 'product',
				'post_status'           => 'publish',
				//'ignore_sticky_posts'   => 1,
				'posts_per_page'        => 50,
				'meta_query'            => array(
					array(
						'key'           => '_visibility',
						'value'         => array('catalog', 'visible'),
						'compare'       => 'IN'
					)
				),
				'tax_query'             => array(
					array(
						'taxonomy'      => 'product_cat',
						'field' => 'term_id', //This is optional, as it defaults to 'term_id'
						'terms'         => $cat,
						'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
					)
				)
			);
			  $loop = new WP_Query( $args );
			  $total_post = $loop->found_posts;
					while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>   
								  <li class="cus_col-sm-3 cat-item1 myproducts"> 
								<a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
									<?php woocommerce_show_product_sale_flash( $post, $product ); ?>
									<?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>
									<h3><?php the_title(); ?></h3>
									<span class="price"><?php echo $product->get_price_html(); ?></span></a>
								<?php woocommerce_template_loop_add_to_cart( $loop->post, $product ); ?>
							</li>
				<?php endwhile; ?>
				<?php wp_reset_query(); ?>	
			</ul><!--/.products--></div></div></div></div></div>

<style>
.new li {
  float: left !important;
  vertical-align: top !important;
  margin: 0 0 !important;
  padding: 0 0px !important;
  box-sizing: border-box !important;
  -moz-box-sizing: border-box !important;
  -webkit-box-sizing: border-box !important;
  border-bottom: 1px solid #ddd !important;
  border-right: 1px solid #ddd !important;
  border-top: 1px solid #ddd !important;
}
.new li a {
  display: block !important;
  text-decoration: none !important;
  position: relative !important;
}
.new {
  border-left: 1px solid #ddd;
  float: right;
  padding: 0;
  width: 100%;
}
.myproducts {
  width: 33% !important;
  display: none;
}
.products.catalog-list li:nth-child(-n+10){
  display: block !important;
}
.new li a img {
  display: block;
  width: 100%;
  height: auto;
}
.new li a > span {
  text-align: center !important;
  position: absolute !important;
  bottom: 0;
  left: 0;
  right: 0;
  /* display: none; */
  color: #333;
  background: rgba(250, 250, 250, 0.7);
  padding: 5px 3px;
  border: 1px solid #a98f64;
  border-bottom: none;
  font-family: 'caviar_dreamsbold', Arial, Helvetica, sans-serif;
}
</style>
<script>
  $(function() {
$(window).scroll(function () {
    var y = $(window).scrollTop();
    if (y > 800) {
    	 var divs = $(".catalog-list > .myproducts");
    for(var i = 9; i < divs.length; i+=9) {
      divs.slice(i, i+9).wrapAll("<ul class='new'></ul>");
    }
    }
});
});
</script>
<?php get_footer(); ?>

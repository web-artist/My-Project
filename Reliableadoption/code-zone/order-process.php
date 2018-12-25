<?php
/*
    Template Name: Orders Process
*/
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7 lt-ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8 lt-ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 9]>
<html class="ie ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]--><head><meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href="<?php echo get_stylesheet_directory_uri(); ?>/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/admin/css/fonts.css" rel="stylesheet"> 
<link href="<?php echo get_stylesheet_directory_uri(); ?>/admin/css/font-awesome.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/admin/css/animation.css" media="all" rel="stylesheet" type="text/css">		
<script src="<?php echo get_stylesheet_directory_uri(); ?>/admin/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/admin/js/bootstrap.min.js"></script> 
<script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 <?php    
 /*
 *  Add this to support sites with sites with threaded comments enabled.     
 */  
 
 if ( is_singular() && get_option( 'thread_comments' ) )
	
	wp_enqueue_script( 'comment-reply' ); 
 
 
	wp_head();
?>

<link href="<?php echo get_stylesheet_directory_uri(); ?>/admin/css/style.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/admin/css/responsive.css" rel="stylesheet"> 
</head>
 
 <body>
	 <div class="container">
		 <div class="in_body">
			 <div class="row">
				<div class="col-md-12">
<?php 
function order_to_process()
{

global $wpdb;

$sql = $wpdb->get_results("SELECT *, DATE_SUB(usr.user_registered, INTERVAL 7 HOUR) AS registered_on FROM wp_users AS usr, wp_usermeta AS usm WHERE usr.ID = 'usm.user_id' AND (usm.meta_key = 'order' and usm.meta_value = 'process') group by usr.ID");
     $data = array();
	foreach ($sql as $cus)
	{
		$data[] = $cus;
		$data++;
	}
return $data;

}
?>

<?php the_post();

    global $user_ID;

?>
					<div class="homepage">	
						<?php the_title(); ?>	
						<a href="<?php bloginfo('url'); ?>/home-page" class="main_link">Home</a>	
					</div>
					<div class="scrool">		
						<div class="order_in">					
							<div class="man_color">						
						
								<div class="man_indiv man_indiv3 font_in">customer name</div>
								<div class="man_indiv man_indiv3 font_in">Website</div>
								<div class="man_indiv man_indiv3 font_in">Questionnaire</div>
								<div class="man_indiv man_indiv3 font_in">Order date/time</div>
								<div class="man_indiv man_indiv3 font_in">registered on</div>
							</div>					 

							<?php	

					 		 		$orders = order_to_process();

									if($orders != null) 
									{
										$i=1;	
										foreach($orders as $arr)	
										{ 
											if($i==1)	
												
											 {  
													  
											?>	
											<div class="man_color2">				
												<div class="man_order">			
													<div class="man_indiv">
														<?php echo $arr->display_name; ?>
													</div>
												<div class="man_indiv">Adoption</div>						
												<div class="man_indiv">
													<a href="<?php echo get_option('home'); ?>/questionnaire-admin/?usrid=<?php echo $arr->ID; ?>">Questionnaire</a>
												</div>					
												<div class="man_indiv">
													<?php echo get_user_meta( $arr->ID, "order_date", true ); ?>
												</div>					
												<div class="man_indiv">
													<?php echo $arr->	user_registered ?>
												</div>		
												<ul>
												</div>			
											</div>	

											 <?php 	}else{	
													  $i=0;	
											   ?>	
												<div class="man_color3">	
													<div class="man_order">	
													<div class="man_indiv"><?php echo $arr->display_name; ?></div>
													<div class="man_indiv">Adoption</div>
													<div class="man_indiv">
														<a href="<?php echo get_option('home'); ?>/questionnaire-admin/?usrid=<?php echo $arr->ID; ?>">Questionnaire</a>
													</div>
													<div class="man_indiv"><?php echo get_user_meta( $arr->ID, "order_date", true ); ?>
														
													</div>
													<div class="man_indiv"><?php echo $arr->user_registered ?></div>	
													<ul>	
													</div>	
												</div>		
												<?php  }
											$i++; 
										} 
									} 
									?>	
							</div>
					 	</div>	

 
 </div> 
 </div> 
 </div>
 </div>	
 <style>
.container {  
float: none!important;  
}
.result_table {
border: 1px solid #cccccc;
} 
.result_table td {
padding: 5px;
}
</style>
 </body>
</html>
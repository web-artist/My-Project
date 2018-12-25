<?php 	
/*
   Template Name: Report Search Template
*/
//die("++++");

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
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href="<?php echo get_stylesheet_directory_uri() ; ?>/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri() ; ?>/admin/css/fonts.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri() ; ?>/admin/css/font-awesome.css" rel="stylesheet">    
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri() ; ?>/admin/css/animation.css" media="all" rel="stylesheet" type="text/css">	
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/admin/js/jquery-1.11.1.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri() ; ?>/admin/js/bootstrap.min.js"></script>
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
<link href="<?php echo get_stylesheet_directory_uri() ; ?>/admin/css/style.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri() ; ?>/admin/css/responsive.css" rel="stylesheet"> 
</head>
<body>
<div class="container">
<div class="in_body">
<div class="row">
<div class="col-md-12">

<?php
if(isset($_REQUEST["hdnReport"]))
{
 if($_REQUEST["hdnReport"] == "search")
 {
	if(isset($_REQUEST["state"]))
	{
		$state = $_REQUEST["state"];
	}   
	if(isset($_REQUEST["city"]))
	{
		$city = $_REQUEST["city"];
	}   
    if(isset($_REQUEST["source"]))
	{
		$source = $_REQUEST["source"];
	}
	 if(isset($_REQUEST["website"]))
	{
		$website = $_REQUEST["website"];
	}
	 if(isset($_REQUEST["sales"]))
	{
		 $sales = $_REQUEST["sales"];
	}
	 if(isset($_REQUEST["non_sales"]))
	{
		$non_sales = $_REQUEST["non_sales"];
	}     
	if(isset($_REQUEST["ADsource"]))
	{
		$ADsource = $_REQUEST["ADsource"];
	}
   
  
function customer_order()
{
    $date_frm = $_REQUEST["date_frm"];
    $date_to = $_REQUEST["date_to"];
    global $wpdb;
    $table_name = $wpdb->prefix . 'users';    
     $sql = $wpdb->get_results("SELECT * FROM $table_name WHERE user_registered BETWEEN '$date_frm' AND '$date_to'");       
	return $sql;
}

}
}
 ?>
			<div class="homepage">
				Report Search Page<a href="<?php bloginfo('url'); ?>/home-page" class="main_link">Home</a>
			</div>
			<div class="scrool">
				<div class="order_in">
					<div class="man_color">						
							
							<?php if(isset($_REQUEST["state"])){?>
							<div class="man_indiv man_indiv2 font_in">State</div>
							<?php }?>
							<div class="man_indiv man_indiv2 font_in">Customer Name</div>
							<div class="man_indiv man_indiv2 font_in">Website</div>
							<div class="man_indiv man_indiv2 font_in">link</div>
							
					</div>
					 <?php
					   $customersupport = customer_order();
					   

					   if(count($customersupport)>0){
					  ?>
	 
					 <?php	
						$i=1;	 
					   foreach($customersupport as $CSval)
					   {
						   
					  ?>
						<div class="man_color2">
						  					
							<div class="man_order">
								<?php if(isset($_REQUEST["state"])){?>
								<div class="man_indiv man_indiv2"><?php echo get_user_meta( $CSval->ID, "state", true );?>	</div>
								<?php }?>
								<div class="man_indiv man_indiv2"><?php echo $CSval->display_name; ?></div>
								<div class="man_indiv man_indiv2">Adoption</div>
								<div class="man_indiv man_indiv2"><a href="<?php echo get_option('home'); ?>/customer-report/?usrid=<?php echo $CSval->ID; ?>">Questionnaire</a></div>
							
							</div>
						</div>
					 <?php 					 
					 $i++;
					 }
					}else{ ?>
					<div class="man_color2">						
							<div class="man_order"><strong>No Records Found</strong></div>
					</div>
					<?php }?>
					
				
				</div>	
			</div>			

 
 </div> </div> </div></div>	
 
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
<?php if(isset($_REQUEST["state"])){
?>
<style>
.man_indiv.man_indiv2 {width: 24%;}

</style>
<?php } ?>
</body>
</html>
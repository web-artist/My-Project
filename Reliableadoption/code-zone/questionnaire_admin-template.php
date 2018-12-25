<?php	 		 	
/*
<?php	 		 	
/*
Template Name: Admin Questionnaire Template
*/
if(isset($_REQUEST["status"]))
{
    if($_REQUEST["status"] == "done")
    {
	$userID = $_REQUEST["usrid"];
	update_usermeta( $userID, order, 'done');
	
	$date = current_time('mysql');	
	$order_completed = get_user_meta( $userid, "order_completed", true );
	if($order_completed == " ")
	{
		add_user_meta($userID, order_completed, $date);
	}
	else
	{
		update_user_meta($userID, order_completed, $date);
	}
	
	echo "<script>window.location='".get_option('home')."/home-page/'</script>";
    }
}

$userID = $_REQUEST["usrid"];   
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
				<div class="homepage 123">
					<?php the_title(); ?><a href="<?php bloginfo('url'); ?>/home-page" class="main_link">Home</a>
				</div>


				<div class="main_box">
				 <div class="tabin">
				  <div class="tabin1">
				   <div class="s_order">
							<a href="<?php bloginfo('url');?>/order-submission/?usrid=<?php echo $_REQUEST["usrid"]; ?>">Manually Submit Order</a>
					</div>
				  </div>
				  <div class="tabin1">
					<div class="s_order">
						<a href="<?php bloginfo('url');?>/questionnaire-edit-admin/?fid=<?php echo $_REQUEST["fid"]; ?>&usrid=<?php echo $_REQUEST["usrid"]; ?>">Edit Questionnaire</a>
					</div>
				  </div>
				  
				  <div class="tabin1">
					<div class="s_order">
							<a href="<?php bloginfo('url');?>/questionnaire-admin/?usrid=<?php echo $_REQUEST["usrid"]; ?>&status=done" onclick='if(!confirm("Are you sure you want to mark this as \"Done\"? This cannot be undone.")){ return false; }'>Done</a>
					</div>
				  </div>
				 </div>
				 
				<div class="varent_in">
					<div id="tabs">
						<div class="varent_1">
					
							<ul>
								<?php	 		 	 
		   
								$res = $wpdb->get_results("SELECT * FROM wp_rg_form");
								foreach ( $res as $arr )
							   
								{?>
		  
								<li>
									<a href="#tabs-<?php echo $arr->id; ?>"><?php echo ucwords(strtolower($arr->title)); ?></a>
								</li>
		  
		  
								<?php } ?>
								
							
							</ul>
						</div>
					
						<div class="varent2">
							<?php	 		 	 						
							$res1 = $wpdb->get_results("SELECT * FROM wp_rg_form");
							foreach ( $res1 as $arr1 )						
							{	
							?>
	  
	 
							<div id="tabs-<?php echo $arr1->id; ?>">
								<div class="tabsin_txt">
								 <?php	 		 	 
									$fid = $arr1->id;
									 $table_name = $wpdb->prefix . 'rg_lead';
									 $restt = $wpdb->get_results("SELECT id FROM $table_name where form_id = {$fid} and created_by = {$userID}"); 
									 $total_result_rowss = $wpdb->num_rows;	  
									$first = true;
									if($restt != null && $total_result_rowss > 0) {
										 foreach ( $restt as $arr12 )								
										 {	  
											if(!$first)		
												echo "<hr style='width:90%;' />";	  
											else	    
												$first = false;
												$leadid = $arr12->id;
												ShowResponses($fid, $leadid);
										 }
										} 
										else 
										{
											ShowResponses($fid, 0);
										}?>
								</div>
							</div>
	  
							<?php } ?>
													
					
						</div>
				 </div>
			</div>
				 
				 				 
		</div>
  
 
  
   
   
<?php			 	 
    
	
	function ShowResponses($fid, $leadid) {
		$form = RGFormsModel::get_form_meta($fid);
		if($form != null)
		{
		$i=1;
		
			foreach($form["fields"] as $field) {
			
				echo '<div class="tab_q">
						   <h3>';
						  
				echo $field["label"]."</h3>";
				
				if($leadid !== 0) {
					
                      global $wpdb;
 
 	                $table_name = $wpdb->prefix . 'rg_lead_detail';
 
 	               $resut = $wpdb->get_results( "SELECT * FROM $table_name WHERE form_id = {$fid} AND lead_id = {$leadid} and field_number = {$field["id"]} ORDER BY field_number");
                   $total_reslt_rows = $wpdb->num_rows; 	               

					if($total_reslt_rows > 0){
						
						echo "<span>".$resut[0]->value . "</span>";
					}
				}
			
				echo '</div>';
					
				$i++;
			}
		}
	}
	
?>
  
 
 
 </div>
 </div>
 </div>
 </div>
 
<style>

.container {
    float: none!important;   
}
.gform_wrapper .gform_footer input.button, .gform_wrapper .gform_footer input[type="submit"] {
    width: 100px;
    height: 25px;
}
</style>
<script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
</script>

</body>
</html>
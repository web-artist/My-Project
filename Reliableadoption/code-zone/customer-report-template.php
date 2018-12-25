<?php 
/*
	Template Name: Customer Report Template
*/
if(isset($_REQUEST["usrid"])){
 $userid = $_REQUEST["usrid"];
 $user_info = get_userdata( $userid );
}
 if(isset($_REQUEST["marketing"]))
 {
	 global $wpdb;

	 $table_name = $wpdb->prefix . 'marketing';
	 
	 $userid = $_REQUEST["usrid"];
	
	 for($i=1; $i<5; $i++)
	  {
		 $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE usr_id = $userid and status = $i");
		
		 $cntrow = $wpdb->num_rows;		
		 
		 if ($cntrow > 0 )
		{
		  
			if($_REQUEST["datecal".$i] != "")
			{
			  $dcall = $_REQUEST["datecal".$i];
			  $notes = $_REQUEST["notes".$i];
			  $ndcall = $_REQUEST["nxcldate".$i];
			  
			  //$wpdb->query($wpdb->prepare("UPDATE $table_name SET d_call='$dcall', notes='$notes', n_d_call='$ndcall' WHERE usr_id=$userid and status=$i"));
			  
			  $wpdb->update( 
					$table_name, 
					array( 
						'd_call' => $dcall,	
						'notes' => $notes	,
						'n_d_call' => $ndcall	,
					), 
					array( 
					'usr_id' => $userid ,
					'status' => $i 
					) 										
				);
					
			}
		}
		else
		{
			
			if($_REQUEST["datecal".$i] != "")
			{
			 
			  $dcall = $_REQUEST["datecal".$i];
			  $notes = $_REQUEST["notes".$i];
			  $ndcall = $_REQUEST["nxcldate".$i];
			  
			  $wpdb->insert( $table_name, array(
				'usr_id' => $userid,
				'd_call' => $dcall,
				'notes' => $notes,
				'n_d_call' => $ndcall,
				'status' => $i,
				) );
			
			}
	  
		 }
	   }
		
 }
 if(isset($_REQUEST["production"]))
 {
    if($_REQUEST["production"] != "")
    {
      $userid = $_REQUEST["usrid"];
      $production = $_REQUEST["production"];
      
	 global $wpdb;

	 $table_name = $wpdb->prefix . 'production';
		
	 $results = $wpdb->get_var("SELECT * FROM $table_name WHERE usr_id = $userid");
	 
	 $cntrow= $wpdb->num_rows;
		
      if ($cntrow > 0 )
      {
		$wpdb->query($wpdb->prepare("UPDATE $table_name SET notes='$production' WHERE usr_id=$userid"));
      }else{
		$wpdb->insert( $table_name, array(
			'usr_id' => $userid,
			'notes' => $production,
			'status' => '1'
			) );
      }
	  
    }
 }
 function marketing_notes($status)
 {	
    global $wpdb;

	 $table_name = $wpdb->prefix . 'marketing';
	 
	 $userid = $_REQUEST["usrid"];
		
	 $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE usr_id = $userid and status = $status");
	 
	 $cntrow= $wpdb->num_rows;
	 
		if ($cntrow > 0 )
		{
		  return $results;
		}else{
		  return 0;
		}
 }
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
	<div class="homepage">
					<?php the_title(); ?><a href="<?php bloginfo('url'); ?>/home-page" class="main_link">Home</a>
				</div>

		<div class="customerbox" style="width:100%;float:left;">
						<div class="customerbox1" id="section1_customerbox1">
							<h1 class="list_costem">Customer Information</h1>
							<div class="man_in">
								<label class="info">Customer Name:</label>
								<p class="info_e"><a href="#"><?php echo $user_info->display_name; ?></a></p>
							</div>
							<div class="man_in">
								<label class="info">Customer Email:</label>
								<p class="info_e"><a href="#"><?php echo $user_info->user_email; ?></a></p>
							</div>
							<div class="man_in">
								<label class="info">Petitioner State:</label>
								<p class="info"><?php echo get_user_meta( $userid, "state", true ); ?></p>
							</div>
							<div class="man_in">
								<label class="info">Number of Children:</label>
								<p class="info"><?php echo get_user_meta( $user_ID, "children", true );?></p>
							</div>
							<div class="order">
							<a href="<?php bloginfo('url');?>/questionnaire-admin/?usrid=<?php echo $_REQUEST["usrid"]; ?>">ORDERS</a>
						</div>
						</div>
						
						<div class="customerbox2" id="section1_customerbox2">
						<h1 class="list_costem">Order Status: <?php	echo get_user_meta( $userid, "order", true ); ?></h1>
						<div class="man_in">
							<label class="info">Website Company:</label>
							<p class="info">Stepparent Adoption Forms</p>
						</div>
						<div class="man_in">
							<label class="info">Signed up on:</label>
							<p class="info"><?php echo substr(get_userdata( $userid )->user_registered, 0, 10); ?></p>
						</div>
						<div class="man_in">
							<label class="info">Order Paid on:</label>
							<p class="info"><?php echo substr(get_user_meta( $userid, "order_date", true ), 0, 10); ?></p>
						</div>
						<div class="man_in">
							<label class="info">Order completed on</label>
							<p class="info"><?php echo get_user_meta( $userid, "order_completed", true ); ?></p>
						</div>
						<div class="man_in">
							<label class="info">Documents mailed on:</label>
							<p class="info">N/A</p>
						</div>
						<div class="man_in">
							<label class="info">Still owes balance of: </label>
							<p class="info">$<?php echo get_user_meta( $userid, "amount", true ); ?></p>
						</div>
							<div class="order order2">
							<a href="<?php bloginfo("url"); ?>/order-submission/?usrid=<?php echo $_REQUEST["usrid"]; ?>">add payment</a>
						</div>
						</div>
						</div>	



 
	<div class="customerbox" style="width:100%;float:left;">
						<div class="customerbox1" id="section2_customerbox1">
							<h1 class="list_costem">Production Notes/Changes</h1>
							 <form name="product_form" method="post" action="">
								<input type="hidden" name="hidd_prdt" value="add">
								<div class="save">
									<textarea name="production">									 
										<?php	 	
												global $wpdb;
										
												$table_name = $wpdb->prefix . 'production';
												
												$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE usr_id = $userid");
												
												foreach($results as $value)
												{
													echo $value->notes;
												}
										?>
									  </textarea>
								</div>
								<div class="order">
							
							<input type="submit" name="submit" value="save" alt="" border="0" />
						</div>
						</form>
						</div>
						<div class="customerbox2" id="section2_customerbox2">
						<h1 class="list_costem">Automatic Emails</h1>
							<div class="emal">
							<ul>
								<li>Automatic customer login Email sent: <?php echo substr(get_user_meta( $userid, "order_date", true ), 0, 10); ?></li>
								<li>First automatic sales email sent: <?php echo substr(get_user_meta( $userid, "order_date", true ), 0, 10); ?></li>
								<li>Second automatic sales email sent: N/A</li>
								<li>First automatic discunt email sent: $<?php echo get_user_meta( $userid, "amount", true ); ?></li>
							</ul>
							<div class="stop_email">
								<input type="checkbox"><p>Stop All Marketing Emails</p>
							</div>
							</div>
							<div class="order">
							<a href="#">save</a>
						</div>
					</div>
						
						<div class="customerbox1 box_xustom2">
						<h1 class="list_costem">Automatic Emails</h1>
						</div>
						<form name="marketing" method="post" action="">
							<input type="hidden" name="marketing" id="marketing" value="add">

						<div class="newbox2">
						 <?php	 $data1 = marketing_notes(1);
						
							if( $data1 > 0 )
							{?>
								<div class="customerbox1 box_n">
									<div class="calldate">
										<label>Date Called: </label>
											<input  type="text" name="datecal1" value="<?php echo $data1[0]->d_call; ?>">
									</div>
									<div class="calldate">	
										<label>Next Call Date:	</label>							
										<input type="text" name="nxcldate1" value="<?php echo $data1[0]->n_d_call; ?>">
										
									</div>
									<label>Notes:</label>
										<textarea name="notes1" class="call_text" ><?php echo $data1[0]->notes; ?></textarea>
									
								</div>
							 <?php	}else{  ?>
								 
								<div class="customerbox1 box_n">
									<div class="calldate">
										<label>Date Called : </label>
										<input  type="text" name="datecal1" value="">
									</div>
									<div class="calldate">
										<label>Next Call Date:</label>
										<input type="text" name="nxcldate1" value="">
									</div>
									<label>Notes:</label>
									<textarea name="notes1" class="call_text"></textarea>
								
								</div>
								 <?php	 	 } ?>
								 <?php $data2 = marketing_notes(2);
								
									if( $data2 > 0 )
									{ ?>
								<div class="customerbox1 box_n">
									<div class="calldate">
										<label>Date Called: </label>
											<input  type="text" name="datecal2" value="<?php echo $data2[0]->d_call; ?>">
									</div>
									<div class="calldate">	
										<label>Next Call Date:	</label>							
										<input type="text" name="nxcldate2" value="<?php echo $data2[0]->n_d_call; ?>">
										
									</div>
									<label>Notes:</label>
										<textarea name="notes2" class="call_text"><?php echo $data2[0]->notes; ?></textarea>
									
								</div>
								
								  <?php	 	 }else{  ?>
									<div class="customerbox1 box_n">
									<div class="calldate">
										<label>Date Calledgh: </label>
										<input type="text" name="datecal2" value="">
									</div>
									<div class="calldate">
										<label>Next Call Date:</label>
										<input type="text" name="nxcldate2" value="">
									</div>
									<label>Notes:</label>
									<textarea name="notes2" class="call_text"></textarea>
								
								</div>
								 <?php	 	 } ?>
								
							</div>
								
						
						<div class="newbox1">
						
								 <?php	$data3 = marketing_notes(3);
									if( $data3 > 0 )
									{?>
								
								
								<div class="customerbox1 box_n">
									<div class="calldate">
										<label>Date Called: </label>
											<input  type="text" name="datecal3" value="<?php echo $data3[0]->d_call; ?>">
									</div>
									<div class="calldate">	
										<label>Next Call Date:	</label>							
										<input type="text" name="nxcldate3" value="<?php echo $data3[0]->n_d_call; ?>">
										
									</div>
									<label>Notes:</label>
										<textarea name="notes3" class="call_text"><?php echo $data3[0]->notes; ?></textarea>
									
								</div>
								<?php	}else{  ?>	

								<div class="customerbox1 box_n">
									<div class="calldate">
										<label>Date Called: </label>
										<input type="text" name="datecal3" value="">
									</div>
									<div class="calldate">
										<label>Next Call Date: </label>
										<input type="text" name="nxcldate3" value="">
									</div>
									<label>Notes:</label>
									<textarea name="notes3" class="call_text"></textarea>
								
								</div>

				 
							  <?php	 	 }?>

							  <?php	$data4 = marketing_notes(4);
								if( $data4 > 0 )
								{?>
								
								<div class="customerbox1 box_n">
									<div class="calldate">
										<label>Date Called: </label>
											<input  type="text" name="datecal4" value="<?php echo $data4[0]->d_call; ?>">
									</div>
									<div class="calldate">	
										<label>Next Call Date:	</label>							
										<input type="text" name="nxcldate4" value="<?php echo $data4[0]->n_d_call; ?>">
										
									</div>
									<label>Notes:</label>
										<textarea name="notes4" class="call_text"><?php echo $data4[0]->notes; ?></textarea>
									
								</div>
								
								   <?php	 	 }else{  ?>
								   <div class="customerbox1 box_n">
									<div class="calldate">
										<label>Date Called: </label>
										<input type="text" name="datecal4" value="">
									</div>
									<div class="calldate">
										<label>Next Call Date:</label>
										<input type="text" name="nxcldate4" value="">
									</div>
									<label>Notes:</label>
									<textarea name="notes4" class="call_text"></textarea>
								
								</div>
								   
								    <?php	 	 }?>
								   
						</div>
							<div class="order sav_n">
							
							<input type="submit" name="submit" value="save" alt="" border="0" />
						</div>
						</form>
					</div>
 
 
 </div>
 </div>
 </div> </div>
 <style>
.container {
    float: none!important;   
}

</style>
</body>
</html>

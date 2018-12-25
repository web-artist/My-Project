<?php 
/*
Template Name: Admin Questionnaire Edit Template

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
	
<?php 
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

if(isset($_REQUEST["createlead"])) {
	$sql = $wpdb->query("
		INSERT INTO wp_rg_lead (
			form_id,
			post_id,
			date_created,
			is_starred,
			is_read,
			ip,
			source_url,
			user_agent,
			currency,
			payment_status,
			payment_date,
			payment_amount,
			transaction_id,
			is_fulfilled,
			created_by,
			transaction_type,
			status
		) VALUES (
			" . mysql_escape_string($_REQUEST['fid']) . ",
			0,
			now(),
			0,
			0,
			'" . $REMOTE_ADDR . "',
			'" . curPageURL() . "',
			'',
			'USD',
			null,
			null,
			null,
			null,
			null,
			" . mysql_escape_string($_REQUEST['usrid']) . ",
			null,
			'active'
		);
	");
	
}


$userID = $_REQUEST["usrid"];

?>
				<div class="homepage">
					Edit Questionnaire<a href="<?php bloginfo('url'); ?>/home-page" class="main_link">Home</a>
				</div>
				<div class="main_box">
				 <div class="tabin">
					  <div class="tabin1">
						 <div class="s_order">
								<a href="<?php  bloginfo('url');?>/order-submission/?usrid=<?php  echo $_REQUEST["usrid"]; ?>">Manually Submit Order</a>
						  </div>
					  </div>
					  <div class="tabin1">
						 <div class="s_order">
								<a href="<?php bloginfo('url');?>/questionnaire-admin/?usrid=<?php echo $_REQUEST["usrid"]; ?>">Edit Questionnaire</a>
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
								
								 global $wpdb;
							 
								 $table_name = $wpdb->prefix . 'rg_lead';
							 
								 $results = $wpdb->get_var( "SELECT id FROM $table_name where created_by = {$userID}");
								
								 $total_result_rows = $wpdb->num_rows;


								 if($results>0){

								 ?>
							
								 <?php 
								
								 $res = $wpdb->get_results("SELECT * FROM wp_rg_form");
								 foreach ( $res as $arr ) 
								 
								  {

								 ?>	
	
	
								<li>
									<a href="#tabs-<?php  echo $arr->id; ?>"><?php  echo ucwords(strtolower($arr->title)); ?></a>
								</li>
								<?php  } ?>

							 
							    <?php  } ?>   
														
						
						
							</ul>
							</div>
					
						<div class="varent2">


					<?php 
                    global $wpdb; 
				 	$table_name = $wpdb->prefix . 'rg_lead';				 
				 	$results1 = $wpdb->get_var( "SELECT id FROM $table_name where created_by = {$userID}");		 
					$total_res_rows = $wpdb->num_rows;

					if($total_res_rows > 0){

				     ?>
						
					<?php  

					 $res = $wpdb->get_results("SELECT * FROM wp_rg_form");
					 foreach ( $res as $arr ) 

					{

					?>	
						<div id="tabs-<?php  echo $arr->id; ?>">
						  <div class="tabsin_txt">
							<?php   

							$fid = $arr->id;
							
						    global $wpdb; 
							$table_name = $wpdb->prefix . 'rg_lead';				 
							$qry = $wpdb->get_results( "SELECT id FROM $table_name where form_id = {$fid} and created_by = {$userID} ");
							   $total_result_rows = $wpdb->num_rows;
													  
							$first = true;
							if($total_result_rows > 0) {
								
								foreach ( $qry as $obj )
								{
									
									$leadid = $obj->id;
								
									if($leadid != ""){
				
									$form = RGFormsModel::get_form_meta($fid);
									$lead = RGFormsModel::get_lead($leadid);
									if(isset($_REQUEST["action"]))
									{
										if($_REQUEST["edit_lead_id"] == $leadid) {
											check_admin_referer('gforms_save_entry', 'gforms_save_entry');

											RGFormsModel::save_lead($form, $lead);

											$lead = RGFormsModel::get_lead($leadid);					
										}
									}
										lead_detail_edit($form, $lead, $leadid);
									}
								}
								if($fid == 13) {
									?>
									<div style="text-align:right; width:800px;" class="create_lead">
									<form action="" method="POST">
										<input type='hidden' name='createlead' value='yes' />
										<input type='submit' value="Create Lead Entry" />
									</form>
									</div>
									<?php
								}
								}else{
								?>
										<div style="text-align:right; width:800px;" class="create_lead">
										<form action="" method="POST">
											<input type='hidden' name='createlead' value='yes' />
											<input type='submit' value="Create Lead Entry" />
										</form>
										</div>
									<?php
									
								}
							 ?>
						  </div>
						 </div>
					  <?php  } ?>

 
  <?php  } ?>   
				
						 </div>						
						</div>						
					</div>
		 </div>

<?php  

	function lead_detail_edit($form, $lead, $leadid){

        $form = apply_filters("gform_admin_pre_render_" . $form["id"], apply_filters("gform_admin_pre_render", $form));

        ?>

        <form method="post" id="entry_form" enctype='multipart/form-data'>

            <?php  wp_nonce_field('gforms_save_entry', 'gforms_save_entry') ?>

            <input type="hidden" name="action" id="action" value=""/>

            <input type="hidden" name="screen_mode" id="screen_mode" value="edit" />
			
			<input type="hidden" name="edit_lead_id" id="edit_lead_id" value="<?php echo $leadid ?>" />
			<ul>
        

                    <?php 
					$i=1;
                    foreach($form["fields"] as $field){

                        switch(RGFormsModel::get_input_type($field)){

                            case "section" :

                                ?>
					<li class="first_li"><?php  echo esc_html(GFCommon::get_label($field))?></li>
					<li style="height:0;clear:both"></li>
                    <?php

                            break;

                            case "captcha":

                            case "html":

                            case "password":
                               
                            break;

                            default :

                                $value = RGFormsModel::get_lead_field_value($lead, $field);

                                $content = "<li id='li_".$i."'><label>" . esc_html(GFCommon::get_label($field)) . "</label>" .

                            GFCommon::get_field_input($field, $value, $lead["id"]) . "</li>";

                            $content = apply_filters("gform_field_content", $content, $field, $value, $lead["id"], $form["id"]);

							echo $content;

                            break;

                        }
						$i++;

                    }

                    ?>
			</ul>
                   
		
			<div class="update_btn">

			<?php	

				$button_text = "entry" == "view" ? __("Edit Entry", "gravityforms") : __("Update Entry", "gravityforms");

				$button_click = "entry" == "view" ? "jQuery('#screen_mode').val('edit');" : "jQuery('#action').val('update'); jQuery('#screen_mode').val('view');";

				$update_button = '<input class="button-primary" type="submit" tabindex="4" value="' . $button_text . '" name="save" onclick="' . $button_click . '"/>';

				echo apply_filters("gform_entrydetail_update_button", $update_button);

			?>

		  </div>
	  </form>

<?php

    }

	
 ?>
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
<script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
</script>
</body>
</html>
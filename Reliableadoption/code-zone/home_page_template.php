<?php	 		 	
/*
<?php	 		 	
/*
Template Name: Home Page Template
*/



if(isset($_REQUEST["status"]))
{
    if($_REQUEST["status"] == "delete")
    {
	$userID = $_REQUEST["usrid"];
	update_usermeta( $userID, order, 'delete');
	
	echo "<script>window.location='".get_option('home')."/home-page/'</script>";
    }
}
if(isset($_REQUEST["mailing"]))
{
    if($_REQUEST["mailing"] == "complete")
    {
	$userID = $_REQUEST["usrid"];
	update_usermeta( $userID, mailing, 'complete');
	
	echo "<script>window.location='".get_option('home')."/home-page/'</script>";
    }
}

?>

<?php 
function new_customer_count_since_midnight() {
       global $wpdb;
       $args = array(
      'date_query' => array( 
        array( 'after' => '7 hours ago', 'inclusive' => true )       
			)
		);

$users_count=  count( get_users($args));    
return $users_count;

}



function new_customer_count_last_24() {
	$args = array(
      'date_query' => array( 
        array( 'after' => '24 hours ago', 'inclusive' => true )  
			)
		);
$users_count=  count( get_users($args));    
   return $users_count;
}


function order_count_since_midnight() {
	
	$cur_date = current_time('Y-m-d');
	 
	 $args = array(
    'meta_key'     => 'order_date',
	'meta_value'   => $cur_date,
		);
   
   $users_count=  count( get_users($args));    
   return $users_count;
   
}
function customer_order()
{

	global $wpdb; 
	$table_name = $wpdb->prefix . "usermeta";				 
	//$sql45 = $wpdb->get_results("SELECT * FROM $table_name AS usr, wp_usermeta AS usm WHERE usr.ID = 'usm.user_id' AND (usm.meta_key = 'order' and usm.meta_value != 'delete' and usm.meta_value != 'done') group by usr.ID");	

	$results = $wpdb->get_results("SELECT * FROM $table_name WHERE meta_key = 'order' and meta_value='process'");	
	
	foreach ($results as $val) {
	  $data[] = $val->user_id; 
	}
	if(isset($data))
	{
	 return $data;
	}

}
function collections_order()
{
   
   global $wpdb; 
	$table_name = $wpdb->prefix . 'users';				 
	$sql = $wpdb->get_results("SELECT * FROM $table_name AS usr, wp_usermeta AS usm WHERE usr.ID = 'usm.user_id' AND (usm.meta_key = 'order' and usm.meta_value = 'done') group by usr.ID");				 	   
	foreach ($sql as $cus) {
		$data[] = $cus;
		 $data++;
	}
	 if(isset($data))
	{
	 return $data;
	}

}

function process_order($status)
{
   
    $args = array(
    'meta_key'     => 'order',
	'meta_value'   => 'process',
		);
$query = count(get_users($args ));
return $query;

}


function process_order1($status){ 

$start_date = date('Y-m-01') ."<br>";
$end_date= date('Y-m-t') ."<br>";
  
$date1 = str_replace('-', '/', $end_date);
$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
   $args = array(
   		
      'meta_query' => array( 
   array( 'relation' => 'AND',  
   array( 'key' => 'order_completed',
   'value' => array($start_date,$tomorrow),
   'compare' => 'BETWEEN'
   ),    
	array('key' => 'order',
	'value' => 'done',
	'compare' => '='
	)
   )
   ));

$users_count=  count( get_users($args));
return $users_count;


}

function mailing_customer()
{
	global $wpdb; 
	$table_name = $wpdb->prefix . 'users';				 
	$sql = $wpdb->get_results('SELECT usr.* FROM $table_name AS usr, wp_usermeta AS usm where usr.ID = "usm.user_id" AND (usm.meta_key = "mailing" and usm.meta_value != "complete") group by usr.ID');
	$cntrow_st= $wpdb->num_rows;
    if($cntrow_st > 0 )
    {
		foreach ($sql as $cus) {
			$data[] = $cus;
		}
		 if(isset($data))
		{
		 return $data;
		}
    }
}
?>

<?php the_post();

    global $user_ID;  

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
				<div class="homepage">
					<?php the_title(); ?><a href="<?php bloginfo('url'); ?>/home-page" class="main_link">Home</a>
				</div>
				<div class="customerbox">
						<div class="customerbox1">
							<h1 class="list_costem">Customer/Registrations</h1>
							<ul>
								<li>Number of Registrations Today:  <a href=""><span><?php echo new_customer_count_since_midnight(); ?></span></a></li>
								<li>Number of Registrations in the last 24 hours:  <a href=""><span><?php echo new_customer_count_last_24(); ?></span></a></li>
								
							</ul>
						</div>
						
						<div class="customerbox2">
						<h1 class="list_costem"><a href="/admin-customer-list/">Customer List</a></h1>
						</div>
				</div>
				<div class="customerbox">
						<div class="customerbox1">
							<h1 class="list_costem">Order To Process</h1>
							<ul>
								<li>Number of orders to process: <span><?php echo process_order('process'); ?></span></li>
								<li>Number of orders placed today: <span><?php echo order_count_since_midnight(); ?></span></li>
								
							</ul>
							<div class="order">
								<a href="<?php echo get_option('home'); ?>/orders-to-process/">ORDERS</a>
							</div>
						</div>
						
						<div class="customerbox2">
							<h1 class="list_costem">Order Summary</h1>
							<ul>
								<li>Total Orders this month:<span> <?php echo process_order1('done'); ?></span></li>
							</ul>
						</div>
						<div class="customerbox">
							<div class="customerbox1" style="width:100%">
								<h1 class="list_costem">Adoptions to Enter</h1>
								<div class="coll">
									<div class="report border_in">
									
									<?php	 		 	

									$customersupport = customer_order();

									if($customersupport != null)

									{
										 
									foreach( $customersupport as $customer_details)
									{
									 
										$user_details = get_user_by('id' , $customer_details);
										if(isset($user_details) && $user_details !='')
										{

									?>
									<ul>
										<li style="width:36%"><?php echo $user_details->display_name; ?></li>
										<li style="width:18%">Adoption</li>
										<li style="width:32%"><a class="custom1"href="<?php echo get_option('home'); ?>/customer-report/?usrid=<?php echo $user_details->ID; ?>">customer report</a></li>
										<li style="width:10%"><a id="del" class="custom2"href="<?php echo get_option('home'); ?>/home-page/?usrid=<?php echo $user_details->ID; ?>&status=delete">DELETE</a></li>
									</ul>
									<?php } } }?> 
									
										
											
									
									</div>
								</div>
							</div>
						
						<div class="customerbox2" style="display:none">
						<h1 class="list_costem"><a href="#">Collections</a></h1>
							<div class="coll">
								 <?php	 		 	

									$collections = collections_order();

									foreach($collections as $Cval)

									{

									?>

								<?php } ?> 
							</div>
						</div>
						<div class="report">
							<h1 class="list_costem textaligne">Search For Customer</h1>
							  <form name="search" id="search" method="post" action="">
								<input type="hidden" name="hdnSearch" id="hdnSearch" value="search">
								<div class="search">
									<div class="label1">
										Search By :	
									</div>
									<div class="select1">
										<select name="by_s" >
											<option selected="selected" value="">Please Select</option>
												<option value="name">Name</option>
												<option value="email">Email</option>
										</select>
									</div>
									<div class="select2">
										<input type="text" name="by" />
									</div>
								</div>
							
								<div class="seacrc_btn">
								<input type="submit" name="submit" value="Search" />
								
								</div>
							</form>
							<div class="result">
								<h1>Results</h1>
								<div align="center" class="textarea" style="width: 100%;"><div class="frmtext_field" >
							 <?php
								if(isset($_REQUEST["hdnSearch"]))
								{
									if($_REQUEST["hdnSearch"] == "search")
									{
										
									$bys = $_REQUEST["by_s"];
									$by = $_REQUEST["by"];

									if($bys != ""){

									  $wp_user_search = $wpdb->get_results("SELECT * FROM $wpdb->users WHERE user_nicename = '".$by."' OR user_email='".$by."'");
									  ?>
									  
								  <table width="100%" border="0" cellpadding="4" cellspacing="0" class="result_table">
									
									<tr>               
										<td width="25%"><strong>Name</strong></td>
										<td width="20%"><strong>State</strong></td>
										<td width="25%"><strong>Email</strong></td>
										<td width="10%"><strong>Active</strong></td>
										<td></td>
									</tr>
										  
									   <?php foreach ( $wp_user_search as $userid ) 
										{
											?>
											<tr>
					  
												<td><?php echo $userid->user_nicename; ?></td>
												<td><?php echo get_user_meta( $userid->ID, "state", true );?></td>
												<td><?php echo $userid->user_email; ?></td>
												<td>
													<?php 
													
													global $wpdb;

													 $table_name = $wpdb->prefix . 'usermeta';
														
													 $results = $wpdb->get_var("SELECT * FROM $table_name WHERE meta_key = 'order' and user_id='$userid->ID'");
													 
													 $cntrow= $wpdb->num_rows; 
													 if($cntrow==0)
													 {
														echo "Active";
													 }
													  
													?>
												</td>
												<td>	
													<a href="/customer-report/?usrid=<?php echo $userid->ID ?>">Customer Report</a>
												</td>
											 </tr>

									<?php }
										}
                    
										
										echo "</table>";
									}
								}
							 ?>
         
						</div>
						</div>
						</div>
							
					</div>
						<div class="report">
							<h1 class="list_costem textaligne">Reports</h1>
							<h1 class="rapt">include in Report:</h1>
							<form name="report" id="report" method="post" action="<?php bloginfo('url'); ?>/report-search/">
							<input type="hidden" name="hdnReport" id="hdnReport" value="search">
							<div class="chack">
								<input type="checkbox" name="state" value="state" /><span>State</span>
							</div>
							
							<div class="chack">
								<input type="checkbox" name="city" value="city" /><span>City</span>
							</div>
							
							<div class="chack">
								<input type="checkbox" name="source" value="source" /><span>Ad source</span>
							</div>
							<div class="websitfild">
								<select name="website" >
									<option selected="selected" value="">Please Select</option>
									<option value="adoption">Adoption</option>
								</select>
								<span>Website Company</span>
							</div>
							
							<div class="date_in">
								<h1 class="rapt">Date Range:</h1>
								<span> From :</span><input type="text" name="date_frm" value="YYYY-MM-DD"  onclick="if(this.value == 'YYYY-MM-DD') this.value=''" /><span>to:</span><input type="text" name="date_to" value="YYYY-MM-DD"  onclick="if(this.value == 'YYYY-MM-DD') this.value=''" />
							</div>
							<div class="report">
							
							<h1 class="rapt">Type of Report:</h1>
							<div class="chack">
								<input type="checkbox" name="sales" value="sales" /><span>Sales</span>
							</div>
							
							<div class="chack">
								<input type="checkbox" name="non_sales" value="non_sale" /><span>Non-Sales</span>
							</div>
							
							<div class="chack">
								<input type="checkbox" name="ADsource" value="source" /><span>Ad source</span>
							</div>
							<div class="websitfild">
								<select name="" class="frmfield2a">
									<option selected="selected" value="">Please Select</option><option value="adoption">Adoption</option>
								</select>
								<span>Website Company</span>
							</div>
							<div class="report2">
							<input type="submit" name="submit" value="Run Report" alt="" border="0">
								
							</div>
						</div>
						</form>
						</div>
						
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

<?php	 		 	
/*
<?php	 		 	
/*
Template Name: Questionnaire Confirmation
*/
?>



<?php get_header();  ?>



<!--body start here-->



<div class="container">

<div id="banner">

<div class="banner-img10"><img src="<?php echo get_stylesheet_directory_uri() ; ?>/images/img8.jpg" alt="" /></div>

  <div class="banner-img9">

    <p><img src="<?php echo get_stylesheet_directory_uri() ; ?>/images/img9.jpg" /></p>



	<br />



	<p><img src="<?php echo get_stylesheet_directory_uri() ; ?>/images/img10.jpg" /></p> 



  </div>



	</div>





  <div class="questionnaire">

	<h3>Payment Confirmation</h3>

<?php	 		 	

// $post_url = "https://test.authorize.net/gateway/transact.dll";
$post_url = "https://secure.authorize.net/gateway/transact.dll";


$c_num = $_REQUEST["x_card_num"];

$e_date = $_REQUEST["x_exp_month"]."".$_REQUEST["x_exp_year"];

$f_name = $_REQUEST["x_first_name"];

$l_name = $_REQUEST["x_last_name"];

$address = $_REQUEST["x_address"];

$city = $_REQUEST["x_city"];

$state = $_REQUEST["x_state"];

$zip = $_REQUEST["x_zip"];

$phone = $_REQUEST["x_phone"];



if($_REQUEST["Fmail"] != ""){

  $shipping .= "Free";

}

if($_REQUEST["Pmail"] != ""){

  $shipping .= ",Priority";

}

if($_REQUEST["Rmail"] != ""){

  $shipping .= ",Regular";

}

if($_REQUEST["Email"] != ""){

  $shipping .= ",Express";

}



$amount = $_REQUEST["x_hdn_amount"];



$post_values = array(

	
	//Reliable
	//"x_login"		=> "8CqGnBTc8a5a",
    //Stepparentadoptionforms
    "x_login"      =>"7qx9Th8MK8",


    //Reliable
	//"x_tran_key"		=> "7f7VkPF38a8s4u8b",
    //Stepparentadoptionforms
    "x_tran_key"        => "8X7C6nt69kq2t9Ng",

	"x_version"		=> "3.1",

	"x_delim_data"		=> "TRUE",

	"x_delim_char"		=> "|",

	"x_relay_response"	=> "FALSE",



	"x_type"		=> "AUTH_CAPTURE",

	"x_method"		=> "CC",

	"x_card_num"		=> "{$c_num}",

	"x_exp_date"		=> "{$e_date}",



	"x_amount"		=> "{$amount}",

	"x_description"		=> "Reliable Adoption Forms Submission",



	"x_first_name"		=> "{$f_name}",

	"x_last_name"		=> "{$l_name}",

	"x_address"		=> "{$address}",

	"x_city"		=> "{$city}",

	"x_state"		=> "{$state}",

	"x_zip"			=> "{$zip}",

	"x_phone"		=> "{$phone}",		"x_email"		=> get_userdata($user_ID)->user_login

	

);



$post_string = "";

foreach( $post_values as $key => $value )

	{ $post_string .= "$key=" . urlencode( $value ) . "&"; }

$post_string = rtrim( $post_string, "& " );



	$request = curl_init($post_url); // initiate curl object

	curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response

	curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)

	curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data

	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.

	$post_response = curl_exec($request); // execute curl post and store results in $post_response



curl_close ($request); 



$response_array = explode($post_values["x_delim_char"],$post_response);

$msg = "";


if($response_array[0] == 1)

{
		$date = current_time('Y-m-d');

        add_user_meta( $user_ID, amount, $amount);

        add_user_meta( $user_ID, order, 'process');

        add_user_meta( $user_ID, order_date, $date);

        add_user_meta( $user_ID, shipping_options, $shipping);

        add_user_meta( $user_ID, transaction_id, $response_array[6]);

	$msg = "Thanks for your payment!";
        
        ?>
<!-- Google Code for Reliable Adoption Checkout Complete Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1072368947;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "_a-ECLCxqAQQs5qs_wM";
var google_conversion_value = <?php echo $amount ?>;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1072368947/?value=<?php echo $amount ?>&amp;label=_a-ECLCxqAQQs5qs_wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Google code for analytics goal tracking -->
<script type="text/javascript">

	var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-3105747-3']);
    _gaq.push(['_trackPageview', '/questionnaire-payment-confirmation/neverhitthis-ajaxonly']);
    _gaq.push(['_trackEvent', 'AdoptionCart', 'Checkout', 'Success', <?php echo $amount ?>]);

</script>
<?php

}


if($response_array[0] != 1) {
	
   
    ?>
    <p>&nbsp;</p>
    Your transaction was unable to be completed due to the following reason:<br /><strong><?php echo $response_array[3]; ?></strong>
    <p>&nbsp;</p>
    <p>
    Click the button below to return to your checkout.<br />
    <button onclick="history.go(-1);" style="padding:5px;">Return to Checkout</button>
    </p>
<!--<?php echo $amount ?>-->
<?php
} else {

echo "<p>&nbsp;</p>";

echo "<p>&nbsp;</p>";

echo "<p>".$response_array[3]."&nbsp;&nbsp;{$msg}</p>";

echo "<p>&nbsp;</p>";

echo "<p>Transaction Id: ".$response_array[6]."</p>";

echo "<p>&nbsp;</p>";

echo "<p>&nbsp;</p>";
}


if($response_array[6] != '0')
{

    $to ="$user_email";
	$from = $user_email;
	$headers = "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .="From: \"$from\" <$from>\r\nReply-To: \"$from\" <$from>\r\nX-Mailer: PHP/".phpversion();
	$subject = "Reliable Adoption: Payment Confirmation";
	$message = "Dear $response_array[13],\r\n\n<br/><br/>";
    $message = $message ."Thanks for your payment!<br/><br/>";
	$message = $message ."".$response_array[3]." <br/><br/>";
    $message = $message ."<strong>User Details : </strong><br/><br/>";
	$message = $message ."<table><tr><td>First Name :</td><td>$response_array[13]</td></tr>";
	$message = $message ."<tr><td>Last Name :</td><td>$response_array[14]</td></tr>";
	$message = $message ."<tr><td>Address :</td><td>$response_array[16]</td></tr>";
	$message = $message ."<tr><td>City :</td><td>$response_array[17]</td></tr>";
	$message = $message ."<tr><td>State :</td><td>$response_array[18]</td></tr>";
	$message = $message ."<tr><td>Postal Code :</td><td>$response_array[19]</td></tr>";
	$message = $message ."<tr><td>Phone  :</td><td>$response_array[21]</td></tr>";
    $message = $message ."<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
    $message = $message ."<tr><td><strong>Order Details :</strong></td><td></td></tr>";
    $message = $message ."<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
	$message = $message ."<tr><td>Transaction Id :</td><td>$response_array[6]</td></tr>";
	$message = $message ."<tr><td>Amount :</td><td>$response_array[9]</td></tr>";
	$message = $message ."<tr><td>Order Date :</td><td>$date</td></tr>";
    $message = $message ."<tr><td>&nbsp;</td><td>&nbsp;</td></tr></table>";
    
    $message = $message ."Thanks,<br>";                
    $message = $message ."Support Team.<br>";
    
	mail($to,$subject,$message,$headers);
}
?>

	



  </div>

</div>

<!--body end here-->

<?php get_footer(); ?>
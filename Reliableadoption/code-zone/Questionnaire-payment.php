<?php	 		 	

/*

<?php	 		 	

/*

Template Name: Questionnaire Payment

*/

?>



<?php if(!is_user_logged_in())	header('Location: /login/');
get_header();

$StepparentFormID = 10;

$NaturalMotherFormID = 11;

$NaturalFatherFormID = 12;

$ChildrenFormID = 13;

$MarriageInfoFormID = 14;

$ParentChildRelationship = 15;

$children = get_user_meta( $user_ID, "children", true );

$child = '0';
$cadd_val = '75';
$cval = '25';

for($i = 0; $i < $children; $i++) {
	if($i == 0)
		$child += $cval;
	else
		$child += $cadd_val;
}

echo "<input type='hidden' value='$child' name='childcal' id='childcal'>";

function count_lead_row($fid, $user_ID)

{
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'rg_lead';
	$jeet = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name where created_by = {$user_ID} and form_id = {$fid}");	
	
	return $jeet;

}



function count_lead_child($fid, $user_ID)
{
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'rg_lead';
	
	$results = $wpdb->get_results( "SELECT id FROM $table_name where created_by = {$user_ID} and form_id = {$fid} ORDER BY id DESC");

		foreach ($results as $row_data)
		{
			$form_id[] = $row_data->id;
		}
				
		return $form_id;

}



function get_lead_arr($fid, $user_ID)

{

	global $wpdb;
	
	$table_name = $wpdb->prefix . 'rg_lead';
	$id = $wpdb->get_var( "SELECT id FROM $table_name where form_id = {$fid} and created_by = {$user_ID} ORDER BY id DESC" );	
	
	return $id;
}





function get_questionnaire_arr($leadid, $fieldid)

{

 	global $wpdb;
	$table_name = $wpdb->prefix . 'rg_lead_detail';
	$row = $wpdb->get_row( "SELECT * FROM $table_name WHERE lead_id = {$leadid} and field_number = {$fieldid}", ARRAY_N);	
	return $row[4];

}

function check_required_viaUser($fid, $userid) {
    $leadid = get_lead_arr($fid, $userid);
    return check_required($leadid, $fid);
}

function check_required_children($userid) {
    global $children, $ChildrenFormID;
    $arr = count_lead_child($ChildrenFormID, $userid);
    for ($z = 1; $z <= $children; $z++) {
        $child_leadid = $arr[$z - 1]['id'];
        if (!check_required($child_leadid, $ChildrenFormID)) {
            return false;
        }
    } return true;
}

function check_required($leadid, $fid) {
    $form = RGFormsModel::get_form_meta($fid);
    $lead = RGFormsModel::get_lead($leadid);
    foreach ($form["fields"] as $field) {
        if ($field["isRequired"] == "1" || strpos(esc_html(GFCommon::get_label($field)), "*") !== false) {
			switch(RGFormsModel::get_input_type($field)) {
				case "section":
				case "captcha":
				case "html":
				case "password":
				break;
				default:
					if(strlen(trim(RGFormsModel::get_lead_field_value($lead, $field))) === 0) {
						return false;
					}
				break;
			}
        }
    } return true;
}

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    } return (substr($haystack, -$length) === $needle);
}

function all_required() {
    global $StepparentFormID, $NaturalMotherFormID, $NaturalFatherFormID, $ChildrenFormID, $MarriageInfoFormID, $ParentChildRelationship, $user_ID, $children;
    $leadid = get_lead_arr($StepparentFormID, $user_ID);
    if (!check_required($leadid, $StepparentFormID))
        return false; $leadid = get_lead_arr($NaturalMotherFormID, $user_ID);
    if (!check_required($leadid, $NaturalMotherFormID))
        return false; $leadid = get_lead_arr($NaturalFatherFormID, $user_ID);
    if (!check_required($leadid, $NaturalFatherFormID))
        return false; $arr = count_lead_child($ChildrenFormID, $user_ID);
    for ($z = 1; $z <= $children; $z++) {
        $child_leadid = $arr[$z - 1]['id'];
        if (!check_required($child_leadid, $ChildrenFormID))
            return false;
    } $leadid = get_lead_arr($MarriageInfoFormID, $user_ID);
    if (!check_required($leadid, $MarriageInfoFormID))
        return false; $leadid = get_lead_arr($ParentChildRelationship, $user_ID);
    if (!check_required($leadid, $ParentChildRelationship))
        return false; return true;
}

?>





<script type="text/javascript">
var code_applied = false;
var cur_code = null;
function cal_amount(val){    
	hdnval = document.getElementById("x_hdn_amount").value;    
	setval = document.getElementById("set_hdn_amount").value;    	
	calval = parseInt(setval)+parseInt(val);	    
	if(jQuery('#txtDiscountCode').val().length == 0 || !code_applied) {	
		document.getElementById("x_hdn_amount").value = calval;	
		document.getElementById("div_amount").innerHTML = "Total : $"+calval;    
	} else {	
		document.getElementById("x_hdn_amount").value = calval;	
		process_code(cur_code, true);    
	}
}
function applyCouponCode(code) {    
	if(code == '')        
		return { code: '', type: 'percent', value: 0, applies_to: 'overall' };    
	var json = null;    
	$.ajax({
		'async':false,        
		'url': '/wp-content/themes/doug/couponcode.php?cc=' + code,        
		'success': function(data) {            
			json = eval('(' + data + ')');        
		}    
	});    
	return json;
}

function applyDiscount(code, silent) {    
	var retcode = applyCouponCode(code);    
	process_code(retcode, silent);  
}

function process_code(code, silent) {    
	child_calc();    
	code_applied = false;    
	cal_amount(jQuery('input:radio[name=Shipping]:checked').val());    
	if(code == null) {            
		if(!silent)                    
			alert('coupon code is not valid');            
		return;    
	}    
	if(code != null && code.code != "") {
        code_applied = true;
        cur_code = code;
    }
    cal_discount(code.value, code.type, code.applies_to);
}

function cal_discount(value, type, applies) {
	var hdnval = parseInt(document.getElementById("x_hdn_amount").value);
	var calval;
	var discountAmount = 0;
	var raw_value = 0;
	switch(applies) {
		case "product":
			raw_value = parseInt(jQuery('#set_hdn_amount').val());
		break;
		case "shipping":
			raw_value = hdnval - parseInt(jQuery('#set_hdn_amount').val());
		break;
		default:			
			raw_value = hdnval;
		break;
	}

	if(type == "percent") {
		discountAmount = parseInt(raw_value * (parseFloat(value) / 100));
	} else {
		discountAmount = value;
	}
	calval = parseInt(hdnval - discountAmount);
	if(calval < 0)
	calval = 0;
	jQuery("#x_hdn_amount").val(calval);
	jQuery("#div_amount").html("Total : $" + calval);
}

function child_calc()

{

    chdval = document.getElementById("childcal").value;

    hdnval = '300';

    calval = parseInt(hdnval)+parseInt(chdval);

    document.getElementById("set_hdn_amount").value = calval;

   	document.getElementById("x_hdn_amount").value = calval;

	document.getElementById("div_amount").innerHTML = "Total : $"+calval;

}

jQuery(child_calc);

</script>

<input type="hidden" name="set_hdn_amount" id="set_hdn_amount" value="">

<style>

	td{
		font-size:11px;
	}

	#cboxCurrent, #cboxNext, #cboxPrevious {

		display:none !important;

	}

</style>



<!--body start here-->

<div class="container">
	
  <div class="questionnaire">

	  <div class="rockthemes-parallax" 
	parallax-model="no_parallax_only_image" 
	parallax-bg-image="/wp-content/uploads/2018/02/stepparent-adoption-questionnaire.jpg" 
	parallax-mask-height="160"> 
</div>
 
<img src="<?php bloginfo('url') ?>/wp-content/uploads/2012/05/Questionnaire-Green.gif" style="alignment-adjust: central;padding-left: 25px;" />


    <div class="secure-account">

<script type="text/javascript">


jQuery(window).ready(function() {

	jQuery('#submitOrder').click(function(){

          if(jQuery('#x_card_num').val() == '') {

           jQuery("#x_card_num").css({"background-color": "red"});

            jQuery("#x_card_num").css({"color": "white"});

            jQuery('#x_card_num').focus();

            return false;          

           }



           if(jQuery('#x_exp_month').val() == '') {

            jQuery("#x_exp_month").css({"background-color": "red"});

            jQuery("#x_exp_month").css({"color": "white"});

            jQuery('#x_exp_month').focus();

            return false;          

           }



           if(jQuery('#x_exp_year').val() == '') {

            jQuery("#x_exp_year").css({"background-color": "red"});

            jQuery("#x_exp_year").css({"color": "white"});

            jQuery('#x_exp_year').focus();

            return false;          

           }



           if(jQuery('#x_first_name').val() == '') {

            jQuery("#x_first_name").css({"background-color": "red"});

            jQuery("#x_first_name").css({"color": "white"});

            jQuery('#x_first_name').focus();

            return false;          

           }



           if(jQuery('#x_zip').val() == '') {

            jQuery("#x_zip").css({"background-color": "red"});

            jQuery("#x_zip").css({"color": "white"});

            jQuery('#x_zip').focus();

            return false;          

           }



           var names = {};

            jQuery('input:radio').each(function() { // find unique names

                names[jQuery(this).attr('name')] = true;

            });



            var count = 0;

            jQuery.each(names, function() { // then count them

                count++;

            });



           if (jQuery('input:radio:checked').length != count) {

                alert("Please select one shipping options!");

                return false;

            }



	   jQuery("#authorize").submit();



        });



});



//-->

</script>

<form name="authorize" id="authorize" method="post" action="<?php echo bloginfo("url"); ?>/questionnaire-payment-confirmation/">

	       <div class="secure-account-img-center">

		 <div class="secure-head">Secure Account For<br /><span class="style18">

         <?php global $current_user;		

		echo $current_user->display_name; ?></span></div>

		  <div class="divorce">

		    <h2>Payment Information</h2>

			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="float:left">

					<tr>

						<td class="style21">Credit Card </td>

					</tr>

					<tr>
						<td width="100%" style="float:left">Card Number:</td>

					</tr>
					<tr>
						<td width="100%" style="float:left">
						
						<input type="text" name="x_card_num" id="x_card_num" class="frmfield2" />  </td>

					</tr>

					<tr>

						<td style="float:left">Expiration Date</td>

					</tr>
					<tr>

					<td>

						<select name="x_exp_month" id="x_exp_month" class="frmfield2" style="width:100%;float:left;background:none" >

							 <option value="" selected="selected">Select</option>

							 <option value="01">January</option>      

							 <option value="02">February</option>      

							 <option value="03">March</option>      

							 <option value="04">April</option>      

							 <option value="05">May</option>      

							 <option value="06">June</option>      

							 <option value="07">July</option>      

							 <option value="08">August</option>      

							 <option value="09">September</option>      

							 <option value="10">October</option>      

							 <option value="11">November</option>      

							 <option value="12">December</option>       	

						</select>

		&nbsp;

						<select name="x_exp_year" id="x_exp_year" class="frmfield2" style="width:100%;float:left;background:none">

							 <option value="" selected="selected">Select</option>
								<?php for ($year = date("Y"); $year < date("Y") + 30;$year++) { ?>
							<option value="<?php echo substr($year,2); ?>"><?php echo $year; ?></option>
							<?php } ?>
							
						</select>

					</td>



				  </tr>

					 

					<tr>

						<td class="style21">Card Holder Information </td>

					</tr>

				  <tr>

					<td>First Name : </td>
				  </tr>
				
				<tr>
					<td><input type="text" name="x_first_name" id="x_first_name" class="frmfield2" /></td>

				</tr>

				<tr>

					<td>Last Name : </td>
				</tr>
				<tr>
					<td><input type="text" name="x_last_name" id="x_last_name" class="frmfield2" /></td>

				</tr>

				<tr>

					<td>Address : </td>
				</tr>
				<tr>

				<td><input type="text" name="x_address" id="x_address" class="frmfield2" /></td>
				</tr>

				<tr>
					<td>City : </td>
				</tr>

				<tr>
					<td><input type="text" name="x_city" id="x_city" class="frmfield2" /></td>

				</tr> 

				<tr>

				   <td>State : </td>

				</tr>
			
				<tr>

					<td><input type="text" name="x_state" id="x_state" class="frmfield2" /></td>

				</tr>

			  <tr>

					<td>Postal Code : </td>

			  </tr>
			
			  <tr>
				
				<td><input type="text" name="x_zip" id="x_zip" class="frmfield2" /></td>

			  </tr>

			  <tr>

					<td>Phone : </td>
			  </tr>

			  <tr>
				
				<td><input type="text" name="x_phone" id="x_phone" class="frmfield2" /></td>
			  </tr>

			  <tr>

				<td>Discount Code :</td>
			</tr>
			<tr>
				<td><input type="text" id="txtDiscountCode" class="frmfield2" /></td>

			</tr>

			<tr>
				
				<td align="center"><button onclick="applyDiscount($('#txtDiscountCode').val()); return false;" class="discount_button">Apply Discount Code</button></td>

			</tr>


		</table>		

	</div>

<?php echo "<p class='style21' style='text-align: center;line-height:21px;'>&#34;Price reflects a $75 charge for each additional child&#34;</p>"; ?>

	<div class="divorce">

		    <h2 align="center">Shipping Options</h2>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="float:left">


  <tr>

    <td width="51%" style="font-size:13px;">

      <input type="radio" name="Shipping" id="Shipping" value="0" onclick="javascript:cal_amount( '0' )" checked="true" />

      Email: FREE</td>

	</tr>
	<tr>

    <td width="49%" style="font-size:13px;"><input type="radio" name="Shipping" id="Shipping" value="9" onclick="javascript:cal_amount( '9' )" /> 

      Priority Mail: $9<br><p style="text-align:center;">Delivery: 3 Days</p></td>


	</tr>


	  <tr>


		<td style="font-size:13px;"><input type="radio" name="Shipping" id="Shipping" value="6" onclick="javascript:cal_amount( '6' )" /> 

		  Regular Mail: $6<br><p style="text-align:center;">Delivery: 5 Days</p></td>

	</tr>

	<tr>

		<td style="font-size:13px;"><input type="radio" name="Shipping" id="Shipping" value="25" onclick="javascript:cal_amount( '25' )" /> 

		  Express Mail $25<br><p style="text-align:center;">Delivery: 2 Days</p></td>


	</tr>

	</table>

	</div>



	<div class="divorce">


	<p class="style24" id="div_amount">Total : $325</p>

    

	<input type="hidden" name="x_hdn_amount" id="x_hdn_amount" value="325">



	</div>



	</form>
	

		  <div class="divorce"><p align="center"><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/submit-order1.png" id="submitOrder" alt="" border="0" /></a></p>


			<br />

			
			<p align="center"><img src="/wp-content/uploads/2012/10/supersecurelock2.jpg">&nbsp;<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/card.jpg" alt="" /></p>



		   </div>


		 </div>



	</div>



<style>



a{



    color: #000000;



    text-decoration: none;



}



</style>

		<div class="secure-account-right" >



    <?php 

        $leadid = get_lead_arr($StepparentFormID, $user_ID);

        $res = count_lead_row($StepparentFormID, $user_ID); 

        global $wpdb;
			
			$table_name = $wpdb->prefix . 'rg_lead_detail';
			
			$cntrow_query = $wpdb->get_var("SELECT lead_id FROM $table_name where lead_id = $leadid");
			
			$cntrow= $wpdb->num_rows;


        if($leadid === null){?>


            <a href="/questionnaire" rel="lightbox[835]">



            <?php



            }


            else{  ?>



            <a href="/adoption-questionnaire-edit/?id=<?php echo $StepparentFormID ?>" rel="lightbox[1223]">



            <?php



            }?>



      <div class="user-box" title="Stepparent">

        <div class="user-img"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/user-img.jpg" alt="" border="0" /></div>

        <div class="user-detail">

	 <?php if(!check_required($leadid, $StepparentFormID)){ ?>

          <h2><span class="off">Stepparent</span></h2>

	    <?php  }else{ ?>

          <h2><span style="text-decoration:none;">Stepparent</span></h2>

	  <?php  } ?> 

		<div class="user-info" style="overflow: auto; height: 68px;"><strong><?php  echo get_questionnaire_arr($leadid, 2); ?></strong>

		<p><?php  echo get_questionnaire_arr($leadid, 16); ?>

		  <br />

		 <?php  echo get_questionnaire_arr($leadid, 17); ?> <?php  echo get_questionnaire_arr($leadid, 19); ?></p>

	       </div>

        </div>

      </div>



</a>



	 <?php  



        $leadid = get_lead_arr($NaturalMotherFormID, $user_ID); 



        $res = count_lead_row($NaturalMotherFormID, $user_ID);  



       global $wpdb;
        
		$table_name = $wpdb->prefix . 'rg_lead_detail';
		
		$cntrow_query = $wpdb->get_var("SELECT lead_id FROM $table_name where lead_id = $leadid");
		
		$cntrow= $wpdb->num_rows;

        if($leadid === null){ ?>



		<a href="/questionnaire-2/" rel="lightbox[837]">



		<?php }else{ ?>



		<a href="/adoption-questionnaire-edit/?id=<?php echo $NaturalMotherFormID ?>" rel="lightbox[1223]">



		<?php }?>



	  <div class="user-box" title="Natural Mother">



        <div class="user-img"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/user-img.jpg" alt="" border="0" /></div>



	    <div class="user-detail">


	 <?php if(!check_required($leadid, $NaturalMotherFormID)){ ?> 



          <h2><span class="off">Natural Mother</span></h2>



	    <?php  }else{ ?>



          <h2><span style="text-decoration:none;">Natural Mother</span></h2>



	  <?php  }$leadid = get_lead_arr($NaturalMotherFormID, $user_ID); ?>



	      <div class="user-info" style="overflow: auto; height: 45px;"><strong><?php  echo get_questionnaire_arr($leadid, 5); ?></strong>



              <p> <?php  echo get_questionnaire_arr($leadid, 17); ?><br />

                <?php  echo get_questionnaire_arr($leadid, 18); ?> <?php  echo get_questionnaire_arr($leadid, 20); ?></p>



	        </div>



	      </div>

	    <div class="user-info-bottom">



          <p align="center">Natural Parents Married : <span class="style19"><?php  echo get_questionnaire_arr($leadid, 1); ?></span></p>



	      </div>



	    </div>



        </a>


	 <?php  



        $leadid = get_lead_arr($NaturalFatherFormID, $user_ID); 



        $res = count_lead_row($NaturalFatherFormID, $user_ID);  



		global $wpdb;
		
		$table_name = $wpdb->prefix . 'rg_lead_detail';
		
		$cntrow_query = $wpdb->get_var("SELECT lead_id FROM $table_name where lead_id = $leadid");
		
		$cntrow= $wpdb->num_rows;



        if($leadid === null){



            ?>



     <a href="/questionnaire-3/" rel="lightbox[841]">



     <?php }else{ ?>



     <a href="/adoption-questionnaire-edit/?id=<?php echo $NaturalFatherFormID ?>" rel="lightbox[1223]">



     <?php }?>




	  <div class="user-box" title="Natural Father">



        <div class="user-img"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/user-img.jpg" alt="" border="0" /></div>

	    <div class="user-detail">



	 <?php if( !check_required($leadid, $NaturalFatherFormID)){ ?> 



            <h2><span class="off">Natural Father</span></h2>          



	    <?php  }else{ ?>



          <h2><span style="text-decoration:none;">Natural Father</span></h2>



	    <?php  } $leadid = get_lead_arr($NaturalFatherFormID, $user_ID);   ?>



	      <div class="user-info" style="overflow: auto; height: 45px;"><strong><?php  echo get_questionnaire_arr($leadid, 5); ?></strong>



              <p><?php  echo get_questionnaire_arr($leadid, 16); ?><br />



                <?php  echo get_questionnaire_arr($leadid, 17); ?> <?php  echo get_questionnaire_arr($leadid, 19); ?></p>


	        </div>


	      </div>


	    <div class="user-info-bottom">



          <p align="center">Sign Consent: <span class="style19"><?php  echo get_questionnaire_arr($leadid, 2); ?></span> | Address Unknown: <span class="style19"><?php  echo get_questionnaire_arr($leadid, 3); ?></span></p>



	      </div>

	    </div>

        </a>

		<div class="children_tab" >

	<?php	 

    $arr = count_lead_child($ChildrenFormID, $user_ID);

     $k = 0;

     for($z=1; $z<=$children; $z++){

     $leadid = $arr[$k];

     ?>

	  <div class="child_tab" >

	  <div class="children" style="width:220px;">Children</div>

	  <div class="user-box-center" style="margin: 0px 0 0 5px;" title="Child Information">

      <?php  $res = count_lead_row($ChildrenFormID, $user_ID);

      if($res == $z || $res > $z){ ?>

      <a href="/adoption-questionnaire-edit/?lid=<?php echo $leadid; ?>&id=<?php echo $ChildrenFormID ?>" rel="lightbox[1223]">

      <?php }else{

       ?>

       <a href="/questionnaire-4/" rel="lightbox[938]">

       <?php }?>

	    <div class="user-box">

          <div class="user-img"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/user-img.jpg" alt="" border="0" /></div>

	      <div class="user-detail">



	   <?php 

		 if(check_required($leadid, $ChildrenFormID)){ ?>

            <h2><span style="text-decoration:none;"><?php  if( get_questionnaire_arr($leadid, 5) == "Male"){echo "Son";}else{echo "Daughter";} ?></span></h2>

	   <?php  }else{ ?>

            <h2><span class="off" style="color:#b85126">.</span></h2>

	   <?php  }  ?>

	        <div class="user-info">

                <p style="overflow: auto; height: 42px;"><strong><?php  if(get_questionnaire_arr($leadid, 1) ==""){echo "Child #".$z;}else{ echo get_questionnaire_arr($leadid, 1);} ?></strong></p>

            </div>

	        </div>

	      <div class="user-info-bottom">

            <p align="center">Over 18 years old : <span class="style19"><?php  echo get_questionnaire_arr($leadid, 11); ?></span></p>



	        </div>

	      </div>

          </a>

	    </div>

	  </div>

      <?php  $k++;    }?>

		</div>


	  <div class="secure-account-right-bottom">

        <div class="secure-user-bottom" style="padding-left: 0px;width: 100%;">

      	 <?php  

        $leadid = get_lead_arr($MarriageInfoFormID, $user_ID); 

        $res = count_lead_row($MarriageInfoFormID, $user_ID);  

        global $wpdb;
        
		$table_name = $wpdb->prefix . 'rg_lead_detail';
		
		$cntrow_query = $wpdb->get_var("SELECT lead_id FROM $table_name where lead_id = $leadid");
		
		$cntrow= $wpdb->num_rows;

        if($leadid === null){

        ?>      



     <a href="/questionnaire-5/" rel="lightbox[940]">

     <?php }else{ ?>

     <a href="/adoption-questionnaire-edit/?id=<?php echo $MarriageInfoFormID ?>" rel="lightbox[1223]">

     <?php }?>

        <?php  $res = count_lead_row($MarriageInfoFormID, $user_ID); ?>

        <?php  if($res==0){ ?><?php  } ?>

          <div class="user-box1" title="Marriage Information">

            <div class="user-img"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/user-img.jpg" alt="" border="0" /></div>

            <div class="user-detail">

              <div class="user-info1">

                <div class="icon01">

		<?php if( !check_required($leadid, $MarriageInfoFormID)){ ?> 

            <img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/red-icon.png" alt="" border="0" />

		    <?php  }else{ ?>

		      <img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/green-icon.png" alt="" border="0" />

		  <?php  } ?>

		 </div>

                <p class="style20" style="color:#3D64A5;text-decoration:none;">Marriage<br />

                  Information</p>

                <br />

                <br />

              </div>

            </div>



            <div class="user-info-bottom1">

              <p align="center">Married: <span class="style19"><?php  echo get_questionnaire_arr($leadid, 1); ?></span> &nbsp;|&nbsp; Marriage Place: <span class="style19"><?php  echo get_questionnaire_arr($leadid, 2); ?></span></p>

            </div>

          </div>

          </a>

          

      	 <?php  

        $leadid = get_lead_arr($ParentChildRelationship, $user_ID); 

        $res = count_lead_row($ParentChildRelationship, $user_ID);  

        global $wpdb;
        
		$table_name = $wpdb->prefix . 'rg_lead_detail';
		
		$cntrow_query = $wpdb->get_var("SELECT lead_id FROM $table_name where lead_id = $leadid");
		
		$cntrow= $wpdb->num_rows;

        if($leadid === null){

        ?>      



     <a href="/questionnaire-6/" rel="lightbox[942]" >

     <?php }else{ ?>

     <a href="/adoption-questionnaire-edit/?id=<?php echo $ParentChildRelationship ?>" rel="lightbox[1223]">

     <?php }?>

          <div class="user-box1">

            <div class="user-img"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/user-img.jpg" alt="" border="0" /></div>



            <div class="user-detail">

              <div class="user-info1">

                <div class="icon01">

					<?php if( !check_required($leadid, $ParentChildRelationship)){ ?> 

					<img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/red-icon.png" alt="" border="0" />		  

					<?php  }else{ ?>

				  <img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/green-icon.png" alt="" border="0" />

				  <?php  }$leadid = get_lead_arr($ParentChildRelationship, $user_ID); ?>

				 </div>

                <p class="style20">Parent/Child<br />

                  Relationship</p>

                <br />

                <br />

              </div>

            </div>

            <div class="user-info-bottom1">

              <p align="center">Last Child Support:<span class="style19"><?php  echo get_questionnaire_arr($leadid, 7); ?></span> | Contact : <span class="style19"><?php  echo get_questionnaire_arr($leadid, 9); ?></span></p>

            </div>

          </div>

          </a>

        </div>



	    <div class="devorce-status">

          <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>

              <td>Status:</td>

              <td><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/green-icon.png"  alt=""/></td>

              <td> Section Complete</td>

              <td><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/red-icon.png"  alt=""/></td>

              <td> Section Requires additional information</td>

            </tr>

          </table>

	      </div>

	    

	    </div>
		

	  </div>



  </div>

</div>



<!--body end here-->



<?php get_footer(); ?>
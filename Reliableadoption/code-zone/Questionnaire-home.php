<?php	 		 	
/*
Template Name: Questionnaire Home
*/
 
if(!is_user_logged_in()){
		header('Location: /login/');
	}

get_header();

$StepparentFormID = 10;
$NaturalMotherFormID = 11;
$NaturalFatherFormID = 12;
$ChildrenFormID = 13;
$MarriageInfoFormID = 14;
$ParentChildRelationship = 15;
$user_ID = get_current_user_id();
if(isset($_REQUEST["form_id_val"]))
{

    $fid = $_REQUEST['form_id_val'];

    if($_REQUEST['lead_id_val'] == "")
    {

       global $wpdb;
	
	$table_name = $wpdb->prefix . 'rg_lead';
	
	$results = $wpdb->get_var( "SELECT id FROM $table_name where created_by = {$user_ID} and form_id = {$fid} ORDER BY id DESC");
	
	$leadid = $results;

     }else{
        $leadid = $_REQUEST['lead_id_val'];
     }     
        $form = RGFormsModel::get_form_meta($fid);

        $lead = RGFormsModel::get_lead($leadid);

	    check_admin_referer('gforms_save_entry', 'gforms_save_entry');

	    RGFormsModel::save_lead($form, $lead);
		
		if(check_required($leadid, $fid)) {
			$section = $form["title"];
			switch($fid) {
			}
			$msg = "Congratulations, the &quot;" . $section . "&quot; section has been saved.  Please complete the remaining boxes until all the boxes show a green indicator, then you will be able to submit your order. ";
		}
		?>
		<script type='text/javascript'>
			jQuery(function() {
				window.location.hash = "questionnaire";
			});
		</script>
		<?php
        $lead = RGFormsModel::get_lead($leadid);

        

}



$children = get_user_meta( $user_ID, "children", true );

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
		
		$form_id = array();
		foreach ($results as $row_data)
		{
			$form_id[] = $row_data->id;
		}
				
		return $form_id;

}

function check_required_viaUser($fid, $userid) {
	$leadid = get_lead_arr($fid, $userid);
	return check_required($leadid, $fid);
}
function check_required_children($userid) {
	
	global $children, $ChildrenFormID;
	$arr = count_lead_child($ChildrenFormID, $userid);
	for($z=1; $z<=$children; $z++){
		$child_leadid = $arr[$z - 1];
		if(!check_required($child_leadid, $ChildrenFormID)) {
			return false;
                }
	}
	return true;
}
function check_required($leadid, $fid) {
	$form = RGFormsModel::get_form_meta($fid);
	$lead = RGFormsModel::get_lead($leadid);
	foreach($form["fields"] as $field) {
		if($field["isRequired"] == "1" || strpos(esc_html(GFCommon::get_label($field)), "*") > 0) {
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
	}
	return true;
}
function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

      
function all_required() {
	global $StepparentFormID, $NaturalMotherFormID, $NaturalFatherFormID, $ChildrenFormID, $MarriageInfoFormID, $ParentChildRelationship, $user_ID, $children;
	$leadid = get_lead_arr($StepparentFormID, $user_ID);
	if(!check_required($leadid, $StepparentFormID))
		return false;
		
	$leadid = get_lead_arr($NaturalMotherFormID, $user_ID);
	if(!check_required($leadid, $NaturalMotherFormID))
		return false;
		
	$leadid = get_lead_arr($NaturalFatherFormID, $user_ID);
	if(!check_required($leadid, $NaturalFatherFormID))
		return false;
		
	$arr = count_lead_child($ChildrenFormID, $user_ID);
	for($z=1; $z<=$children; $z++){
		$child_leadid = $arr[$z - 1];
		if(!check_required($child_leadid, $ChildrenFormID))
			return false;
	}
	
	$leadid = get_lead_arr($MarriageInfoFormID, $user_ID);
	if(!check_required($leadid, $MarriageInfoFormID))
		return false;
		
	$leadid = get_lead_arr($ParentChildRelationship, $user_ID);
	if(!check_required($leadid, $ParentChildRelationship))
		return false;
	
	return true;
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
	if($leadid !=''){
	$row = $wpdb->get_row( "SELECT * FROM $table_name WHERE lead_id = {$leadid} and field_number = {$fieldid}", ARRAY_N);	
	return $row[4];
	}
}


?>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/tooltip.js"></script>



<div class="rockthemes-parallax" 
	parallax-model="no_parallax_only_image" 
	parallax-bg-image="/wp-content/uploads/2011/09/step-parent-adoption-topofpage.jpg" 
	parallax-mask-height="160"> 
</div>


<!--body start here-->

<a name='questionnaire'>&nbsp;</a>
  <div class="questionnaire">
	  

	<img src="<?php bloginfo('url') ?>/wp-content/uploads/2012/05/Questionnaire-Blue.gif" style="alignment-adjust: central;padding-left: 25px;" /> 
	  
	  <div class="secure-account">
	  
	     <div class="secure-account-img-center">

		 <div class="secure-head">Secure Account For<br />
		 <span class="style18">


			<?php  global $current_user;


			echo $current_user->display_name; ?>

		</span>
		</div>

		  <div class="divorce">
		    <h2>Adoption Questionnaire</h2>
			<ul class="divorce-link">
                 <li <?php  if(!check_required_viaUser($StepparentFormID, $user_ID)) {echo 'class="close"';} ?>>
					<a href="#">Stepparent Information</a></li>
									 <li <?php  if(!check_required_viaUser($NaturalMotherFormID, $user_ID)) {echo 'class="close"';} ?>>
					<a href="#">Mother Information</a></li>
									 <li <?php  if(!check_required_viaUser($NaturalFatherFormID, $user_ID)) {echo 'class="close"';} ?>>
					<a href="#">Father Information</a></li>
									 <li <?php  if(!check_required_children($user_ID)) {echo 'class="close"';} ?>>
					<a href="#">Children Information</a></li>
									 <li <?php  if(!check_required_viaUser($MarriageInfoFormID, $user_ID)) {echo 'class="close"';} ?>>
					<a href="#">Marriage information</a></li>
									 <li <?php  if(!check_required_viaUser($ParentChildRelationship, $user_ID)) {echo 'class="close"';} ?>>
					<a href="#">Parent Information</a>
				</li>
			</ul>


		    <h2 align="center">Resource Center</h2>

			<p>

            <ul style="padding-left: 12px;list-style: outside none square;margin-left: 5px;">
				<?php 
				global $wpdb;
				
				$table_name = $wpdb->prefix . 'question';
				
				$question_results = $wpdb->get_results( "SELECT * FROM $table_name");
				foreach($question_results as $results)
				{ /*?>
					<li style="cursor: pointer;" class="toolTip" title="<?php  echo $results->que_answer; ?>"><?php  echo $results->que_question; ?>
					</li>
				<?php */}?>         

            </ul>

		     </p>


		   </div>



			<div class="divorce"><p id="show_err" style="color: #b70000;text-align: center;"></p><p align="center"><a href="#panding" onclick="javascript:display_err();"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/submit-order.png" alt="" border="0" /></a></p>



			<br />



			<p align="center"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/card.jpg" alt="" /></p>



			</div>



		 </div>





	</div>


	<div class="secure-account-right" >

    <?php 
		if(isset($msg)) {
		if(strlen($msg) > 0) {
		 ?>
			<div class='msg'><?php echo $msg ?></div>
		 <?php
		}
		}
        $leadid = get_lead_arr($StepparentFormID, $user_ID);
        $res = count_lead_row($StepparentFormID, $user_ID); 
        
		

        if($leadid === null){

            ?>

        <a href="/questionnaire" rel="lightbox[835]">

            <?php

            }

            else{

            ?>

			<a href="/adoption-questionnaire-edit/?id=<?php echo $StepparentFormID ?>" rel="lightbox[1223]">

				<?php

			} ?>

			  <div class="user-box" title="Stepparent">
				<div class="user-img"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/user-img.jpg" alt="" border="0" /></div>
				<div class="user-detail">
					<?php if(!check_required($leadid, $StepparentFormID)) { ?>
					  <h2><span class="off">Stepparent </span></h2>
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
				

        if($leadid === null){

		?>

      
    <a href="/questionnaire-2/" rel="lightbox[837]">

     <?php }else{ ?>

     <a href="/adoption-questionnaire-edit/?id=<?php echo $NaturalMotherFormID ?>" rel="lightbox[1223]">

     <?php }?>

	  <div class="user-box" title="Natural Mother">

        <div class="user-img"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/user-img.jpg" alt="" border="0" /></div>

	    <div class="user-detail">

	 

	 <?php if( !check_required($leadid, $NaturalMotherFormID)){ ?> 

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
        
				
        if($leadid === null){

            ?>

  
     <a href="/questionnaire-3/" rel="lightbox[841]">

     <?php }else{ ?>

     <a href="/adoption-questionnaire-edit/?id=<?php echo $NaturalFatherFormID ?>" rel="lightbox[1223]">

     <?php }?>


	  <div class="user-box" title="Natural Father">

        <div class="user-img"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/user-img.jpg" alt="" border="0" /></div>



	    <div class="user-detail">

	 <?php if(!check_required($leadid, $NaturalFatherFormID)){ ?> 

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

          <p align="center">Sign Consent: <span class="style19"><?php  echo get_questionnaire_arr($leadid, 2); ?></span>&nbsp;|&nbsp;Address unknown: <span class="style19"><?php  echo get_questionnaire_arr($leadid, 3); ?></span></p>

	      </div>
	    </div>
        </a>
		<div class="children_tab">
	<?php	 
    $arr = count_lead_child($ChildrenFormID, $user_ID);	
    
	$k = 0;
     
	for($z=1; $z<=$children; $z++){
    
	$leadid = $arr[$k];
     
	?>
	  <div class="child_tab">
	  <div class="children" >Children</div>
      

	  <div class="user-box-center" style="margin: 0px 0 0 5px;" title="Child Information">
      <?php  	  
		global $wpdb; 
		$qry = "SELECT id FROM wp_rg_lead where created_by = {$user_ID} and form_id = {$ChildrenFormID} ORDER BY id DESC";		
		$wpdb->get_results($qry); 

		$res= $wpdb->num_rows;
		if($res == $z || $res > $z){ ?>
      <a href="/adoption-questionnaire-edit/?lid=<?php echo $leadid; ?>&id=<?php echo $ChildrenFormID ?>" rel="lightbox[1223]">
      <?php }else{
       ?>
      <a href="/questionnaire-4/" rel="lightbox[938]">
       <?php }?>
	    <div class="user-box">
          <div class="user-img"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/user-img.jpg" alt="" border="0" /></div>
	      <div class="user-detail">

	   <?php 
		 if( check_required($leadid, $ChildrenFormID)){ ?>
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
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/red-icon.png" alt="" border="0" />
		    <?php  }else{ ?>
		      <img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/green-icon.png" border="0" alt="" />
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
        
        if($leadid === null){
        ?>      
      <a href="/questionnaire-6/" rel="lightbox[942]" >
     <?php }else{ ?>
     <a href="/adoption-questionnaire-edit/?id=<?php echo $ParentChildRelationship ?>" rel="lightbox[1223]">
     <?php }?>
          <div class="user-box1">
            <div class="user-img"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/user-img.jpg" alt="" border="0" /></div>

            <div class="user-detail">
              <div class="user-info1">
                <div class="icon01">
		<?php if( !check_required($leadid, $ParentChildRelationship)){ ?> 
            <img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/red-icon.png" border="0" alt="" />		  
		    <?php  }else{ ?>
		  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/green-icon.png" border="0" alt="" />
		  <?php  }$leadid = get_lead_arr($ParentChildRelationship, $user_ID); ?>
		</div>
                <p class="style20">Parent/child<br />
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
              <td><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/green-icon.png" alt=""/></td>
              <td>Section Complete</td>
              <td><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/red-icon.png" alt=""/></td>
              <td>Section Requires additional information</td>
            </tr>
          </table>
	      </div>
	   
	    </div>
	  </div>
  </div>
</div>


<style>

a{

    color: #000000;

    text-decoration: none;

}


.b3:hover{



 text-decoration:none;



}
.toolTip {
    /*background: url("<?php  echo get_stylesheet_directory_uri(); ?>/images/help.gif") no-repeat scroll right center transparent; */   
    cursor: help;
    padding-right: 20px;
    /*position: relative;*/
}
.toolTipWrapper {
    color: #FFFFFF;
    display: none;
    font-size: 9pt;
    font-weight: bold;
    /*position: absolute;*/
    top: 20px;
    width: 175px;
}
.toolTipTop {
    background: url("<?php echo get_stylesheet_directory_uri() ?>/images/bubbleTop.gif") no-repeat scroll 0 0 transparent;
    height: 30px;
    width: 175px;
}
.toolTipMid {
    background: url("<?php echo get_stylesheet_directory_uri() ?>/images/bubbleMid.gif") repeat-x scroll center top #A1D40A;
    padding: 8px 15px;
}
.toolTipBtm {
    background: url("<?php echo get_stylesheet_directory_uri() ?>/images/bubbleBtm.gif") no-repeat scroll 0 0 transparent;
    height: 13px;
}

.gform_wrapper .gform_body input {
    height: 25px!important;
    
}

</style>
<script>
function display_err(){
    document.getElementById('show_err').innerHTML = 'Oops...You have some questions that still need to be answered before you can submit your order!';
}
</script>
<!--body end here-->
<?php	 	

if(all_required())
{
      echo "<script>window.location='".get_option('home')."/questionnaire-payment/'</script>";
}

get_footer(); ?>
<?php	 		 	
/*
<?php	 		 	
/*
Template Name: registration
*/
?>



<script type="text/javascript">
/* ******************Main Hotel Price Starts*************************** */
	function check_ajax()
	{
		var ajaxRequest;  // The variable that makes Ajax possible!	
		try{
			// Opera 8.0+, Firefox, Safari
			ajaxRequest = new XMLHttpRequest();
			return ajaxRequest;
		} catch (e){
			// Internet Explorer Browsers
			try{
				ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
				return ajaxRequest;
			} catch (e) {
				try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
					return ajaxRequest;
				} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return "";
				}

			}

		}

	}

 

	function showSelected(val){

	if(document.frm.username.value=="")
	{
		alert("Enter Full Name.");
		document.frm.username.focus();
		return false;
	}

    if(document.frm.useremail.value == "")
	{
		alert("Enter Email Id.");
		document.frm.useremail.focus();
		return false;
	}


	var str=document.frm.useremail.value;
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	
	if (str.indexOf(at)==-1)
	{
		alert("Enter valid email id.");
		document.frm.useremail.focus();
		return false;
	}

	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr)
	{
		alert("Enter valid email id.");
		document.frm.useremail.focus();
		return false;
	}

	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr)
	{

		alert("Enter valid email id.");
		document.frm.useremail.focus();
		return false;
	}

	if (str.indexOf(at,(lat+1))!=-1)
	{
		alert("Enter valid email id.");
		document.frm.useremail.focus();
		return false;
	}

	if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot)
	{
		alert("Enter valid email id.");
		document.frm.useremail.focus();
		return false;
	}

	if (str.indexOf(dot,(lat+2))==-1)
	{
		alert("Enter valid email id.");
		document.frm.useremail.focus();
		return false;
	}

	if (str.indexOf(" ")!=-1)
	{
		alert("Enter valid email id.");
		document.frm.useremail.focus();
		return false;
	}

	if(document.frm.pass.value=="")
	{
		alert("Enter password.");
		document.frm.pass.focus();
		return false;
	}

	if(document.frm.pass.value.length<6)

	{

		alert("Your password must be at least 6 characters long.");

		document.frm.pass.focus();

		return false;

	}
	

	if(document.frm.repass.value=="")

	{

		alert("Enter retype password.");

		document.frm.repass.focus();

		return false;

	}

	

	

	if(document.frm.pass.value != document.frm.repass.value)

	{

		alert("Password does not match.");

		document.frm.pass.value = "";

		document.frm.repass.value = "";

		//document.register.password.focus();

		return false;

	}	

	
        TriggerTracking(); 
		//alert(val);

		var uname = document.getElementById('username').value;

		var uemail = document.getElementById('useremail').value;

		var upass = document.getElementById('pass').value;

		var urepass = document.getElementById('repass').value;

		var uchildren = document.getElementById('children').value;

		var state = document.getElementById('state').value;
                
		var phone = document.getElementById('phone').value;

		

		var check = check_ajax();

		if(check)

		{
			
			var ajaxRequest = check;

			ajaxRequest.onreadystatechange = function()

			{
					
				if(ajaxRequest.readyState == 4)
				{

					values = ajaxRequest.responseText;

					var set_val = jQuery.trim(values) ;
					
					if(jQuery.trim(values) === "email"){
						document.getElementById('message').innerHTML="<div class='msg'>Sorry, that email address already has an account, please try another or login with that account by <a href='/login/' class='lnk'>clicking here</a><div>";
					}					
                    
					if(jQuery.trim(values) === 'success'){
						//document.getElementById('message').innerHTML=values;   
						jQuery('#hdnUserName').val(uemail);
						jQuery('#hdnPassword').val(upass);
						jQuery('#frmLogin').submit();
						
						window.location='<?php echo get_option('home'); ?>/questionnaire-home/';
					}

				}

			}
		ajaxRequest.open("GET", "/get_register.php?un="+uname+"&ue="+uemail+"&up="+upass+"&urp="+urepass+"&uc="+uchildren+"&state="+state+"&phone="+phone, true);
		ajaxRequest.send(null);

		}
		
		
}	
function TriggerTracking() {
	var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-45727040-1']);
    _gaq.push(['_trackPageview', '/registration/newregistration_goal']);
}
</script>
<style type='text/css'>
	.lnk {
		color:#e47524;
	}
</style>


<div class="register_pop">

<?php	 		 	
	if(isset($_SERVER['HTTP_REFERER'])) {
	$pos = strrpos($_SERVER['HTTP_REFERER'], '/', -2);

	$state = substr($_SERVER['HTTP_REFERER'], $pos+1, -1);
	}

?>

<form name='frm_login' id='frmLogin' method='post' action='<?php echo bloginfo('url')?>/login/'>
	<input type='hidden' name='log' id='hdnUserName' value=""/>
	<input type='hidden' name='pwd' id='hdnPassword' value=""/>
	<input type='hidden' name='rememberme' value='forever' />
	<input type='hidden' name='sidebarlogin_posted' value='1' />
	<input type='hidden' name='redirect_to' value='<?php echo bloginfo('url')?>/questionnaire-home/' />
	<input type="hidden" name="testcookie" value="1" />
</form>
<form class="frm_register" name="frm" method="post" action="" onSubmit="return submit_register();">

<input type="hidden" id="hdnSubmit_frm" name="hdnSubmit_frm" value="insert" />

<input type="hidden" id="hdn_sub" name="hdn_sub" value="" />


 <div id="message"><p class="msg"></p></div> 

<p class="just_need">We just need a little information to start:</p>

<table class="register" width="100%" border="0" cellspacing="0" cellpadding="0">


  <tr>
    <td align="left" class="register_txt" style="padding-bottom:0px;">Please select your State</td>
    <td align="left" style="padding-bottom:0px;">
		<select name="state" id='state'>		

			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "alabama" ? "selected='selected'" : "" ;} ?>  value="Alabama">Alabama</option>	
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "alaska" ? "selected='selected'" : "" ; } ?> value="Alaska">Alaska</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "arizona" ? "selected='selected'" : "" ; } ?> value="Arizona">Arizona</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "arkansas" ? "selected='selected'" : "" ; }?> value="Arkansas">Arkansas</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "california" ? "selected='selected'" : "" ;}?> value="California">California</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "colorado" ? "selected='selected'" : "" ;} ?> value="Colorado">Colorado</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "connecticut" ? "selected='selected'" : "" ;}?> value="Connecticut">Connecticut</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "delaware" ? "selected='selected'" : "" ;} ?> value="Delaware">Delaware</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "florida" ? "selected='selected'" : "" ;} ?> value="Florida">Florida</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "georgia" ? "selected='selected'" : "" ;} ?> value="Georgia">Georgia</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "hawaii" ? "selected='selected'" : "" ;} ?> value="Hawaii">Hawaii</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "idaho" ? "selected='selected'" : "" ;} ?> value="Idaho">Idaho</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "illinois" ? "selected='selected'" : "" ;} ?> value="Illinois">Illinois</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "indiana" ? "selected='selected'" : "" ;} ?> value="Indiana">Indiana</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "iowa" ? "selected='selected'" : "" ;} ?> value="Iowa">Iowa</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "kansas" ? "selected='selected'" : "" ;} ?> value="Kansas">Kansas</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "kentucky" ? "selected='selected'" : "" ;} ?> value="Kentucky">Kentucky</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "louisiana" ? "selected='selected'" : "" ;} ?> value="Louisiana">Louisiana</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "maine" ? "selected='selected'" : "" ;} ?> value="Maine">Maine</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "maryland" ? "selected='selected'" : "" ;} ?> value="Maryland">Maryland</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "massachusetts" ? "selected='selected'" : "" ;} ?> value="Massachusetts">Massachusetts</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "michigan" ? "selected='selected'" : "" ;} ?> value="Michigan">Michigan</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "minnesota" ? "selected='selected'" : ""  ;}?> value="Minnesota">Minnesota</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "mississippi" ? "selected='selected'" : ""  ;}?> value="Mississippi">Mississippi</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "missouri" ? "selected='selected'" : "" ;} ?> value="Missouri">Missouri</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "montana" ? "selected='selected'" : "" ;} ?> value="Montana">Montana</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "nebraska" ? "selected='selected'" : "" ;} ?> value="Nebraska">Nebraska</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "nevada" ? "selected='selected'" : "" ;} ?> value="Nevada">Nevada</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "new hampshire" ? "selected='selected'" : "" ;} ?> value="New Hampshire">New Hampshire</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "new jersey" ? "selected='selected'" : "" ;} ?> value="New Jersey">New Jersey</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "new mexico" ? "selected='selected'" : "" ;} ?> value="New Mexico">New Mexico</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "new york" ? "selected='selected'" : "" ;} ?> value="New York">New York</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "north carolina" ? "selected='selected'" : "" ;} ?> value="North Carolina">North Carolina</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "north dakota" ? "selected='selected'" : "" ;} ?> value="North Dakota">North Dakota</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "ohio" ? "selected='selected'" : "" ;} ?> value="Ohio">Ohio</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "oklahoma" ? "selected='selected'" : "" ;} ?> value="Oklahoma">Oklahoma</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "oregon" ? "selected='selected'" : ""  ;}?> value="Oregon">Oregon</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "pennsylvania" ? "selected='selected'" : "" ;} ?> value="Pennsylvania">Pennsylvania</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "rhode island" ? "selected='selected'" : "" ;} ?> value="Rhode Island">Rhode Island</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "south carolina" ? "selected='selected'" : "" ;} ?> value="South Carolina">South Carolina</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "south dakota" ? "selected='selected'" : "" ;} ?> value="South Dakota">South Dakota</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "tennessee" ? "selected='selected'" : "" ;} ?> value="Tennessee">Tennessee</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "texas" ? "selected='selected'" : "" ;} ?> value="Texas">Texas</option>	
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "utah" ? "selected='selected'" : "" ;} ?> value="Utah">Utah</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "vermont" ? "selected='selected'" : "" ;} ?> value="Virginia">Vermont</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "virginia" ? "selected='selected'" : "" ;} ?> value="">Virginia</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "washington" ? "selected='selected'" : ""  ;}?> value="Washington">Washington</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "west virginia" ? "selected='selected'" : "" ;} ?> value="West Virginia">West Virginia</option>	
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "wisconsin" ? "selected='selected'" : ""  ;}?> value="Wisconsin">Wisconsin</option>
			<option <?php if(isset($_GET['state'])) { echo strtolower($_GET["state"]) == "wyoming" ? "selected='selected'" : "" ;} ?> value="Wyoming">Wyoming</option>
			</select>


		</td>
	</tr>
  
  <tr>

    <td width="40%" align="left" class="register_txt" style="padding-bottom:0px;">Please list the Stepparents full name:</td>

	<td width="60%" align="left" style="padding-bottom:0px;"><input type="text" name="username" class="frmfield4" value="" id="username" > <span id=msgFname"></span>    </td>

  </tr>
    

  
  <tr>
      <td align='left' class='register_txt' style="padding-bottom:0px;">Please enter your phone number:</td>
      <td align='left'><input type='textbox' name='phone' style="padding-bottom:0px;" class='frmfield4' id='phone' /></td>
  </tr>
  

  <tr>

    <td align="left"  class="register_txt" style="padding-bottom:0px;">How many children are being adopted:</td>

    <td align="left" style="padding-bottom:0px;">

    <select name="children" id="children" class="frmfield4" style="width:200px;"  id="children">

	  <option value="1">1</option>

	  <option value="2">2</option>

	  <option value="3">3</option>

	  <option value="4">4</option>

	  <option value="5">5</option>

	  <option value="6">6</option>

	  <option value="7">7</option>

	  <option value="8">8</option>

	  <option value="9">9</option>

	  <option value="10">10</option>

    </select>

   </td>

  </tr>

  
      <tr>

        <td width="9%" style="padding-bottom:0px;"><img src="<?php get_stylesheet_directory_uri() ; ?>/images/pc-icon.jpg" alt=""></td>

        <td width="91%" align="left"  class="register_txt spcl" style="padding-bottom:0px;">You don't complete the questionnaire today, you can log back in any time to finish.</td>

      </tr>

    </table>

	<table class="register">
	<tr>

        <td style="padding-bottom:0px;width:40%" align="left"  class="register_txt">Please provide your email address:</td>

        <td style="padding-bottom:0px;width:60%" align="left"><input type="text" name="useremail" id="useremail" class="frmfield4"  value=""> <span id="msgEmail"></span></td>

      </tr>

      

      <tr>

        <td style="padding-bottom:0px;" align="left"  class="register_txt">Choose a password:</td>

        <td style="padding-bottom:0px;" align="left"><input type="password" name="pass" id="pass" class="frmfield4" ></td>

      </tr>

      

      <tr>

        <td style="padding-bottom:0px;" align="left"  class="register_txt">Retype password:</td>

        <td style="padding-bottom:0px;" align="left"><input type="password" name="repass" id="repass" class="frmfield4" ></td>

      </tr>

    </table>

	<table class="register">


	  <tr>
		<td colspan="2" align="center"><input type="button" id="sub"  onClick="showSelected(this.value);" name="btnSub" value="Register" class="btnsub" ></td>

	  </tr>

  
	  <tr>

		<td colspan="2" class="style21">Already have an account? <a href="<?php bloginfo('url');?>/login/" style="color:#000000;">Click Here</a></td>

	  </tr>

  

	</table>



 </form>
 

</div>
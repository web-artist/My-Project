<?php	 		 	 



      include "wp-load.php";

	  

     $username=$_REQUEST['un'];



      $useremail=$_REQUEST['ue'];



      $password =$_REQUEST['up'];

      

      $pass=$_REQUEST['up'];



      $repass=$_REQUEST['urp'];



      $children=$_REQUEST['uc'];



      $province=$_REQUEST['state'];

	  

	  $phone=$_REQUEST['phone'];

	  


      $url= "/";



      if (username_exists($useremail)) {

            echo "email";

	    } 
		else { 

                $to ="$useremail";

            	$from = "welcome@stepparentadoptionforms.com";

            	$headers = "Content-type: text/html; charset=iso-8859-1\r\n";

            	$headers .="From: \"$from\" <$from>\r\nReply-To: \"$from\" <$from>\r\nX-Mailer: PHP/".phpversion();

            	$subject = "Thank you for visiting Stepparentadoptionforms.com";

                $message = file_get_contents('new_registration.html');

				$message = $message ."Support Team.<br>";

                

            	mail($to,$subject,$message,$headers);
     

				$user_registered = gmdate('Y-m-d H:i:s');

	   

				$userdata = array(

					'user_login'  =>  $useremail,

					'user_email'    =>  $useremail,

					'user_pass'   =>  $pass  ,

				'user_registered' => $user_registered,

				'user_nicename' => $username



				);



			$user_id = wp_insert_user( $userdata ) ;



			$user = new WP_User($user_id);

			$user->set_role(get_option('default_role'));	


			add_user_meta( $user_id,'first_name', $username ) ;

			add_user_meta( $user_id,'children', $children ) ;

			add_user_meta( $user_id,'state', $province ) ;

            add_user_meta( $user_id,'usertype', 'customer') ;

			add_user_meta( $user_id,'mailing', 'process') ;

			add_user_meta( $user_id,'phone', $phone);

			add_user_meta( $user_id,'marketing', 'pending') ;

			//wp_setcookie($useremail, $password, $already_md5 = false, $home = $url, $siteurl = $url) ;
			
			wp_set_auth_cookie($user_id, $remember = false, $secure = '') ;

			echo "success";

		  }

?>




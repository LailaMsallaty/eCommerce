<?php 
ob_start();
session_start();
  
  $pageTitle = 'Login';

  if(isset($_SESSION['user']))        // If there is a session already registered
        {
           header('Location: index.php'); 

        }

include 'init.php';

  //Check if User  comming from HTTP Post Request

       if($_SERVER['REQUEST_METHOD']=='POST')
		       {
				
		           if (isset($_POST['login'])) {

					$stmt1 = $conn->prepare("select * from users where Username =?");
					$stmt1 -> execute(array($_POST['username']));
					$members = $stmt1->fetchAll();

					foreach ($members as $member) {
						
					 if ($member['RegStatus']==0) {
							
					echo "<div class ='alert alert-danger'>".$lang['LOGIN_ERROR']."</div>";
					 }else{
		          
		            $user = $_POST['username'];
		            $pass = $_POST['password'];

		            $HashedPass = sha1($pass);

		            //  echo $HashedPass;
		           // echo $username ."".$password;


		         // check if the user exist in database

		         $stmt = $conn -> prepare("SELECT
		                                       UserID , Username , Password
		                                   From 
		                                       users 
		                                   where 
		                                       Username = ? 
		                                   And 
		                                       Password = ?");

		         $stmt -> execute(array($user ,$HashedPass));

		         $get = $stmt->fetch();

		         $count = $stmt->rowCount();

		            //echo $count . '  ';
		            // if count > 0 this mean the database contain record about this username

		        if ($count > 0)
		        {
		         
		           $_SESSION['user'] = $user;  // register session name

		           $_SESSION['uid'] = $get['UserID']; // Register User ID in Session

				   header('Location: index.php'); // Redirect To HomePage

				   exit();
		               
				 }
				 
				}
		    	}
            }else{

            $formErrors =array();

	            if (isset($_POST['username'])) {

	            	//filter the username to string without simbols
	            	
	            	$filterdUser =filter_var($_POST['username'],FILTER_SANITIZE_STRING);

	            	if (strlen($filterdUser) < 3) {

	            	   $formErrors[] = $lang['USERNAME_VALIDATE'];

	            	 } 
	                if (strlen($filterdUser) > 20) {

                                 $formErrors[]  = $lang['USERNAME_VALIDATE2'];

                                 }
	            }


	            if (isset($_POST['password']) && isset($_POST['password2'])) {
	            	
                    if (empty($_POST['password'])) {

                    	$formErrors[] = $lang['PASSWORD_VALIDATE'];
                    }

	            	$pass1 = sha1($_POST['password']);
	            	$pass2 = sha1($_POST['password2']);

	            	if ($pass1 !== $pass2) {
	            		
	            		$formErrors[] = $lang['PASSWORD_MATCH'];

	            	}
	            }

	            if (isset($_POST['email'])) {

	            	// filter SPECIAL FOR EMAIL
	            	
	            	$filterdEmail =filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

		            	if (filter_var($filterdEmail ,FILTER_VALIDATE_EMAIL) != true ){

		            		$formErrors[] = $lang['EMAIL_VALIDATE'];

	          
	            	 } 
	            }


                   // check if there is no error proceed the user add


	             if (empty($formErrors)) {

	                                  // check if user exist in database 

	                               	   $check= checkItem("Username" , "users" ,  $_POST['username']);

	                                   if ($check == 1) {

	                               	    $formErrors[] = $lang['CHECK_USER_IF_EXIST'];
	                               	    

	                               	   }else{


											  // Insert User Info In Database
										 
	                                       
	                                      $stmt = $conn ->prepare("INSERT Into users(Username ,Password ,Email,FullName, RegStatus , Date)
	                                                                VALUES (:zuser, :zpass, :zemail,:zfull, 0, now())");

		                                  $stmt->execute(array(

		                                     'zuser'  => $_POST['username'],
		                                     'zpass'  => sha1($_POST['password']) ,
		                                     'zemail' => $_POST['email'],
		                                     'zfull'  => $_POST['fullName']
		                                     

		                                    ));

		                                      // echo success message 

		                                    $successMsg = $lang['CONGRATE_REGISTER'];
                                          
	                                        }
	                               }
            }
       }


?>
	<div class="container login-page">
     <h1 class="text-center">
     	<span class="selected" data-class="login"><?php echo $lang['LOG_IN']?></span> |
        <span data-class="signup"><?php echo $lang['SIGN_UP']?></span>
    </h1>

     <!-- start login form -->

		<form class="login" action="<?PHP echo $_SERVER['PHP_SELF'] ?> " method="POST">
		 <div class="input-container">
	    	<input
	    	 class="form-control"
	    	 type="text"
	    	 name="username"
	    	 autocomplete="off"
	    	 placeholder="<?php echo $lang['TYPE_USERNAME']?>" 
	    	 required />
         </div>
         <div class="input-container">
            <input
             class="form-control eye"
             type="password"
             name="password"
             autocomplete="new-password"
             placeholder="<?php echo $lang['TYPE_PASSWORD']?>" required/>
             <svg class="show-pass bi bi-eye" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
                <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
              </svg>
         </div>
             <div class="input-container">
             	<input class="btn btn-light btn-block login-btn" name='login' style='color:#fff' type="submit" value="<?php echo $lang['LOG_IN']?>" />
             </div>

		</form>
         <!-- end login form -->

		 <!-- start signup form -->

		<form class="signup" action="<?PHP echo $_SERVER['PHP_SELF'] ?> " method="POST">
		 <div class="input-container">
	    	<input
	    	
	    	 class="form-control"
	    	 type="text"
	    	 name="username"
	    	 autocomplete="off"
	    	 placeholder="<?php echo $lang['TYPE_USERNAME']?>" 
	    	 required
	    	 />
         </div>
          <div class="input-container">
            <input
             minlength ="6"
             class="form-control"
             type="password"
             name="password"
             autocomplete="new-password"
             placeholder="<?php echo $lang['TYPE_COMPLEX_PASSWORD']?>"
             required />
          </div>
          <div class="input-container">
             <input
              minlength ="6"
              class="form-control"
              type="password"
              name="password2"
              autocomplete="new-password"
              placeholder="<?php echo $lang['TYPE_PASSWORD_AGAIN']?>"
              required/>
          </div>
           <div class="input-container">
             <input
              class="form-control"
              type="email"
              name="email"
              placeholder="<?php echo $lang['TYPE_EMAIL']?>"
              required/>
           </div>
           <div class="input-container">
             <input
              class="form-control"
              type="full"
              name="fullName"
              placeholder="<?php echo $lang['TYPE_FULL_NAME']?>"
              required/>
           </div>
             <div class="input-container">
             	<input class="btn btn-light btn-block" name='signup' style='color:#fff' type="submit" value="<?php echo $lang['SIGN_UP']?>" />
             </div>
		</form>

		
		 <!-- end signup form -->

		 <div class="the-errors text-center">
			
          <?php
           
           if (!empty($formErrors)) {
             
             foreach ($formErrors as $error) {

             	echo "<div class ='msg error'>" . $error . "</div></br>";
             }
           }
           if (isset($successMsg)) {
             
             echo "<div class ='msg success'>" . $successMsg . "</div>";
           }

          ?>

		</div>
	</div>

	<div style="margin-top:240px;">
 <?php 
include $tbl."footer.php"; 

ob_end_flush();			?>
</div>
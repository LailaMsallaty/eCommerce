<?php 

/*
================================================================
== manage members page
== you can  add | edit | delete members from here 
================================================================

*/
 ob_start(); // output buffering start 

 session_start();

  $pageTitle = 'Members';
       
        if(isset($_SESSION['Username'])) // If there is a session already registered
{  

         

	           include 'init.php';


	           $do = isset($_GET['do']) ? $_GET['do']  : 'Manage';

	                 // start manage page

	          if ($do == 'Manage'){           // manage members page 

		       $query = '';

		           if (isset($_GET['page']) && $_GET['page'] =='Pending') {
		          
	               $query = 'WHERE RegStatus = 0';


		           }
               
                     // select all users except admins 
             
               $stmt = $conn ->prepare("SELECT * FROM users $query ORDER BY UserID DESC");

                     // execute the statement

               $stmt->execute();

                     // asign to variable

               $rows = $stmt->fetchAll();


               if (! empty($rows)) {
              
	          	?>
                 
                  <h1 class="text-center">Manage Members</h1>
			  
				  <div class="container">

					  	<div class="table-responsive">
					  		
					  		<table class="manage-members text-center main-table table table-bordered">
					  			
					  			 <tr>

					  				<td>#ID</td>
					  				<td>Avatar</td>
					  				<td>Username</td>
					  				<td>Email</td>
					  				<td>Full Name</td>
					  				<td>Registerd Date</td>
					  				<td>Control</td>

					  		     </tr>

					     <?php 
 
	                                   foreach ($rows as $row ) {
	                                   
	                                   echo "<tr>";
	                                   

	                                      echo "<td>" . $row['UserID'] . " </td>";
	                                      echo "<td>";

	                                      if ($row['avatar'] == '385-3856300_no-avatar-png.png') {
	                                      
	                                      	echo "<img src='385-3856300_no-avatar-png.png' alt =''/>";
	                                      	echo "<a href='members.php?do=Edit_Image&userid=". $row['UserID']."' class='btn btn-light avatar'><i class ='fa fa-edit'></i>Edit</a>";

	                                      }
	                                      
	                                     else{

	                                      	 echo "<img src='uploads/avatars/" . $row['avatar'] . "' alt =''/>";
	                                      	 echo "<a href='members.php?do=Edit_Image&userid=". $row['UserID']."' class='btn btn-light avatar'><i class ='fa fa-edit'></i>Edit</a>";
	                                      	 }
	                                      

	                                     
	                                      echo "</td>";
	                                      echo "<td>" . $row['Username'] . "</td>";
	                                      echo "<td>" . $row['Email'] . "   </td>";
	                                      echo "<td>" . $row['FullName'] . "</td>";
	                                      echo "<td> ". $row['Date'] ." </td>";
	                                      echo "<td>
													 <a href='members.php?do=Edit&userid=". $row['UserID']."' class='btn btn-light'><i class ='fa fa-edit'></i> Edit</a>";
													 if ($row['GroupID']==0) {
													 echo "<a href='members.php?do=Admin&userid=". $row['UserID']."' class='btn btn-light' style='background-color:#eee; color:#000 ; margin-left:5px'><i class ='fa fa-user'></i> Make Admin</a>";
													 }
						  					       echo " <a href='members.php?do=Delete&userid=". $row['UserID']."' class='btn btn-dark confirm'><i class='fas fa-times'></i> Delete</a>";

                                        if ($row['RegStatus']==0) {
                                         
                                           echo " <a href='members.php?do=Activate&userid=". $row['UserID']."' class='btn btn-info activate'><i class='fas fa-check'></i> Activate</a>";
                                        }

										
						  				  echo "</td>";
	                                   echo "</tr>";
 
	                                   }


					     ?>

					  		    
					  		</table>


					  	</div>

                         <a href='members.php?do=Add' class="btn btn-light"><i class="fa fa-plus"></i>&nbsp; New Member</a>

				  </div>
              
                  <?php }else{
                  	echo "<div class='container'>";
                    echo "<div class='nice-message'>There's No Member To Show</div>";
                     echo"<a href='members.php?do=Add' class='btn btn-light'><i class='fa fa-plus'></i>&nbsp; New Member</a>";

                  	echo "</div>";

                  	
                  } ?>


	         <?php }elseif ($do == 'Add') {  // Add members page ?> 
	          
	           </br>

			         <h1 class="text-center">Add New Member</h1>
			  
				         <div class="container">

				          	 <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
				          	 
		                        <!-- Start username field -->
		     
					          	 	<div class="form-group row justify-content-center">
					          	 		
		                               <label class="col-sm-2 col-form-label-lg">Username</label>

			                               <div class="col-sm-10 col-md-6 ">
			                               	  
			                               	  <input type="text" name="username" class="form-control form-control-lg"  autocomplete="off" required="required" placeholder="Username To Login Into Shop" />

			                               </div>

					          	 	</div>
		                        <!-- End username field -->

		                        <!-- Start password field -->

					          	 	<div class="form-group row justify-content-center">
					          	 		
		                               <label class="col-sm-2 col-form-label-lg">Password</label>

			                               <div class="col-sm-10 col-md-6">
			                               	 
			                               	  <input type="password" name="password" class="eye form-control form-control-lg" autocomplete="off" placeholder="Password Must Be Hard & Complex" required="required" />
												 <svg class="show-pass bi bi-eye" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
                                        <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                      </svg>

			                               </div>

					          	 	</div>
		                        <!-- End password field -->

		        

		           
		                        <!-- Start email field -->

					          	 	<div class="form-group row justify-content-center">
					          	 		
		                               <label class="col-sm-2 col-form-label-lg">Email</label>

			                               <div class="col-sm-10 col-md-6 ">
			                               	  
			                               	  <input type="email" name="email" class="form-control form-control-lg" required="required" placeholder="Email Must Be Valid" />

			                               </div>

					          	 	</div>
		                        <!-- End email field -->

		                        <!-- Start full name field -->

					          	 	<div class="form-group row justify-content-center">
					          	 		
		                               <label class="col-sm-2 col-form-label-lg">Full Name</label>

			                               <div class="col-sm-10 col-md-6">
			                               	  
			                               	  <input type="FullName" name="Full" class="form-control form-control-lg" required="required" placeholder="Full Name Appear In Your Profile Page" />

			                               </div>

					          	 	</div>
		                        <!-- End full name field -->
		       
		                        <!-- Start Avatar field -->

					          	 	<div class="form-group row justify-content-center">
					          	 		
		                               <label class="col-sm-2 col-form-label-lg">User Avatar</label>

			                               <div class="col-sm-10 col-md-6">
			                               	  
			                               	  <input type="file" name="avatar" class="form-control form-control-lg"required="required" />

			                               </div>

					          	 	</div>
		                        <!-- End Avatar field -->

		                        <!-- Start submit field -->

					          	 	<div class="form-group row justify-content-center">
					          	 		
			                               <div class=" col-sm-8 col-md-4 col-12 ">
			                               	  
			                               	  <input type="submit" value="Add Member" class="btn btn-light btn-lg" />

			                               </div>

					          	 	</div>
		                        <!-- End submit field -->

				          	 </form>

				         </div>

           

    <?php   }elseif ($do == 'Insert')

              {    // insert member page 
    	      


				     if($_SERVER['REQUEST_METHOD']=='POST')

				          {         

                                     echo "<h1 class='text-center'>Insert Member</h1>";
	                                 echo "<div class ='container'>";

	                                 // upload variable 

	                                 $avatar = $_FILES['avatar'];

	                                 $avatarName = $_FILES['avatar']['name'];
	                                 $avatarSize  = $_FILES['avatar']['size'];
	                                 $avatarTmp  = $_FILES['avatar']['tmp_name'];
	                                 $avatarType = $_FILES['avatar']['type'];

	                                 // List of allowed types to upload 

	                                 $avatarAllowedExtention = array("jpeg","jpg","png","gif");

	                                 // Get Avatar extention 

	                                 $avatarExtention = explode('.' ,$avatarName);
	                                 $end  = end($avatarExtention);
	                                 $str = strtolower($end);


                       
	            

                                 // get variables from the form

                                   $user      = $_POST['username'];
                                   $pass      = $_POST['password'];
                                   $email     = $_POST['email'];
                                   $name      = $_POST['Full'];


                                   $hashPass=sha1($_POST['password']);

	                                  // validate the form 

	                               $FormErrors =array();

	                               if (strlen($user) < 3) {

	                               $FormErrors[]  = "Username Can't Be Less Than <strong> 4 Characters </strong>";

	                               }

	                               if (strlen($user) > 20) {

	                               $FormErrors[]  = "Username Can't Be more Than <strong>20 Characters</strong>";

	                               }

	                               if (empty($user)) {

                                    $FormErrors[] = "Username Can't Be <strong>Empty</strong>";
	                               
	                               }
	                               
	                               if (empty($pass)) {

	                                $FormErrors[] = "Password Can't Be <strong>Empty</strong>";

	                               }
								   if (strlen($pass) < 6) {
                                  
									$FormErrors[] = "Password Can't Be Less Than 6";
								   }

	                               if (empty($name)) {

                                    $FormErrors[] = "Full Name Can't be <strong>Empty</strong>";
	                              
	                               }

	                               if (empty($email)) {

	                                $FormErrors[] = "Email Can't Be <strong>Empty</strong>";

	                               }

	                               if (empty($avatarName)) {
	                               	
	                               	$FormErrors[] = "Avatar is <strong>Required</strong>";

	                               }

	                               if (!empty($avatarName) && ! in_array($str, $avatarAllowedExtention)){

	                               	$FormErrors[] = "This Extention Is Not <strong>Allowed</strong>";

	                               }

	                       
	                               // 1024 byte * 4 = 4 kb = 4096 byte * 1024 = 4194304 byte = 4 mb

	                               if ($avatarSize > 4194304){

	                               	$FormErrors[] = "Avatar Can't Be Larger Than <strong>4 MB</strong>";

	                               }


	                                  // loop into error aray and echo it 

	                               foreach ($FormErrors as $error) {
	                                  
	                                  echo "<div class='alert alert-danger' role='alert'> " .  $error . "</div>";

	                               }
	                                  // check if there is no error proceed the update operation

	                                if (empty($FormErrors)) {

	                                
	                                    $avatar = rand() .'_'.$avatarName;

	                                    move_uploaded_file($avatarTmp, "uploads\avatars\\" .$avatar);
                                   
                                     
	                                   // check if user exist in database 

	                               	   $check= checkItem("Username" , "users" ,  $user);

	                                   if ($check == 1) {

	                               	     $TheMsg = "<div class ='alert alert-danger'>sorry this user is exist</div> ";
	                               	     redirectHome($TheMsg , 'back');

	                               	   }else{


	                                          // Insert User Info In Database
	                                       
	                                      $stmt = $conn ->prepare("INSERT Into users(Username ,Password ,Email ,FullName , RegStatus , Date ,avatar)
	                                                                VALUES (:zuser, :zpass, :zemail, :zname ,1, now() ,:zavatar)");

		                                  $stmt->execute(array(

		                                     'zuser'   => $user ,
		                                     'zpass'   => $hashPass ,
		                                     'zemail'  => $email ,
		                                     'zname'   => $name ,
		                                     'zavatar' => $avatar

		                                    ));

		                                      // echo success message 

		                                    $TheMsg = "<div class ='alert alert-success'>". $stmt->rowCount() . " Record Inserted </div>";
                                            redirectHome($TheMsg ,'back');

	                                        }
	                                	 }
			                         



				            }else{  

				            	   echo "<div class= 'container'>";


				            	   $TheMsg = "<div class ='alert alert-danger'>Sorry You Can Not Browse This Page Directly</div>";

				                   redirectHome($TheMsg , 'back');

				                   echo "</div>";

				                 }

                echo "</div>";
                     
                }

               elseif ($do == 'Edit')

                {

	                 // edit page 

                     // check if get request userid is numeric and get the integer value of it

	                 $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

	                 // echo $userid;

	                 // select all data depend on this ID

	                 $stmt = $conn -> prepare("SELECT * From  users  where  UserID =? ");

                     // excute query

			         $stmt -> execute(array($userid));

			         // fetch the data 

			         $row= $stmt -> fetch();

			         // the row count

			         $count = $stmt->rowCount();

                     // if there's such id show the form

	                if ( $count > 0) {
		           ?>

		          <!-- echo "Welcome to Edit Page your ID is  ". $_GET['userid']; -->
			      </br>

			         <h1 class="text-center">Edit <?php echo $row['Username'] ?></h1>
			  

				         <div class="container">

				          	 <form class="form-horizontal" action="?do=Update" method="POST">
				          	 	<input type="hidden" name="userid" value="<?php echo $userid ?>">

		                        <!-- Start username field -->
		     
					          	 	<div class="form-group row justify-content-center">
					          	 		
		                               <label class="col-sm-2 col-form-label-lg">Username</label>

			                               <div class="col-sm-10 col-md-6 ">
			                               	  
			                               	  <input type="text" name="username" class="form-control form-control-lg" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required" />

			                               </div>

					          	 	</div>
		                        <!-- End username field -->

		                        <!-- Start password field -->

					          	 	<div class="form-group row justify-content-center">
					          	 		
		                               <label class="col-sm-2 col-form-label-lg">Password</label>

			                               <div class="col-sm-10 col-md-6">
			                               	  
			                               	  <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
			                               	  <input type="password" name="newpassword" class="eye form-control form-control-lg" autocomplete="off" placeholder="Leave Blank if You Don't Want To Change" />
												 <svg class="show-pass bi bi-eye" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
                                        <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                      </svg>

			                               </div>

					          	 	</div>
		                        <!-- End password field -->

		        

		           
		                        <!-- Start email field -->

					          	 	<div class="form-group row justify-content-center">
					          	 		
		                               <label class="col-sm-2 col-form-label-lg">Email</label>

			                               <div class="col-sm-10 col-md-6 ">
			                               	  
			                               	  <input type="email" name="email" class="form-control form-control-lg"  value="<?php echo $row['Email'] ?>" required="required"/>

			                               </div>

					          	 	</div>
		                        <!-- End email field -->

		                        <!-- Start full name field -->

					          	 	<div class="form-group row justify-content-center">
					          	 		
		                               <label class="col-sm-2 col-form-label-lg">Full Name</label>

			                               <div class="col-sm-10 col-md-6">
			                               	  
			                               	  <input type="FullName" name="Full" class="form-control form-control-lg" value="<?php echo $row['FullName'] ?>" required="required"/>

			                               </div>

					          	 	</div>
		                        <!-- End full name field -->

		                        

		                        <!-- Start submit field -->

					          	 	<div class="form-group row justify-content-center">
					          	 		
			                               <div class=" col-sm-8 col-md-4 col-12 ">
			                               	  
			                               	  <input type="submit" value="Save" class="btn btn-light btn-lg" />

			                               </div>

					          	 	</div>
		                        <!-- End submit field -->

				          	 </form>

				         </div>



		         <?php 
  
			           // if there is no such id show error message 

			  }else{
                            echo "<div class ='container'>";

			                $TheMsg =  "<div class ='alert alert-danger'>There Is No Such ID </div>";

			                redirectHome($TheMsg);


			             	echo "</div>";

			                }

	          }elseif ($do == 'Update') { // Update page


	           echo "<h1 class='text-center'>Update Member</h1>";
	           echo "<div class ='container'>";


				     if($_SERVER['REQUEST_METHOD']=='POST')

				          {          


				          	         
				          	        
	                               

				                  // get the variables from the form 
                                        
                                       $id    = $_POST['userid'];
                                       $user  = $_POST['username'];
                                       $email = $_POST['email'];
                                       $name  = $_POST['Full'];

                                      
                                     

                                      // Password Trick

	                             $pass = '';

	                             $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

	                                  // validate the form 
								  $pass2 = $_POST['newpassword'];
	                               $FormErrors =array();

	                               if (strlen($user) < 3) {

	                               $FormErrors[]  = "Username Can't Be Less Than <strong> 3 Characters </strong>";

	                               }

	                               if (strlen($user) > 20) {

	                               $FormErrors[]  = "Username Can't Be more Than <strong>20 Characters</strong>";

	                               }

	                               if (empty($user)) {

                                    $FormErrors[] = "Username Can't Be <strong>Empty</strong>";
	                               
	                               }

	                               if (empty($name)) {

                                    $FormErrors[] = "Full Name Can't be <strong>Empty</strong>";
	                              
								   }
								   
								   $pass2 = $_POST['newpassword'];
								   if ($pass !== $_POST['oldpassword'] && strlen($pass2) < 6) {
									 
									$FormErrors[] = "Password Can't Be Less Than <strong>6 Characters</strong>";
  
								   }

	                               if (empty($email)) {

	                                $FormErrors[] = "Email Can't Be <strong>Empty</strong>";

	                               }

	                              
	                                  // loop into error aray and echo it 

	                               foreach ($FormErrors as $error) {
	                                  
	                                 echo "<div class ='alert alert-danger' role='alert'>" . $error . "</div>";

	                               }
	                                  // check if there is no error proceed the update operation

	                               if (empty($FormErrors)) {

                                     
                                   

                                     $stmt2 = $conn ->prepare("SELECT *
                                                               FROM 
                                                                   users
                                                               WHERE 
                                                                   Username = ? 
                                                               AND 
                                                                   UserID != ? ");

                                     $stmt2 -> execute(array($user , $id ));

                                     $count = $stmt2->rowCount();

                                    if ($count == 1  ){


                                    	$TheMsg = "<div class ='alert alert-danger'>Sorry This User Is Exist</div>";
	                                    
	                                    redirectHome($TheMsg , 'back');
                                    }else
	                                    {
	                                         // Update the database with this info 

	                                    $stmt = $conn ->prepare("UPDATE users SET Username =? , Email=? , FullName=? , Password =? WHERE UserID=? ");

	                                    $stmt -> execute(array($user ,$email ,$name,$pass,$id ));

	                                      // echo success message 

	                                   $TheMsg = "<div class ='alert alert-success'>". $stmt->rowCount() . " Record Updated </div>";
	                                    
	                                    redirectHome($TheMsg , 'back');


	                                    }
	                                
	                             }
	                           
			                         



				            }else{  

				                    $TheMsg ="<div class ='alert alert-danger'>Sorry You Can Not Browse This Page Directly</div>";

				                     redirectHome($TheMsg );

				                  
       
				                 }

                echo "</div>";

	 }elseif ($do == 'Edit_Image'){

               $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;


	           $stmt = $conn ->prepare("SELECT * FROM users WHERE UserID = ". $userid ."");

                     // execute the statement

               $stmt->execute();

                     // asign to variable

               $rows = $stmt->fetchAll();

	          
                  foreach ($rows as $row) {
                 
                    echo "<h1 class='text-center'>Edit ". $row['Username'] ."'s"." Avatar</h1>";
	                 echo "<div class ='container'>"; ?>
 
	               
                    <form class="form-horizontal" action="?do=Update_Image" method="POST" enctype="multipart/form-data" id="idForm">
                    	<input type="hidden" name="userid" value="<?php echo $userid ?>">

					  	<table align="center">					  		
					  		<tr>
					  			<th> </th>
					  			<td>					  				
								  	  <img src="<?php
							        if($row['avatar'] == '385-3856300_no-avatar-png.png')
							        echo $row['avatar'] ;
							        else echo "uploads/avatars/". $row['avatar']; ?>" style="width: 350px; height: 350px;" id ="imagepreview" alt="Image Preview"><br/>
							    	  	</br>
					  			</td>
					  		</tr>

					  	</table>
					  
				      <input type="hidden" name="photo" value="<?php echo $row['avatar'] ?>">
	                 		 <!-- Start Avatar field -->
                
					          	 	<div class="form-group row justify-content-center">
					          	 		
		                               <label class="col-sm-2 col-form-label-lg">User Avatar</label>

			                               <div class="col-sm-10 col-md-6">
			                               	  
			                               	  <input type="file" name="avatar" class="form-control form-control-lg" required="required"  id="idupload" />

			                               </div>

					          	 	</div>

					         <!-- end Avatar field -->



					          	 	<div class="form-group row justify-content-center">
					          	 		
			                               <div class=" col-sm-8 col-md-4 col-12 ">
			                               	  
			                               	  <input type="submit" value="Update" name="update" class="btn btn-light btn-lg" />

			                               </div>

					          	 	</div>

					  </form>
				</div>

				

          <?php

  }

 }elseif($do == 'Update_Image'){

 	 echo "<h1 class='text-center'>Update Member Avatar</h1>";
	           echo "<div class ='container'>";



 			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

					  	if (isset($_POST['update'])) {

					  			  

					  			   if (isset($_FILES['avatar']['name']) && !empty($_FILES['avatar']['name']))
					  			  {
					  			     

	                                 $avatarName  = $_FILES['avatar']['name'];
	                                 $avatarSize  = $_FILES['avatar']['size'];
	                                 $avatarTmp   = $_FILES['avatar']['tmp_name'];
	                                 $avatarType  = $_FILES['avatar']['type'];
	                                 $id          = $_POST['userid'];
	                               
	                                

	                                 // List of allowed types to upload 

	                                 $avatarAllowedExtention = array("jpeg","jpg","png","gif");

	                                 // Get Avatar extention 

	                                 $avatarExtention = explode('.' ,$avatarName);
	                                 $end  = end($avatarExtention);
	                                 $str = strtolower($end);

	                                 $FormErrors =array();

			                               if (!empty($avatarName) && ! in_array($str, $avatarAllowedExtention)){

			                               	$FormErrors[] = "This Extention Is Not <strong>Allowed</strong>";

			                               }

			                               if (empty($avatarName)){

			                               	$FormErrors[] = "Avatar Is <strong>Required</strong>";

			                               }
			                               // 1024 byte * 4 = 4 kb = 4096 byte * 1024 = 4194304 byte = 4 mb

			                               if ($avatarSize > 4194304){

			                               	$FormErrors[] = "Avatar Can't Be Larger Than <strong>4 MB</strong>";

			                               }


	                                  // loop into error aray and echo it 

			                               foreach ($FormErrors as $error)
				                               {
				                                  
				                                  echo "<div class='alert alert-danger' role='alert'> " .  $error . "</div>";

				                               }

					                       if (empty($FormErrors))
					                            {   

					                             $avatar = rand() .'_'. $avatarName;

												 if (move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar))

			                                          {
			                                       
				                                        
				                                        @unlink("uploads\avatars\\".$_POST['photo']."");
				                                      

				                            

					                               $stmt4= $conn-> prepare("UPDATE users
					                                                        SET avatar=? 
					                                                        WHERE UserID=? ");

				                                   $stmt4 -> execute(array($avatar, $id));
 

									                if ($stmt4) {

									                	

									                	 $TheMsg ="<div class ='alert alert-success'> Image Updated </div>";
			                                             redirectHome($TheMsg );
									                }

					                            	
												}else {
				                                      	
													echo "<div class ='alert alert-danger'>There Was An Error</div>";
					
												}
											}

					  	    	}

                       }else{  

				            	   echo "<div class= 'container'>";


				            	   $TheMsg = "<div class ='alert alert-danger'>Sorry you can't browse this page directly</div>";

				                   redirectHome($TheMsg , 'back');

				                   echo "</div>";

				                 }

		    	   echo "</div>";
	 		  ?>

					 
		                      
                    




     <?php }elseif ($do == 'Delete')   // Delete member page
                {
	                 echo "<h1 class='text-center'>Delete Member</h1>";
	                 echo "<div class ='container'>";
  

	                     // check if get request userid is numeric and get the integer value of it

		                 $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

		                 // echo $userid;

		                 // select all data depend on this ID

		                 

		                 $check = checkItem('UserID' , 'users' ,  $userid);

	                   

	                     // if there's such id show the form

		                if ( $check > 0 ) {
	                     
	                     $stmt = $conn -> prepare("DELETE From users WHERE UserID = :zuser");

	                     $stmt->bindParam(":zuser",$userid);

	                     $stmt->execute();

	                     $TheMsg = "<div class ='alert alert-success'> Record Deleted </div>";

                         redirectHome($TheMsg,'back');



		                }else{   
		                	     $TheMsg = "<div class ='alert alert-danger'>This ID Is Not Exist</div>";

		                         redirectHome($TheMsg ,'back');
				               

		                    }

	                echo "</div>";

	          }elseif ($do=='Activate') {
	          	
                   
	                 echo "<h1 class='text-center'>Activate Member</h1>";
	                 echo "<div class ='container'>";
  

	                     // check if get request userid is numeric and get the integer value of it

		                 $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

		                 // echo $userid;

		                 // select all data depend on this ID

		                 

		                 $check = checkItem('UserID' , 'users' ,  $userid);

	                   

	                     // if there's such id show the form

		                if ( $check > 0 ) {
	                     
	                     $stmt = $conn -> prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ? AND GroupID !=1");

	                     $stmt->execute(array($userid));

	                     $TheMsg = "<div class ='alert alert-success'>". $stmt->rowCount() . " Record Updated </div>";

                         redirectHome($TheMsg ,'back');



		                }else{   
		                	     $TheMsg = "<div class ='alert alert-danger'>This ID Is Not Exist</div>";

		                         redirectHome($TheMsg);
				               

		                    }

	                echo "</div>";


			  
			}elseif ($do=='Admin') {
	          	
                   
				echo "<h1 class='text-center'>Make Admin</h1>";
				echo "<div class ='container'>";


					// check if get request userid is numeric and get the integer value of it

					$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

					// echo $userid;

					// select all data depend on this ID

					

					$check = checkItem('UserID' , 'users' ,  $userid);

				  

					// if there's such id show the form

				   if ( $check > 0 ) {
					
					$stmt = $conn -> prepare("UPDATE users SET GroupID = 1 WHERE UserID = ? AND GroupID !=1");

					$stmt->execute(array($userid));

					$TheMsg = "<div class ='alert alert-success'>". $stmt->rowCount() . " Record Updated </div>";

					redirectHome($TheMsg ,'back');



				   }else{   
							$TheMsg = "<div class ='alert alert-danger'>This ID Is Not Exist</div>";

							redirectHome($TheMsg);
						  

					   }

			   echo "</div>";


		 }
	       

	          include $tbl."footer.php";
}

        else
	        {
	          
	          header('Location: index.php');
	          exit();

	        }
  ob_end_flush();

?>
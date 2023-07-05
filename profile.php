<?php  
ob_start();
session_start();

/*
================================================================
== manage prifile page
== you can edit profile from here 
================================================================

*/
  $pageTitle = 'Profile';

  include 'init.php';

 if (isset($_SESSION['user'])) {
     
    $getUser = $conn ->prepare(" SELECT * FROM users Where Username = ? ");

    $getUser->execute(array($sessionUser));

    $info = $getUser -> fetch();

    $userid = $info['UserID'];

    $do = isset($_GET['do']) ? $_GET['do']  : 'Manage';


    if ($do == 'Manage'){   

?>
    
    <h1 class="text-center"><?php echo $_SESSION['user']."".$lang['FOR']." ". $lang['PROFILE']?></h1>

    <div class="profile">

       <img class='img-fluid rounded-circle d-block m-auto' src="<?php
        if($info['avatar'] == '385-3856300_no-avatar-png.png')
        echo $info['avatar'] ;
        else echo "admin\uploads\avatars\\". $info['avatar']; ?>"  style="width: 300px; height: 300px;"/>

        <a href="profile.php?do=Edit_Image&userid=<?php echo $info['UserID'] ; ?>" class='btn btn-light'><i class ='fa fa-edit'></i>&nbsp; <?php echo $lang['EDIT_PHOTO']?></a>

    </div>
    	<div class="information block">
    		
    		<div class="container">
              <div class="card card-default">
                <div class="card-header"><?php echo $lang['MY_INFORMATION']?></div>
                <div class="card-body">
                	<ul class="list-unstyled"> 
                    <li>
                      <i class="fa fa-unlock-alt fa-fw"></i>
                      <span> <?php echo $lang['LOGIN_NAME']?></span> : <?php echo $info['Username'] ?>
                    </li>
                    <li>
                      <i class="fa fa-envelope fa-fw"></i>
                      <span> <?php echo $lang['EMAIL']?></span> : <?php echo $info['Email'] ?> 
                    </li>
                    <li>
                      <i class="fa fa-user fa-fw"></i>
                      <span> <?php echo $lang['FULL_NAME']?></span> : <?php echo $info['FullName'] ?>
                    </li>
                    <li>
                      <i class="fa fa-calendar fa-fw"></i>
                      <span> <?php echo $lang['REGISTER_DATE']?></span> : <?php echo $info['Date'] ?>
                    </li>
                    

                	</ul>
                  <a href='profile.php?do=Edit_Info&userid=<?php echo $info['UserID'] ; ?>' class='btn btn-light'><i class="fa fa-edit"></i>&nbsp; <?php echo $lang['EDIT_INFORMATION']?></a>
                </div>
              </div>

    	    </div>
    	</div>
    	<div id="my-ads" class="my-ads ">
    		
    		<div class="container">
              <div class="card card-primary">
               <div class="card-header"><?php echo $lang['MY_ITEMS']?></div>
                <div class="card-body">           	
	               
				<?php
                $myItems =getAllfrom ("*" , "items", "where Member_ID = $userid ","","Item_ID");
                  if (!empty($myItems)){

                       echo " <div class='row'>";

      		             foreach ($myItems as $item) {
                       
      		             	echo "<div class = ' col-sm-12 col-md-6 col-lg-3'>";
      		                    echo "<div class='card item-box-profile' style='height:600px' >";
                                  if ( $item['Approve'] == 0) {
                                      echo "<span class ='approve-status'>". $lang['WAITING_APPROVAL']."</span>";
                                   }
      		                       echo "<span class ='price-tag' >". $item['Price']." ".$lang['S.P']."</span>";
                                 
      	                           echo "<a href='profile.php?do=Edit_Img_Item&itemid=". $item['Item_ID']."'><img class='img-fluid img-item' src='admin\uploads\items\\".$item['item_photo']."' alt='' /></a>";

      	                           echo "<div class='caption' >";
                                    
      		                           echo "<h3><a href='items.php?itemid=" . $item['Item_ID'] . "'>" . $item['Name'] . "</a></h3>";
                                     echo "<p class='description' style=' margin-left: 10px ; height:80px;  '>" . $item['Description'] . "</p>";
                                     echo "<p>  <span style='color:#777;'>| ".$lang['QUANTITY']." : ".$item['quantity']."</span></p>";
                                     echo "<a href='profile.php?do=Edit_Item&itemid=". $item['Item_ID']."' class='btn btn-light btn-sm Edit_Item'><i class ='fa fa-edit'></i>&nbsp; ".$lang['EDIT']."</a>";
                                     echo "<a style='margin-top:-10px;' href='profile.php?do=Delete_Item&itemid=". $item['Item_ID']."' class='confirm btn btn-dark btn-sm delete_item ' style=' margin-bottom: 14px; margin-left:7px;'><i class='fas fa-trash-alt'></i>&nbsp; ".$lang['DELETE']."</a>";
                                     echo "<p class='country' style=' margin-left: 10px ;'>" . $item['Country_Made'] . "</p>";
                                      echo "<div class='date'>" . $item['Add_Date'] . "</div>";
      	                           echo "</div>";
      		                    echo "</div>";
      	                    echo "</div>";
      		             
      		             }
                       echo "</div>";
                     }else {

                     echo  $lang['NO_ITEM_TO_SHOW']."<a href ='newad.php' class='login-logout'>".$lang['NEW_ITEM']."</a>";

                     }

				?>
	               
                </div>
              </div>
    	    </div>
    	</div>

      <div id="my-ads" class="my-ads ">
    		
    		<div class="container">
              <div class="card card-primary">
               <div class="card-header"><?php echo $lang['SHOPPING_CARD'] ?></div>
                <div class="card-body">           	
	               
				<?php
         $stmt = $conn ->prepare("SELECT  items.* , card.*,users.*
                                            
         from items
         
         inner  join card

         on items.Item_ID = card.item_id
         
         inner join users

         on users.UserID = card.member_id
         where users.UserID = ?
         ");

        // execute the statement

        $stmt->execute(array($_SESSION['uid']));

        // asign to variable

        $items = $stmt->fetchAll();

                  if (!empty($items)){

                       echo " <div class='row'>";

      		             foreach ($items as $item) {
                       
      		             	echo "<div class = ' col-sm-12 col-md-6 col-lg-3'>";
      		                    echo "<div class='card item-box-profile' style='height:500px'>";
  
      		                       echo "<span class ='price-tag' >". $item['Price']." ".$lang['S.P']."</span>";
                                 echo "<div><img class='img-fluid img-item' src='admin\uploads\items\\".$item['item_photo']."' alt='' /></div>";

      	                           echo "<div class='caption'>";
      		                           echo "<h3><a href='items.php?itemid=" . $item['Item_ID'] . "'>" . $item['Name'] . "</a></h3>";
                                     echo "<p class='description' style=' margin-left: 10px ; height:80px;  '>" . $item['Description'] . "</p>";
                                     echo "<p>  <span style='color:#777;'>| ".$lang['QUANTITY']." : ".$item['quantity']."</span></p>";
                                      echo "<p class='country' style=' margin-left: 10px ;'>" . $item['Country_Made'] . "</p>";
                                     echo "<div class='date'>" . $item['Add_Date'] . "</div>";
      	                           echo "</div>";
      		                    echo "</div>";
      	                    echo "</div>";
      		             
      		             }
                       echo "</div>";
                     }else {

                     echo  $lang['NO_ITEM_TO_SHOW'];

                     }

				?>
	               
                </div>
              </div>
    	    </div>
    	</div>

    	<div class="my-comments block">
    		
    		<div class="container">
              <div class="card card-primary">
                <div class="card-header"><?php echo $lang['LATEST_COMMENT']?></div>
                <div class="card-body">
                	
                <?php
                     $myComments =getAllfrom("*" , "comments", "where user_id = $userid ","","c_id",);
			              

			               if (! empty($myComments)) {
			              
			                 foreach ( $myComments as $comment ) {
                        echo "<p>". $comment['comment'] ."<a  style='float:right; ,;' href='profile.php?do=Edit_comment&comid=".$comment['c_id']."' class='btn btn-light btn-sm Edit_Item'><i class ='fa fa-edit'></i>&nbsp; ".$lang['EDIT']."</a>
                      <a style='height:31px; margin-top:0px; color:#2c3e50; border:none; margin-right:3px; background-color: #eee; float:right;' href='profile.php?do=Delete_comment&comid=". $comment['c_id']."' class='confirm btn btn-dark btn-sm delete_item '><i class='fas fa-trash-alt'></i>&nbsp; ".$lang['DELETE']."</a></p>";
                        
			                 }



			               }else{

			              echo $lang['NO_COMMENT_TO_SHOW'];

			               }


                 ?>
                </div>
              </div>

    	    </div>
    	</div>





    </div>

     
 <?php   
          }elseif ($do == 'Edit_Image') {
           
               $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;


               $stmt = $conn ->prepare("SELECT * FROM users WHERE UserID = ". $userid ."");

                     // execute the statement

               $stmt->execute();

                     // asign to variable

               $rows = $stmt->fetchAll();

            
                  foreach ($rows as $row) {
                 
                    echo "<h1 class='text-center'>".$lang['EDIT'] ." ".$lang['AVATAR']."</h1>";
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
                      else echo "admin/uploads/avatars/". $row['avatar']; ?>" style="width: 350px; height: 350px;" id ="imagepreview" alt="Image Preview"><br/>
                        </br>
                  </td>
                </tr>

              </table>
            
              <input type="hidden" name="photo" value="<?php echo $row['avatar'] ?>">
                       <!-- Start Avatar field -->
                
                        <div class="form-group row justify-content-center">
                          
                                   <label class="col-sm-2 col-form-label-lg"><?php echo $lang['USER_AVATAR']?></label>

                                     <div class="col-sm-10 col-md-6">
                                        
                                        <input type="file" name="avatar" class="form-control form-control-lg" required="required" id="idupload"/>

                                     </div>

                        </div>

                   <!-- end Avatar field -->



                        <div class="form-group row justify-content-center">
                          
                                     <div class=" col-sm-8 col-md-4 col-12 ">
                                        
                                        <input type="submit" value="<?php echo $lang['UPDATE']?>" name="update" class="btn btn-light btn-lg" />

                                     </div>

                        </div>

            </form>
        </div>

        

          <?php

  }

      }elseif ($do == 'Update_Image') {

             echo "<h1 class='text-center'>".$lang['UPDATE']." ". $lang['AVATAR']."</h1>";
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

                                      $FormErrors[] = $lang['EXTENTION_NOT_ALLOWED'];

                                     }

                                     if (empty($avatarName)){

                                      $FormErrors[] =  $lang['AVATAR_IS_REQUIRED'];

                                     }
                                     // 1024 byte * 4 = 4 kb = 4096 byte * 1024 = 4194304 byte = 4 mb

                                     if ($avatarSize > 4194304){

                                      $FormErrors[] =  $lang['AVATAR_SIZE_VALIDATE'];

                                     }


                                    // loop into error aray and echo it 

                                     foreach ($FormErrors as $error)
                                       {
                                          
                                          echo "<div class='alert alert-danger' role='alert'> " .  $error . "</div>";

                                       }

                      if (empty($FormErrors))
                     {   

                                       $avatar = rand() .'_'. $avatarName;

                         if (move_uploaded_file($avatarTmp, "admin\uploads\avatars\\" . $avatar))

                                 {
                                             
                                                
                                                @unlink("admin\uploads\avatars\\".$_POST['photo']."");
                                              

                                             

                                         $stmt4= $conn-> prepare("UPDATE users
                                                                  SET avatar=? 
                                                                  WHERE UserID=? ");

                                           $stmt4 -> execute(array($avatar, $id));
 

                                  if ($stmt4) {

                                    

                                     $TheMsg ="<div class='container'><div class ='alert alert-success'>". $lang['IMAGE_UPDATED']." </div></div>";
                                                   redirectHome($TheMsg , 'back');
                                  }
                                }
                                else {
                                                
                                  echo "<div class ='alert alert-danger'>".  $lang['ERROR']." </div>";
                                }

                                        

                                              
                                             


                                             

                                          
                     }


                    }

                       }else{  

                         echo "<div class= 'container'>";


                         $TheMsg = "<div class ='alert alert-danger'>". $lang['BROWSE_DIRECTLY_ERROR']."</div>";

                           redirectHome($TheMsg , 'back');

                           echo "</div>";

                         }

             echo "</div>";
        

           
                          
          }elseif ($do=='Edit_Info') {
          
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

               <h1 class="text-center"><?php echo $_SESSION['user'];  ?> <?php echo $lang['INFORMATION']?></h1>
        

                 <div class="container">

                     <form class="form-horizontal" action="?do=Update_Info" method="POST">
                      <input type="hidden" name="userid" value="<?php echo $userid ?>">

                            <!-- Start username field -->
         
                        <div class="form-group row justify-content-center">
                          
                                   <label class="col-sm-2 col-form-label-lg"><?php echo $lang['USERNAME']?></label>

                                     <div class="col-sm-10 col-md-6 info">
                                        
                                        <input type="text" name="username" class="form-control form-control-lg" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required" />

                                     </div>

                        </div>
                            <!-- End username field -->

                             <!-- Start password field -->

                        <div class="form-group row justify-content-center">
                          
                                   <label class="col-sm-2 col-form-label-lg"><?php echo $lang['PASSWORD']?></label>

                                     <div class="col-sm-10 col-md-6">
                                        
                                        <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
                                       
                                        <input type="password" name="newpassword"  class="eye form-control form-control-lg" autocomplete="off" placeholder="<?php echo $lang['password_placeholder']?>" />
                                        <svg class="show-pass bi bi-eye" width="2em" height="2em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
                                        <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                      </svg>

                                      
                                     </div>
                                     

                        </div>
                       
		                
                 
		                 
                            <!-- End password field -->

                            <!-- Start email field -->

                        <div class="form-group row justify-content-center">
                          
                                   <label class="col-sm-2 col-form-label-lg"><?php echo $lang['EMAIL']?></label>

                                     <div class="col-sm-10 col-md-6 info">
                                        
                                        <input type="email" name="email" class="form-control form-control-lg"  value="<?php echo $row['Email'] ?>" required="required"/>

                                     </div>

                        </div>
                            <!-- End email field -->

                            <!-- Start full name field -->

                        <div class="form-group row justify-content-center">
                          
                                   <label class="col-sm-2 col-form-label-lg"><?php echo $lang['FULL_NAME']?></label>

                                     <div class="col-sm-10 col-md-6 info">
                                        
                                        <input type="FullName" name="Full" class="form-control form-control-lg" value="<?php echo $row['FullName'] ?>" required="required"/>

                                     </div>

                        </div>
                            <!-- End full name field -->

                            

                            <!-- Start submit field -->

                        <div class="form-group row justify-content-center">
                          
                                     <div class=" col-sm-8 col-md-4 col-12 ">
                                        
                                        <input type="submit" value="<?php echo $lang['SAVE']?>" class="btn btn-light btn-lg" />

                                     </div>

                        </div>
                            <!-- End submit field -->

                     </form>

                 </div>



             <?php 


          }

        }elseif ($do =='Update_Info') {
        
            echo "<h1 class='text-center'>". $lang['UPDATE']." ". $lang['INFORMATION']."</h1>";
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

                                 $FormErrors =array();

                                 if (strlen($user) < 3) {

                                 $FormErrors[]  = $lang['USERNAME_VALIDATE'];

                                 }

                                 if (strlen($user) > 20) {

                                 $FormErrors[]  = $lang['USERNAME_VALIDATE2'];

                                 }

                                 if (empty($user)) {

                                    $FormErrors[] = $lang['EMPTY_USERNAME'];
                                 
                                 }

                                 if (empty($name)) {

                                    $FormErrors[] = $lang['EMPTY_FULLNAME'];
                                
                                 }

                                 if (empty($email)) {

                                  $FormErrors[] = $lang['EMPTY_EMAIL'];

                                 }
                                 $pass2 = $_POST['newpassword'];
                                 if ($pass !== $_POST['oldpassword'] && strlen($pass2) < 6) {
                                   
                                  $FormErrors[] = $lang['PASSWORD_VALIDATE2'];

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


                                      $TheMsg = "<div class='container'><div class ='alert alert-danger'>".$lang['CHECK_USER_IF_EXIST']."</div></div>";
                                      
                                      redirectHome($TheMsg , 'back');
                                    }else
                                      {
                                           // Update the database with this info 
                                      
                                      $stmt = $conn ->prepare("UPDATE users SET Username =? , Email=? , FullName=? ,Password =? WHERE UserID=? ");

                                      $stmt -> execute(array($user ,$email ,$name , $pass ,$id ));

                                      session_unset();

                                      /*$getUser = $conn ->prepare(" SELECT * FROM users Where Username = ? ");

                                      $getUser->execute(array($sessionUser));

                                      $info = $getUser -> fetch();

                                       $_SESSION['ID'] = $info['Username'];  //register session ID
                                       $_SESSION['pass'] = $info['Password']; */


                                        // echo success message 
              

                                     $TheMsg = "<div class='container'><div class ='alert alert-success'>".$lang['INFO_UPDATED']."  ". $stmt->rowCount() . "</div></div>";
                                      
                                      redirectHome($TheMsg , 'back');


                                      }
                                  
                               }
                             
                               



                    }else{  

                            $TheMsg ="<div class='container'><div class ='alert alert-danger'>".$lang['BROWSE_DIRECTLY_ERROR']."</div></div>";

                             redirectHome($TheMsg );

                          
       
                         }

                echo "</div>";

        }elseif ($do == 'Edit_Item'){
         
                 
                   // edit page 

                     // check if get request itemid is numeric and get the integer value of it

                   $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

                   // echo $userid;

                   // select all data depend on this ID

                   $stmt = $conn -> prepare("SELECT * From  items  where  Item_ID =?");

                     // excute query

                   $stmt -> execute(array($itemid));

                   // fetch the data 

                   $item= $stmt -> fetch();

                   // the row count

                   $count = $stmt->rowCount();

                     // if there's such id show the form

                  if ( $count > 0) {
               ?>

                </br>

                   <h1 class="text-center"><?php echo $item['Name'] ?> <?php echo $lang['EDIT'] ?> </h1>
            
                     <div class="container">

                         <form class="form-horizontal" action="?do=Update_Item" method="POST">
                          <input type="hidden" name="itemid" value="<?php echo $itemid ?>">

                         
                                <!-- Start Name field -->
             
                            <div class="form-group row justify-content-center">
                              
                                       <label class="col-sm-2 col-form-label-lg"><?php echo $lang['NAME']?></label>

                                         <div class="col-sm-10 col-md-6 ">
                                            
                                            <input type="text" name="name" class="form-control form-control-lg"  placeholder="<?php echo $lang['PLACEHOLDER_ITEM_NAME']?>" required="required" value="<?php echo $item['Name'] ?>" />

                                         </div>

                            </div>
                                <!-- End Name field -->

                                 <!-- Start Description field -->
             
                            <div class="form-group row justify-content-center">
                              
                                       <label class="col-sm-2 col-form-label-lg"><?php echo $lang['DESCRIPTION']?></label>

                                         <div class="col-sm-10 col-md-6 ">
                                            
                                            <textarea  pattern =".{10,}"
                                              title ="This Field Require At Least 10 Characters" name="description" id="" cols="30" rows="3" class="form-control form-control-lg live" placeholder="<?php echo $lang['PLACEHOLDER_ITEM_DESCRIPTION']?>" 
                                            data-class =".live-desc" required><?php echo $item['Description'] ?></textarea>

                                         </div>

                            </div>
                                <!-- End Description field -->    

                                <!-- Start Price field -->
             
                            <div class="form-group row justify-content-center">
                              
                                       <label class="col-sm-2 col-form-label-lg"><?php echo $lang['PRICE']?></label>

                                         <div class="col-sm-10 col-md-6 ">
                                            
                                            <input type="text" name="price" class="form-control form-control-lg" placeholder="<?php echo $lang['PLACEHOLDER_ITEM_PRICE']?>" required="required" value="<?php echo $item['Price'] ?>"/>

                                         </div>

                            </div>
                                <!-- End Price field -->      

                                <!-- Start Country field -->
             
                            <div class="form-group row justify-content-center">
                              
                                       <label class="col-sm-2 col-form-label-lg"><?php echo $lang['COUNTRY']?></label>

                                         <div class="col-sm-10 col-md-6 ">
                                            
                                            <input type="text" name="country" class="form-control form-control-lg"  placeholder="<?php echo $lang['PLACEHOLDER_ITEM_COUNTRY']?>" required="required" value="<?php echo $item['Country_Made'] ?>"/>

                                         </div>

                            </div>
                                <!-- End Country field -->  

                                <!-- Start Status field -->
             
                            <div class="form-group row justify-content-center">
                              
                                       <label class="col-sm-2 col-form-label-lg"><?php echo $lang['STATUS']?></label>

                                         <div class="col-sm-10 col-md-6 ">                
                                            <select name="status">
          
                                              <option value="1" <?php if ($item['Status']==1){ echo "selected";}?>><?php echo $lang['NEW']?></option>
                                              <option value="2" <?php if ($item['Status']==2){ echo "selected";}?>><?php echo $lang['LIKE_NEW']?></option>
                                              <option value="3" <?php if ($item['Status']==3){ echo "selected";}?>><?php echo $lang['USED']?></option>
                                              <option value="4" <?php if ($item['Status']==4){ echo "selected";}?>><?php echo $lang['VERY_OLD']?></option>
                                            </select>

                                         </div>

                            </div>
                                <!-- End Status field -->   


                                 <!-- Start Categories field -->
             
                            <div class="form-group row justify-content-center">
                              
                                       <label class="col-sm-2 col-form-label-lg"><?php echo $lang['CATEGORY']?></label>

                                         <div class="col-sm-10 col-md-6 ">                
                                            <select name="category">
                                            <?php 

                                       $stmt2 = $conn ->prepare("SELECT * FROM categories");

                               $stmt2 -> execute();

                               $cats =  $stmt2 -> fetchAll();

                               foreach ($cats as $Cat ) {
                                echo "<option value ='".$Cat['ID']."'";   
                                if ( $item['Cat_ID'] == $Cat['ID'] ) { echo "selected" ; }
                                if (isset($_SESSION['lang']) && $_SESSION['lang']=='ar' ) {
                                  echo ">".$Cat['ar_Name']."</option>";
                                 }else
                                  echo ">".$Cat['Name']."</option>";
                               }
                                 
                                         ?>
                                            </select>

                                         </div>

                            </div>
                                <!-- End Categories field -->              

                                <!-- Start Tags field -->
             
                            <div class="form-group row justify-content-center">
                              
                                       <label class="col-sm-2 col-form-label-lg"><?php echo $lang['TAGS']?></label>

                                         <div class="col-sm-10 col-md-6 ">
                                            
                                            <input type="text" name="tags" class="form-control form-control-lg"  placeholder="<?php echo $lang['PLACEHOLDER_ITEM_TAGS']?>" value="<?php echo $item['tags'] ?>" />

                                         </div>

                            </div>
                                <!-- End Tags field -->     

                                <!-- Start qty field -->
                                
                                   <div class="form-group row justify-content-center">
                                                
                                                <label class="col-sm-2 col-form-label-lg"><?php echo $lang['QUANTITY']?></label>

                                                  <div class="col-sm-10 col-md-6">
                                                      
                                                      <input type="text" name="qty" class="form-control form-control-lg" required="required" placeholder="<?php echo $lang['PLACEHOLDER_ITEM_QUANTITY']?>" value="<?php echo $item['quantity'] ?>" />

                                                  </div>

                                      </div>
                                <!-- End qty field -->                                        
                                                               
               
                                <!-- Start submit field -->

                            <div class="form-group row justify-content-center">
                              
                                         <div class=" col-sm-8 col-md-4 col-12 ">
                                            
                                            <input type="submit" value="<?php echo $lang['SAVE_ITEM']?>" class="btn btn-light btn-lg" />

                                         </div>

                            </div>
                                <!-- End submit field -->

                         </form>
              

                    </div>

               <?php 
  
                 // if there is no such id show error message 

        }else{
                            echo "<div class ='container'>";

                      $TheMsg =  "<div class='container'><div class ='alert alert-danger'>".$lang['NO_SUCH_ITEM']."</div></div>";

                      redirectHome($TheMsg);


                    echo "</div>";

                      }

    }elseif ($do == 'Update_Item') {
      
        echo "<h1 class='text-center'>".$lang['UPDATE_ITEM']."</h1>";
                 echo "<div class ='container'>";


             if($_SERVER['REQUEST_METHOD']=='POST')

                  {           // get the variables from the form 
                                        
                                       $id    = $_POST['itemid'];
                                       $name  = $_POST['name'];
                                       $desc = $_POST['description'];
                                       $price  = $_POST['price'];
                                       $country  = $_POST['country'];
                                       $status  = $_POST['status'];
                                       $cat  = $_POST['category'];
                                       $tags  = $_POST['tags'];
                                       $qty  = $_POST['qty'];

                                    // validate the form 

                                 $FormErrors =array();

                                 if (empty($name)) {

                                 $FormErrors[]  = $lang['ITEM_NAME_VALIDATE'];

                                 }

                                   if (strlen($name) < 3) {

                                    $FormErrors[]  = $lang['ITEM_NAME_VALIDATE2'];

                                    }

                                 if (empty($desc)) {

                                 $FormErrors[]  = $lang['ITEM_DESCRIPTION_VALIDATE'];

                                 }

                                 if (strlen($desc) > 100) {

                                    $FormErrors[]  = $lang['ITEM_DESCRIPTION_VALIDATE2'];

                                    }

                                 if (strlen($desc) < 10) {

                                      $FormErrors[]  = $lang['ITEM_DESCRIPTION_VALIDATE3'];

                                      }


                                 if ($price < 0 || $price ==0 ) {

                                  $FormErrors[] = $lang['ITEM_PRICE_VALIDATE2'];
                               
                               }

                                 if ($qty < 0) {

                                  $FormErrors[] = $lang['ITEM_QTY_VALIDATE'];
                            
                                }

                                 if (empty($country)) {

                                    $FormErrors[] = $lang['ITEM_COUNTRY_VALIDATE'];

                                 }

                                 if (strlen($country) < 3)
            {
 
                                  $FormErrors[]  = $lang['ITEM_COUNTRY_VALIDATE2'];
                       
                                  }

                                 if ($status == 0) {

                                    $FormErrors[] = $lang['ITEM_STATUS_VALIDATE'];
                                
                                 }
                               
                                 if ($cat == 0) {

                                    $FormErrors[] = $lang['ITEM_CATEGORY_VALIDATE'];
                                
                                 }
                               

                                    // loop into error aray and echo it 

                                 foreach ($FormErrors as $error) {
                                    
                                    echo "<div class='alert alert-danger' role='alert'> " .  $error . "</div>";

                                 }
                                    // check if there is no error proceed the update operation

                                 if (empty($FormErrors)) {
                                   

                                   $stmt = $conn ->prepare("UPDATE items SET Name =? , Description=? , Price=? , Country_Made =? , Status= ? ,Cat_ID = ? , tags =? ,quantity =? WHERE Item_ID=? ");

                                   $stmt ->execute(array($name , $desc , $price , $country , $status , $cat, $tags , $qty ,$id));

                                      // echo success message 

                                   $TheMsg = "<div class='container'><div class ='alert alert-success'>". $lang['INFO_UPDATED']." ". $stmt->rowCount() . " </div></div>";
                                    
                                    redirectHome($TheMsg , 'back');

                                   
                                 }
                                // Update the database with this info 



                    }else{  

                            $TheMsg ="<div class='container'><div class ='alert alert-danger'>".$lang['BROWSE_DIRECTLY_ERROR']."</div></div>";

                             redirectHome($TheMsg );

                          
       
                         }

                echo "</div>";
    }elseif ($do=='Edit_Img_Item') {
     
           $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;


             $stmt = $conn ->prepare("SELECT * FROM items WHERE Item_ID = ". $itemid ."");

                     // execute the statement

               $stmt->execute();

                     // asign to variable

               $rows = $stmt->fetchAll();

            
                  foreach ($rows as $row) {
                 
                    echo "<h1 class='text-center'>".$lang['EDIT']." ".$lang['PHOTO']."</h1>";
                   echo "<div class ='container'>"; ?>
 
                 
                    <form class="form-horizontal" action="?do=Update_Imag_Item" method="POST" enctype="multipart/form-data" id="idForm">
                      <input type="hidden" name="itemid" value="<?php echo $itemid ?>">

              <table align="center">                
                <tr>
                  <th> </th>
                  <td>                    
                      <img src="admin\uploads\items\\<?php echo $row['item_photo'] ?>" style="width: 350px; height: 350px;"  id ="imagepreview" alt="Image Preview"><br/>
                        </br>
                  </td>
                </tr>

              </table>
            
              <input type="hidden" name="photo" value="<?php echo "admin\uploads\items\\".$row['item_photo'] ?>">
                       <!-- Start Avatar field -->
                
                        <div class="form-group row justify-content-center">
                          
                                   <label class="col-sm-2 col-form-label-lg"><?php echo $lang['ITEM_PHOTO']?></label>

                                     <div class="col-sm-10 col-md-6">
                                        
                                        <input type="file" name="image" class="form-control form-control-lg" required="required"  id="idupload"/>

                                     </div>

                        </div>

                   <!-- end Avatar field -->



                        <div class="form-group row justify-content-center">
                          
                                     <div class=" col-sm-8 col-md-4 col-12 ">
                                        
                                        <input type="submit" value="<?php echo $lang['UPDATE']?>" name="update" class="btn btn-light btn-lg" />

                                     </div>

                        </div>

            </form>
        </div>

        

          <?php

               }

    }elseif ($do == 'Update_Imag_Item') {
       
        echo "<h1 class='text-center'>". $lang['UPDATE_ITEM_IMAGE']."</h1>";
             echo "<div class ='container'>";



      $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

              if (isset($_POST['update'])) {

                    

                     if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
                    {
                       

                                   $photoName  = $_FILES['image']['name'];
                                   $photoSize  = $_FILES['image']['size'];
                                   $photoTmp   = $_FILES['image']['tmp_name'];
                                   $photoType  = $_FILES['image']['type'];
                                   $id         = $_POST['itemid'];
                                 
                                  

                                   // List of allowed types to upload 

                                   $photoAllowedExtention = array("jpeg","jpg","png","gif");

                                   // Get Avatar extention 

                                   $photoExtention = explode('.' ,$photoName);
                                   $end  = end($photoExtention);
                                   $str = strtolower($end);

                                   $FormErrors =array();

                                     if (!empty($photoName) && ! in_array($str, $photoAllowedExtention)){

                                      $FormErrors[] = $lang['ITEM_PHOTO_VALIDATE'];

                                     }

                                     if (empty($photoName)){

                                      $FormErrors[] = $lang['ITEM_PHOTO_VALIDATE2'];;

                                     }
                                     // 1024 byte * 4 = 4 kb = 4096 byte * 1024 = 4194304 byte = 4 mb

                                     if ($photoSize > 4194304){

                                      $FormErrors[] = $lang['ITEM_PHOTO_VALIDATE3'];;

                                     }


                                    // loop into error aray and echo it 

                                     foreach ($FormErrors as $error)
                                       {
                                          
                                          echo "<div class='alert alert-danger' role='alert'> " .  $error . "</div>";

                                       }

                                 if (empty($FormErrors))
                                      {   
                                         $photo = rand() .'_'. $photoName;
                                          if (move_uploaded_file($photoTmp, "admin\uploads\items\\" . $photo))

                                                {
                                             
                                           
                                                @unlink("admin\uploads\items\\".$_POST['photo']."");
                                              

                                             


                                         $stmt4= $conn-> prepare("UPDATE items
                                                                  SET item_photo=? 
                                                                  WHERE Item_ID=? ");

                                           $stmt4 -> execute(array($photo, $id));
 

                                  if ($stmt4) {

                                    

                                     $TheMsg ="<div class='container'><div class ='alert alert-success'>". $lang['IMAGE_UPDATED']." </div></div>";
                                                   redirectHome($TheMsg , 'back');
                                  }

                              
                                        }else {
                                                
                                                echo "<div class ='alert alert-danger'>". $lang['ERROR']." </div>";
                                                
                                              }   
                                       }


                    }

                       }else{  

                         echo "<div class= 'container'>";


                         $TheMsg = "<div class='container'><div class ='alert alert-danger'>". $lang['BROWSE_DIRECTLY_ERROR']."</div></div>";

                           redirectHome($TheMsg , 'back');

                           echo "</div>";

                         }

             echo "</div>";

             
         }elseif ($do == 'Delete_Item'){
	       
              echo "<h1 class='text-center'>".$lang['DELETE']." ".$lang['ITEM']."</h1>";
              echo "<div class ='container'>";


                  // check if get request itemid is numeric and get the integer value of it

                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

                // echo $userid;

                // select all data depend on this ID

                

                $check = checkItem('Item_ID' , 'items' ,  $itemid);

                

                  // if there's such id show the form

               if ( $check > 0 ) {
                  
                  $stmt = $conn -> prepare("DELETE From items WHERE Item_ID = :zitem");

                  $stmt->bindParam(":zitem",$itemid);

                  $stmt->execute();

                  $TheMsg = "<div class='container'><div class ='alert alert-success'>".$lang['RECORD_DELETED'] ."</div></div>";

                    redirectHome($TheMsg ,'back');



               }else{   
                      $TheMsg = "<div class='container'><div class ='alert alert-danger'>".$lang['ID_NOT_EXIT']."</div></div>";

                        redirectHome($TheMsg);
                  

                   }

             echo "</div>";
?>
        
          

 <?php  
    }

  elseif ($do == 'Edit_comment')

 {

            // edit page 

              // check if get request userid is numeric and get the integer value of it

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

            // echo $userid;

            // select all data depend on this ID

            $stmt = $conn -> prepare("SELECT * From  comments  where  c_id =? ");

              // excute query

        $stmt -> execute(array($comid));

        // fetch the data 

        $row= $stmt -> fetch();

        // the row count

        $count = $stmt->rowCount();

              // if there's such id show the form

           if ( $count >0) {
        ?>

       <!-- echo "Welcome to Edit Page your ID is  ". $_GET['userid']; -->
     </br>

        <h1 class="text-center"><?php echo $lang['EDIT_COMMENT']?></h1>
 

          <div class="container">

              <form class="form-horizontal" action="?do=Update_comment" method="POST">
                <input type="hidden" name="comid" value="<?php echo $comid ?>">

                     <!-- Start comment field -->
  
                  <div class="form-group row justify-content-center">
                    
                            <label class="col-sm-2 col-form-label-lg"><?php echo $lang['COMMENT']?></label>

                              <div class="col-sm-10 col-md-6 ">  
                                  <textarea class="form-control" name="comment"><?php echo $row['comment']; ?></textarea>
                              </div>

                  </div>
                     <!-- End comment field -->

                     <!-- Start submit field -->

                  <div class="form-group row justify-content-center">
                    
                              <div class=" col-sm-8 col-md-4 col-12 ">
                                  
                                  <input type="submit" value="<?php echo $lang['SAVE']?>" class="btn btn-light btn-lg" />

                              </div>

                  </div>
                     <!-- End submit field -->

              </form>

          </div>



      <?php 

          // if there is no such id show error message 

 }else{
                

               $TheMsg =  "<div class ='container'><div class ='alert alert-danger'>".$lang['NO_SUCH_ID']."</div><div>";

               redirectHome($TheMsg);


             
               }

     }elseif ($do == 'Update_comment') { // Update page


      echo "<h1 class='text-center'>".$lang['UPDATE_COMMENT']."</h1>";
      


      if($_SERVER['REQUEST_METHOD']=='POST')

           {           // get the variables from the form 
                                 
                                $comid    = $_POST['comid'];
                                $comment  = $_POST['comment'];
                            


                             

                         // Update the database with this info 


                         $stmt = $conn ->prepare("UPDATE comments SET comment =?  WHERE c_id=? ");

                         $stmt -> execute(array($comment ,$comid));

                           // echo success message 

                        $TheMsg = "<div class ='container'><div class ='alert alert-success'>". $lang['INFO_UPDATED'] ." ". $stmt->rowCount() . "</div></div>";
                         
                         redirectHome($TheMsg , 'back');

                            
                         
                        



             }else{  

                     $TheMsg ="<div class ='container'><div class ='alert alert-danger'>".$lang['BROWSE_DIRECTLY_ERROR']."</div></div>";

                      redirectHome($TheMsg );

                   

                  }

        

     }elseif ($do == 'Delete_comment')   // Delete  page
         {
            echo "<h1 class='text-center'>".$lang['DELETE_COMMENT']."</h1>";
           


                // check if get request comid is numeric and get the integer value of it

              $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;


              // select all data depend on this ID

              

              $check = checkItem('c_id' , 'comments' ,  $comid);

              

                // if there's such id show the form

             if ( $check > 0 ) {
                
                $stmt = $conn -> prepare("DELETE From comments WHERE c_id = :zcom");

                $stmt->bindParam(":zcom",$comid);

                $stmt->execute();

                $TheMsg = "<div class ='container'><div class ='alert alert-success'>". $lang['RECORD_DELETED']."</div></div>";

                  redirectHome($TheMsg ,'back');



             }else{   
                    $TheMsg = "<div class ='container'><div class ='alert alert-danger'>".$lang['ID_NOT_EXIT']."</div></div>";

                      redirectHome($TheMsg);
                

                 }

         
      }  
     }else{
     
       header('Location: login.php');
       exit();

     }
    ?>   
    <div style="margin-top:300px;">
    <?php 
  include $tbl."footer.php"; 

  ob_end_flush();			?>
  </div>
    
  <?php

<?php

/*
**
** Items Page
**
*/

 ob_start();  // output buffering start 

 session_start();

 $pageTitle = 'Items';


   if(isset($_SESSION['Username'])) // If there is a session already registered
{  

           include 'init.php';


	           $do = isset($_GET['do']) ? $_GET['do']  : 'Manage';

	                 

		          if ($do == 'Manage'){        // manage items page 


            
             
               $stmt = $conn ->prepare("SELECT
                                              items.*,
                                              categories.Name AS Category_name ,
                                              users.Username
                                        FROM
                                              items 
									    INNER JOIN
										      categories
								        ON
										        categories.ID = items.Cat_ID
								        INNER JOIN 
										      users
									    ON
										        users.UserID = items.Member_ID
										ORDER BY Item_ID desc");

                     // execute the statement

               $stmt->execute();

                     // asign to variable

               $items = $stmt->fetchAll();



               if (!empty($items)) {
                    	
	          	?>
                 
                  <h1 class="text-center">Manage Items</h1>
			  
				  <div class="container">

					  	<div class="table-responsive">
					  		
					  		<table  class="manage-items text-center main-table table table-bordered">
					  			
					  			 <tr>

					  				<td>#ID</td>
					  				<td>Photo</td>
					  				<td>Name</td>
					  				<td>Description</td>
					  				<td>Price</td>
					  				<td>Adding Date</td>
					  				<td>Category</td>
									<td>Status</td>
					  				<td>Username</td>
									<td>Quantity</td>
					  				<td>Control</td>

					  		     </tr>

					     <?php 
 
	                                   foreach ($items as $item ) {
	                                   
	                                   echo "<tr>";
	                                      echo "<td>" . $item['Item_ID'] . "  </td>";
	                                      echo "<td>";
	                                      echo "<img  src='uploads/items/" . $item['item_photo'] . "' alt =''/>";
	                                      	 echo "<a href='items.php?do=Edit_Image&itemid=". $item['Item_ID']."' class='btn btn-light  avatar'><i class ='fa fa-edit'></i>Edit</a>";
	                                      echo "</td>";
	                                      echo "<td>" . $item['Name'] . "</td>";
	                                      echo "<td>" . $item['Description'] . "   </td>";
	                                      echo "<td>" . $item['Price'] . "</td>";
	                                      echo "<td> ". $item['Add_Date'] ." </td>";
										  echo "<td> ". $item['Category_name'] ." </td>";
										  echo "<td> ";
										   if ($item['Status']==1){
											echo "New";}
											else if($item['Status']==2){  echo "like New";}
											else if($item['Status']==3){ echo "Used";}
											else{echo "Old";}
										    echo "</td> ";
										  echo "<td> ". $item['Username'] ." </td>";
										  echo "<td>" . $item['quantity'] . "  </td>";
	                                      echo "<td>
	                                                 <a href='items.php?do=Edit&itemid=". $item['Item_ID']."' class='btn btn-light'><i class ='fa fa-edit'></i> Edit</a>
						  					         <a href='items.php?do=Delete&itemid=". $item['Item_ID']."' class='btn btn-dark confirm'><i class='fas fa-times'></i> Delete</a>";
						  		        if ($item['Approve']==0) {
                                         
                                           echo " <a href='items.php?do=Approve&itemid=". $item['Item_ID']."' class='btn btn-info activate' style='margin-top:2px;'><i class='fas fa-check'></i></a>";
                                        }


											echo "</td>";

	                                   echo "</tr>";
 
	                                   }


					     ?>

					  		    
					  		</table>


					  	</div>

                         <a href='items.php?do=Add' class="btn btn-light"><i class="fa fa-plus"></i>&nbsp; New Item</a>

				  </div>
              
                <?php }else{
                  	echo "<div class='container'>";
                      echo "<div class='nice-message'>There's No Item To Show</div>";
                    echo "<a href='items.php?do=Add' class='btn btn-light'><i class='fa fa-plus'></i>&nbsp; New Item</a>";

                  	echo "</div>";

                  	
                } ?>


	         <?php


		          }elseif ($do == 'Add'){ ?>

		          	</br>

					         <h1 class="text-center">Add New Item</h1>
					  
						         <div class="container">

						          	 <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
						          	 
				                        <!-- Start Name field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Name</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	  <input type="text" name="name" class="form-control form-control-lg"  placeholder="Name Of The Item" required="required" />

					                               </div>

							          	 	</div>
				                        <!-- End Name field -->

				                         <!-- Start Description field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Description</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
														 <textarea  pattern =".{10,}"
															title ="This Field Require At Least 10 Characters" name="description" id="" cols="30" rows="3" class="form-control form-control-lg live" placeholder="Description Of The Item" 
															data-class =".live-desc" required="required"></textarea>


					                               </div>

							          	 	</div>
				                        <!-- End Description field -->		

				                        <!-- Start Price field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Price</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	  <input type="text" name="price" class="form-control form-control-lg" placeholder="Price Of The Item" required="required"/>

					                               </div>

							          	 	</div>
				                        <!-- End Price field -->			

				                        <!-- Start Country field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Country</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	  <input type="text" name="country" class="form-control form-control-lg"  placeholder="Country Of Made" required="required" />

					                               </div>

							          	 	</div>
				                        <!-- End Country field -->	

				                        <!-- Start Status field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Status</label>

					                               <div class="col-sm-10 col-md-6 ">            	  
					                               	  <select name="status">
					                               	  	<option value="0">...</option>
					                               	  	<option value="1">New</option>
					                               	  	<option value="2">Like New</option>
					                               	  	<option value="3">Used</option>
					                               	  	<option value="4">Old</option>
					                               	  </select>

					                               </div>

							          	 	</div>
				                        <!-- End Status field -->		

				                         <!-- Start Members field -->
				     <?php // echo $sessionUser ." ". $_SESSION['ID']; ?>
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Member</label>

					                               <div class="col-sm-10 col-md-6 ">            	  
					                               	  <select name="member">
					                               <!--	  	<option value="0">...</option> -->
					                               	  <?php 
							
														
													echo "<option value ='".$_SESSION['ID']."'>".$sessionUser."</option>";


													
							                   
							                           ?>
					                               	  </select>

					                               </div>

							          	 	</div>
				                      <!--   End Member field -->	

				                         <!-- Start Categories field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Category</label>

					                               <div class="col-sm-10 col-md-6 ">            	  
					                               	  <select name="category">
					                               	  	<option value="0">...</option>
					                               	  <?php 
					                         $allCats = getAllfrom ('*' , 'categories' ,'WHERE parent = 0', '','ID');
			                               
							                 foreach ($allCats as $Cat ) {
							                 	echo "<option value ='".$Cat['ID']."'>".$Cat['Name']."</option>";

							                 	$childCats = getAllfrom ("*" , "categories" ,"WHERE parent =".$Cat['ID']."", "","ID");

							                  foreach ( $childCats as $child ) {
			                                    
			                                    echo "<option value ='". $child['ID']."'> *** ". $child['Name']."</option>";


							                 }
							                }   
							                           ?>
					                               	  </select>

					                               </div>

							          	 	</div>
				                        <!-- End Categories field -->		


				                        <!-- Start Tags field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Tags</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	  <input type="text" name="tags" class="form-control form-control-lg"  placeholder="Separate Tags With Comma (,)"  />

					                               </div>

							          	 	</div>
				                        <!-- End Tags field -->		

										<!-- Start qty field -->
                                
										<div class="form-group row justify-content-center">
                                                
                                                <label class="col-sm-2 col-form-label-lg">Quantity</label>

                                                  <div class="col-sm-10 col-md-6">
                                                      
                                                      <input type="text" name="qty" class="form-control form-control-lg" required="required" placeholder="The Quantity of this item"  />

                                                  </div>

                                      </div>

                                        <!-- End qty field -->             

				                        <!-- Start Item photo field -->

							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Item Photo</label>

					                               <div class="col-sm-10 col-md-6">
					                               	  
					                               	  <input type="file" name="image" class="form-control form-control-lg"required="required" />

					                               </div>

							          	   	</div>
		                                <!-- End Item photo field -->	 			                                             
				       		                                            
				                        <!-- Start submit field -->

							          	 	<div class="form-group row justify-content-center">
							          	 		
					                               <div class=" col-sm-8 col-md-4 col-12 ">
					                               	  
					                               	  <input type="submit" value="Add Item" class="btn btn-light btn-lg" />

					                               </div>

							          	 	</div>
				                        <!-- End submit field -->

						          	 </form>

						         </div>

	        <?php }elseif ($do == 'Insert'){


              {    // insert item page 
    	      


				     if($_SERVER['REQUEST_METHOD']=='POST')

				          {           

                                     echo "<h1 class='text-center'>Insert Item</h1>";
	                                 echo "<div class ='container'>";


	                                 

                                    

	                                 // upload variable 

	                                 $photo = $_FILES['image'];

	                                 $photoName = $_FILES['image']['name'];
	                                 $photoSize  = $_FILES['image']['size'];
	                                 $photoTmp  = $_FILES['image']['tmp_name'];
	                                 $photoType = $_FILES['image']['type'];

	                                 // List of allowed types to upload 

	                                 $photoAllowedExtention = array("jpeg","jpg","png","gif");

	                                 // Get Avatar extention 

	                                 $photoExtention = explode('.' ,$photoName);
	                                 $end  = end($photoExtention);
	                                 $str = strtolower($end);

									// get the variables from the form 

                                       $name      = $_POST['name'];
                                       $desc      = $_POST['description'];
                                       $price     = $_POST['price'];
                                       $country   = $_POST['country'];
                                       $status    = $_POST['status'];
                                       $cat       = $_POST['category'];
									   $tags      = $_POST['tags'];
									   $qty       =  $_POST['qty'];
									   $member = $_POST['member'];

                                 

	                                  // validate the form 

	                               $FormErrors =array();

	                               if (empty($name)) {

	                               $FormErrors[]  = "Item Name Can't Be <strong>Empty</strong>";

	                               }

	                               if (strlen($name) < 3) {

						            $FormErrors[]  = "Item name Can't Be Less Than <strong> 4 Characters </strong>";

						           }

						           if (strlen($name) > 50) {

						            $FormErrors[]  = "Item name Can't Be more Than <strong>50 Characters</strong>";

						           }

	                               if (empty($desc)) {

	                               $FormErrors[]  = "Item  Description Can't Be more Than <strong>Empty</strong>";

	                               }

	                               if (strlen($desc) < 10) {

						            $FormErrors[]  = "Item Description Can't Be Less Than <strong>10 Characters</strong>";

						            }

						           if (strlen($desc) > 100) {

						            $FormErrors[]  = "Item Description Can't Be More Than <strong>100 Characters</strong>";

						            }
		   
								   if ($price < 0 || $price == 0) {

                                    $FormErrors[] = "Item Price Can't Be <strong>Less Than 0 OR Equal to 0</strong>";
	                               
	                               }

	                               if (empty($country)) {

	                                $FormErrors[] = "Item Country Can't Be <strong>Empty</strong>";

	                               }

	                               if (strlen($country) < 3)
						            {
						 
						            $FormErrors[]  = "Item Country Can't Be Less Than <strong>3 Characters</strong>";
						 
						            }

	                               if ($status == 0) {

                                    $FormErrors[] = "You must choose the <strong>Status</strong>";
	                              
	                               }

	                            
	                               if ($cat == 0) {

                                    $FormErrors[] = "You must choose the <strong>Category</strong>";
	                              

	                               }
	                               if (empty($photoName)) {
	                               	
	                               	$FormErrors[] = "Item Photo is <strong>Required</strong>";

	                               }
	                               
	                               if (!empty($photoName) && ! in_array($str, $photoAllowedExtention)){

	                               	$FormErrors[] = "This Extention Is Not <strong>Allowed</strong>";

								   }
								   
								   if ($qty < 0 || $qty == 0) {
									$FormErrors[] = "Item Quantity Can't Be <strong>Less Than 0 OR Equal to 0</strong>";

								   }

	                       
	                               // 1024 byte * 4 = 4 kb = 4096 byte * 1024 = 4194304 byte = 4 mb

	                               if ($photoSize > 4194304){

	                               	$FormErrors[] = "Photo Can't Be Larger Than <strong>4 MB</strong>";

								   }
								   
								   
  
	                             
								 
	                                  // loop into error aray and echo it 

	                               foreach ($FormErrors as $error) {
	                                  
	                                  echo "<div class='alert alert-danger' role='alert'> " .  $error . "</div>";

	                               }
	                                  // check if there is no error proceed the update operation

	                               if (empty($FormErrors)) {

	                               	 $photo = rand() .'_'.$photoName;
	                               	  move_uploaded_file($photoTmp, "uploads\items\\" .$photo);


									  // Insert item Info In Database
							/*	$memb = $conn ->prepare("SELECT UserID
								FROM users
								WHERE Username = '{$sessionUser}'
								"); */
											
                                  $stmt = $conn ->prepare("INSERT Into 
                                  	                       items(Name ,Description ,Price ,Country_Made , Status ,Approve, Add_Date , Cat_ID ,Member_ID ,tags ,quantity, item_photo)
                                                           VALUES (?,?,?,?,?,?,now(),?,?,?,?,?)");
								  

                                  $stmt->execute(array(
									$name ,
                                    $desc ,
                                    $price ,
                                    $country,
									$status ,
									  1,
									$cat,
									$member,
									$tags ,
									$qty ,
									$photo,
								
                                    ));
									
                                    $TheMsg = "<div class ='alert alert-success'> Item Inserted </div>";
                                    redirectHome($TheMsg , 'back');

                                    }
			                         



				            }else{  

				            	   echo "<div class= 'container'>";


				            	   $TheMsg = "<div class ='alert alert-danger'>Sorry You Can Not Browse This Page Directly</div>";

				                   redirectHome($TheMsg);

				                   echo "</div>";

				                 }

                echo "</div>";
                     
                }
	       
	         

	              }elseif ($do == 'Edit'){
	       
	               
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

					         <h1 class="text-center">Edit <?php echo $item['Name'] ?></h1>
					  
						         <div class="container">

						          	 <form class="form-horizontal" action="?do=Update" method="POST">
						          	 	<input type="hidden" name="itemid" value="<?php echo $itemid ?>">

						          	 
				                        <!-- Start Name field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Name</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	  <input type="text" name="name" class="form-control form-control-lg"  placeholder="Name Of The Item" required="required" value="<?php echo $item['Name'] ?>" />

					                               </div>

							          	 	</div>
				                        <!-- End Name field -->

				                         <!-- Start Description field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Description</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
														 <textarea  pattern =".{10,}"
															title ="This Field Require At Least 10 Characters" name="description" id="" cols="30" rows="3" class="form-control form-control-lg live" placeholder="Description Of The Item" 
															data-class =".live-desc" required="required"><?php echo $item['Description'] ?></textarea>


					                               </div>

							          	 	</div>
				                        <!-- End Description field -->		

				                        <!-- Start Price field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Price</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	  <input type="text" name="price" class="form-control form-control-lg" placeholder="Price Of The Item" required="required" value="<?php echo $item['Price'] ?>"/>

					                               </div>

							          	 	</div>
				                        <!-- End Price field -->			

				                        <!-- Start Country field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Country</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	  <input type="text" name="country" class="form-control form-control-lg"  placeholder="Country Of Made" required="required" value="<?php echo $item['Country_Made'] ?>"/>

					                               </div>

							          	 	</div>
				                        <!-- End Country field -->	

				                        <!-- Start Status field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Status</label>

					                               <div class="col-sm-10 col-md-6 ">            	  
					                               	  <select name="status">
					                               	  	<option value="1" <?php if ($item['Status']==1){ echo "selected";}?>>New</option>
					                               	  	<option value="2" <?php if ($item['Status']==2){ echo "selected";}?>>Like New</option>
					                               	  	<option value="3" <?php if ($item['Status']==3){ echo "selected";}?>>Used</option>
					                               	  	<option value="4" <?php if ($item['Status']==4){ echo "selected";}?>>Old</option>
					                               	  </select>

					                               </div>

							          	 	</div>
				                        <!-- End Status field -->		

				                       

				                         <!-- Start Categories field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Category</label>

					                               <div class="col-sm-10 col-md-6 ">            	  
					                               	  <select name="category">
					                               	  <?php 

			                                 $stmt2 = $conn ->prepare("SELECT * FROM categories");

							                 $stmt2 -> execute();

							                 $cats =  $stmt2 -> fetchAll();

							                 foreach ($cats as $Cat ) {
							                 	echo "<option value ='".$Cat['ID']."'";   
							                 	if ( $item['Cat_ID'] == $Cat['ID'] ) { echo "selected" ; }
							                 	echo ">".$Cat['Name']."</option>";
							                 }
							                   
							                           ?>
					                               	  </select>

					                               </div>

							          	 	</div>
				                        <!-- End Categories field -->				 			 

				                        <!-- Start Tags field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Tags</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	  <input type="text" name="tags" class="form-control form-control-lg"  placeholder="Separate Tags With Comma (,)" value="<?php echo $item['tags'] ?>" />

					                               </div>

							          	 	</div>
				                        <!-- End Tags field -->	   

										 <!-- Start qty field -->
                                
                                                <div class="form-group row justify-content-center">
                                                
                                                <label class="col-sm-2 col-form-label-lg">Quantity</label>

                                                  <div class="col-sm-10 col-md-6">
                                                      
                                                      <input type="text" name="qty" class="form-control form-control-lg" required="required" placeholder="The Quantity of this item" value="<?php echo $item['quantity'] ?>"  />

                                                  </div>

                                      </div>

                                        <!-- End qty field -->                                                          
				       		                                             
				       
				                        <!-- Start submit field -->

							          	 	<div class="form-group row justify-content-center">
							          	 		
					                               <div class=" col-sm-8 col-md-4 col-12 ">
					                               	  
					                               	  <input type="submit" value="Save Item" class="btn btn-light btn-lg" />

					                               </div>

							          	 	</div>
				                        <!-- End submit field -->

						          	 </form>
                   <?php
                    
               $stmt = $conn ->prepare("SELECT comments.* , users.Username AS Member
               	                        FROM 
               	                                comments
               	                        INNER JOIN 
               	                                users
               	                        ON
               	                                users.UserID = comments.user_id
               	                        WHERE item_id = ? ");

                     // execute the statement

               $stmt->execute(array($itemid));

                     // asign to variable

               $rows = $stmt->fetchAll();

               if ( ! empty($rows)) {


	          	?>
                 
                  <h1 class="text-center">Manage [ <?php echo $item['Name'] ?> ] Comments</h1>

					  	<div class="table-responsive">
					  		
					  		<table class=" text-center main-table table table-bordered">
					  			
					  			 <tr>
					  				<td>Comments</td>
					  				<td>User Name</td>
					  				<td>Added Date</td>
					  				<td>Control</td>

					  		     </tr>

					     <?php 
 
	                                   foreach ($rows as $row ) {
	                                   
	                                   echo "<tr>";
	                                   

	                                    
	                                      echo "<td>" . $row['comment'] . "</td>";
	                                      echo "<td>" . $row['Member'] . "</td>";
	                                      echo "<td> ". $row['comment_date'] ." </td>";
	                                      echo "<td>
	                                                 <a href='comments.php?do=Edit&comid=". $row['c_id']."' class='btn btn-light'><i class ='fa fa-edit'></i> Edit</a>
						  					         <a href='comments.php?do=Delete&comid=". $row['c_id']."' class='btn btn-dark confirm'><i class='fas fa-times'></i> Delete</a>";

                                        if ($row['status']==0) {
                                         
                                           echo " <a href='comments.php?do=Approve&comid=". $row['c_id']."' class='btn btn-info activate'><i class='fas fa-check'></i> Approve</a>";
                                        }


						  				  echo "</td>";
	                                   echo "</tr>";
 
	                                   }


					     ?>

					  		    
					  		</table>

					  	</div>
					 	<?php }  ?>
				  </div>

						        

		           <?php 
  
			           // if there is no such id show error message 

			  }else{
                            echo "<div class ='container'>";

			                $TheMsg =  "<div class ='alert alert-danger'>There Is No Such ID </div>";

			                redirectHome($TheMsg);


			             	echo "</div>";

			                }

	              }elseif ($do == 'Update'){
	       
	               echo "<h1 class='text-center'>Update Item</h1>";
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
									   $qty   = $_POST['qty'];
									  

	                                  // validate the form 

	                               $FormErrors =array();

	                               if (empty($name)) {

	                               $FormErrors[]  = "Name Can't Be <strong>Empty</strong>";

	                               }

	                               if (empty($desc)) {

	                               $FormErrors[]  = "Description Can't Be more Than <strong>Empty</strong>";

	                               }

	                               if (strlen($desc) > 100) {

						            $FormErrors[]  = "Item Description Can't Be More Than <strong>100 Characters</strong>";

						            }

	                               if (empty($price)) {

                                    $FormErrors[] = "Price Can't Be <strong>Empty</strong>";
	                               
	                               }
	                               if (empty($country)) {

	                                $FormErrors[] = "Country Can't Be <strong>Empty</strong>";

	                               }

	                               if ($status == 0) {

                                    $FormErrors[] = "You must choose the <strong>Status</strong>";
	                              
	                               }
	                            
	                               if ($cat == 0) {

                                    $FormErrors[] = "You must choose the <strong>Category</strong>";
	                              
								   }
								   if ($price < 0 || $price == 0 ) {

									$FormErrors[] = "Item price Can't Be Less Than 0 Or Equal to 0";
								 
								 }
  
								   if ($qty < 0 || $qty == 0) {
  
									$FormErrors[] = "Item quantity Can't Be Less Than 0 Or Equal to 0";
							  
								  }
  
	                             

	                                  // loop into error aray and echo it 

	                               foreach ($FormErrors as $error) {
	                                  
	                                  echo "<div class='alert alert-danger' role='alert'> " .  $error . "</div>";

	                               }
	                                  // check if there is no error proceed the update operation

	                               if (empty($FormErrors)) {


                                   $stmt = $conn ->prepare("UPDATE items SET Name =? , Description=? , Price=? , Country_Made =? , Status= ? ,Cat_ID = ? , tags =? ,quantity =? WHERE Item_ID=? ");

                                   $stmt ->execute(array($name , $desc , $price , $country , $status , $cat , $tags , $qty ,$id));

                                      // echo success message 

                                   $TheMsg = "<div class ='alert alert-success'>". $stmt->rowCount() . " Record Updated </div>";
                                    
                                    redirectHome($TheMsg , 'back');

	                                 
	                               }
			                          // Update the database with this info 



				            }else{  

				                    $TheMsg ="<div class ='alert alert-danger'>Sorry You Can Not Browse This Page Directly</div>";

				                     redirectHome($TheMsg );

				                  
       
				                 }

                echo "</div>";


         }elseif ($do == 'Edit_Image'){

               $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;


	           $stmt = $conn ->prepare("SELECT * FROM items WHERE Item_ID = ". $itemid ."");

                     // execute the statement

               $stmt->execute();

                     // asign to variable

               $rows = $stmt->fetchAll();

	          
                  foreach ($rows as $row) {
                 
                    echo "<h1 class='text-center'>Edit ". $row['Name'] ." Photo</h1>";
	                 echo "<div class ='container'>"; ?>
 
	               
                    <form class="form-horizontal" action="?do=Update_Image" method="POST" enctype="multipart/form-data" id="idForm">
                    	<input type="hidden" name="itemid" value="<?php echo $itemid ?>">

					  	<table align="center">					  		
					  		<tr>
					  			<th> </th>
					  			<td>					  				
								  	  <img src="uploads\items\\<?php echo $row['item_photo'] ?>" style="width: 350px; height: 350px;"  id ="imagepreview" alt="Image Preview"><br/>
							    	  	</br>
					  			</td>
					  		</tr>

					  	</table>
					  
				      <input type="hidden" name="photo" value="<?php echo $row['item_photo'] ?>">
	                 		 <!-- Start Avatar field -->
                
					          	 	<div class="form-group row justify-content-center">
					          	 		
		                               <label class="col-sm-2 col-form-label-lg">Item Photo</label>

			                               <div class="col-sm-10 col-md-6">
			                               	  
			                               	  <input type="file" name="image" class="form-control form-control-lg" required="required" id="idupload"/>

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

 	 echo "<h1 class='text-center'>Update Item Image</h1>";
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

			                               	$FormErrors[] = "This Extention Is Not <strong>Allowed</strong>";

			                               }

			                               if (empty($photoName)){

			                               	$FormErrors[] = "Photo Is <strong>Required</strong>";

			                               }
			                               // 1024 byte * 4 = 4 kb = 4096 byte * 1024 = 4194304 byte = 4 mb

			                               if ($photoSize > 4194304){

			                               	$FormErrors[] = "Photo Can't Be Larger Than <strong>4 MB</strong>";

			                               }


	                                  // loop into error aray and echo it 

			                               foreach ($FormErrors as $error)
				                               {
				                                  
				                                  echo "<div class='alert alert-danger' role='alert'> " .  $error . "</div>";

				                               }

					                       if (empty($FormErrors))
					                            {   
													 $photo = rand() .'_'. $photoName;
													 
												 if (move_uploaded_file($photoTmp, "uploads\items\\" . $photo))

			                                          {
			                                       
				                                   
				                                        @unlink("uploads\items\\".$_POST['photo']."");
				                                      

				                                   


					                               $stmt4= $conn-> prepare("UPDATE items
					                                                        SET item_photo=? 
					                                                        WHERE Item_ID=? ");

				                                   $stmt4 -> execute(array($photo, $id));
 

									                if ($stmt4) {

									                	

									                	 $TheMsg ="<div class ='alert alert-success'> Image Updated </div>";
			                                             redirectHome($TheMsg , 'back');
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

					 
		                      
                    



 <?php  }elseif ($do == 'Delete'){
	       
	                 echo "<h1 class='text-center'>Delete Item</h1>";
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

	                     $TheMsg = "<div class ='alert alert-success'> Item Deleted </div>";

                         redirectHome($TheMsg ,'back');



		                }else{   
		                	     $TheMsg = "<div class ='alert alert-danger'>This ID Is Not Exist</div>";

		                         redirectHome($TheMsg);
				               

		                    }

	                echo "</div>";

	              }elseif ($do == 'Approve'){
	       
	              
	                 echo "<h1 class='text-center'>Approve Item</h1>";
	                 echo "<div class ='container'>";
  

	                     // check if get request itemid is numeric and get the integer value of it

		                 $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

		                 
		                 // select all data depend on this ID

		                 

		                 $check = checkItem('Item_ID' , 'items' ,  $itemid);

	                   

	                     // if there's such id show the form

		                if ( $check > 0 ) {
	                     
	                     $stmt = $conn -> prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

	                     $stmt->execute(array($itemid));

	                     $TheMsg = "<div class ='alert alert-success'>". $stmt->rowCount() . " Item Updated </div>";

                         redirectHome($TheMsg ,'back');



		                }else{   
		                	     $TheMsg = "<div class ='alert alert-danger'>This ID Is Not Exist</div>";

		                         redirectHome($TheMsg);
				               

		                    }

	                echo "</div>";

	              }

	                include $tbl."footer.php";
}else
	        {
	          
	          header('Location: index.php');
	          exit();

	        }

	ob_end_flush();
?>



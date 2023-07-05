<?php

/*
**
** Categories Page
**
*/

 ob_start();  // output buffering start 

 session_start();

 $pageTitle = 'Categories';


if(isset($_SESSION['Username'])) // If there is a session already registered  
{
		 include 'init.php';


			           $do = isset($_GET['do']) ? $_GET['do']  : 'Manage';

			                 

				          if ($do == 'Manage'){           // manage categories page 

                                 $sort = 'ASC';

                                 $sort_array = array('ASC' ,'DESC' );

                                 if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

                                 	$sort = $_GET['sort'];

                                 }

			                     $stmt2 = $conn ->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");

				                 $stmt2 -> execute();

				                 $cats =  $stmt2 -> fetchAll();


                                 if (!empty($cats)) {
                                  	
				                 ?>
		                         
                                 
		                         <h1 class="text-center">Manage Categories</h1>
		                         <div class ='container categories'>
		                         	<div class="card card-default">
		                              <div class="card-header"><i class="fa fa-edit"></i>Manage Categories
		                              	<div class="option float-right">
		                              	  <i class="fa fa-sort"></i> Ordering: [
		                              		<a class="<?php if($sort == 'ASC'){ echo 'active';} ?>" href="?sort=ASC">Asc</a> |
		                              		<a class="<?php if($sort == 'DESC'){ echo 'active';} ?>" href="?sort=DESC">Desc</a> ]
		                              	  <i class="fa fa-eye"></i> View: [	                              		 
		                              		<span class="active" data-view='full'>Full</span> |
		                              		<span data-view='classic'>Classic</span> ]
		                              	</div>
		                              </div>
		                         	  <div class="card-body">
		                         	    	
                                         <?php

                                            foreach ($cats as $cat ) {
                                            	echo "<div class='cat'>";
                                            	    echo "<div class= 'hidden-buttons'>";

                                            	       echo "<a href='categories.php?do=Edit&catid=".$cat['ID']."' class='btn btn-primary'><i class ='fa fa-edit'></i> Edit</a>";
                                            	       echo "<a href='categories.php?do=Delete&catid=".$cat['ID']."' class=' confirm btn btn-danger'><i class ='fa fa-times'></i> Delete</a>";

                                            	    echo "</div>";
	                                            	echo "<h3>". $cat['Name'] ."</h3>";
	                                            	/*
	                                            	echo "<div class = 'full-view'>";
			                                            	echo "<p>";

			                                            	 if ($cat['Description']=='') {
			                                            		echo "This category has no description";
			                                            	}else{ echo $cat['Description'];}

			                                            	 echo "</p>";

			                                                if ($cat['Visibility']==1) {
			                                            		echo "<span class='visibility'><i class='fa fa-eye'></i>Hidden |</span>";
			                                            	     }
			                                                if ($cat['Allow_Comment']==1) {
			                                            		echo "<span class='commenting'><i class='fa fa-times'></i>Comment disabled |</span>";
			                                            	     }
			                                            	if ($cat['Allow_Ads']==1) {
			                                            		echo "<span class='advertises'><i class='fa fa-times'></i>Advertises disabled |</span>";
			                                            	     }

	                                                echo "</div>";
													*/
                                    // Get child categories

                                 $ChildCats = getAllfrom("*" , "categories", "WHERE parent = ".$cat['ID']."","","ID","ASC");
                                 
                                 if (!empty($ChildCats))
                                    {
                                    	echo "<div class = 'full-view'>";
                                   echo "<h4 class ='child-head'>Child Categories</h4>";
                                   echo "<ul class ='list-unstyled child-cat'>";

				                     foreach ($ChildCats as $ch ) {

									   echo "<li class='child-link '>
									            <a href='categories.php?do=Edit&catid=".$ch['ID']."' >" . $ch['Name'] . "</a>
									            <a href='categories.php?do=Delete&catid=".$ch['ID']."' class='show-delete confirm'> Delete</a>
									         </li>";
									 
							            }
							       echo "</ul>";
							        echo "</div>";
						            }

		                                	echo "</div>";
		         						    echo "<hr>";
                            }

                                         ?>

		                         	  </div>

		                         	</div>
		                         </br>
                                      <a href='categories.php?do=Add' class="btn btn-light add-category"><i class="fa fa-plus"></i>&nbsp; Add New Category</a>
		                         </div>
              <?php }else{
                  	echo "<div class='container'>";
                    echo "<div class='nice-message'>There's No Category To Show</div>";
                     echo"<a href='categories.php?do=Add' class='btn btn-light'><i class='fa fa-plus'></i>&nbsp; New Category</a>";

                  	echo "</div>";

                  	
                  } ?>

				         <?php }elseif ($do == 'Add'){ ?>

		                      </br>

					         <h1 class="text-center">Add New Category</h1>
					  
						         <div class="container">

						          	 <form class="form-horizontal" action="?do=Insert" method="POST">
						          	 
				                        <!-- Start Name field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Name</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	  <input type="text" name="name" class="form-control form-control-lg"  autocomplete="off" required="required" placeholder="Name Of The Category" />

					                               </div>

							          	 	</div>
				                        <!-- End Name field -->

										<!-- Start arabic name field -->

										<div class="form-group row justify-content-center">
							          	 		
												   <label class="col-sm-2 col-form-label-lg">Arabic Name</label>
	
													   <div class="col-sm-10 col-md-6 ">
															 
															 <input type="text" name="ar_name" class="form-control form-control-lg"  autocomplete="off" required="required" placeholder="Name Of The Category" />
	
													   </div>
	
												   </div>
									


										<!-- end arabic name field -->

				                        <!-- Start Description field 

							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Description</label>

					                               <div class="col-sm-10 col-md-6">
					                               	 
					                               	  <input type="text" name="description" class="form-control form-control-lg"  placeholder="Descripe The Category" />
					                               	  

					                               </div>

							          	 	</div>
				                         End Description field -->

				        

				           
				                        <!-- Start ordering field -->

							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Ordering</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	  <input type="text" name="ordering" class="form-control form-control-lg"  placeholder="Number To Arrange The Categories" />

					                               </div>

							          	 	</div>
				                        <!-- End ordering field -->

				                        <!-- start category type  -->

											<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Parent ?</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	<select name="parent">
					                               		
					                               		<option value="0">none</option>
					                               		<?php 

					                               		$allCats =getAllfrom('*','categories' ,'WHERE parent = 0' ,'','ID');
					                               		foreach ($allCats as $cat ) {
					                               			echo "<option value=".$cat['ID'].">".$cat['Name']."</option>";
					                               		}

					                               		 ?>

					                               	</select>

					                               </div>

							          	 	</div>

				                        <!-- end category type  -->

				                        <!-- Start visibility field -->
<!--
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Visible</label>

					                               <div class="col-sm-10 col-md-6">
					                               	  
					                               	  <div>
					                               	  	<input id="vis-yes" type="radio" name="visibility" value="0" checked/>
					                               	  	<label for="vis-yes">Yes</label>
					                               	  </div>
					                               	  <div>
					                               	  	<input id="vis-no" type="radio" name="visibility" value="1" />
					                               	  	<label for="vis-no">No</label>
					                               	  </div>


					                               </div>

							          	 	</div>
				                       

							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Allow Commenting</label>

					                               <div class="col-sm-10 col-md-6">
					                               	  
					                               	  <div>
					                               	  	<input id="com-yes" type="radio" name="commenting" value="0" checked/>
					                               	  	<label for="com-yes">Yes</label>
					                               	  </div>
					                               	  <div>
					                               	  	<input id="com-no" type="radio" name="commenting" value="1" />
					                               	  	<label for="com-no">No</label>
					                               	  </div>


					                               </div>

							          	 	</div>
				                     

							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Allow Ads</label>

					                               <div class="col-sm-10 col-md-6">
					                               	  
					                               	  <div>
					                               	  	<input id="ads-yes" type="radio" name="ads" value="0" checked/>
					                               	  	<label for="ads-yes">Yes</label>
					                               	  </div>
					                               	  <div>
					                               	  	<input id="ads-no" type="radio" name="ads" value="1" />
					                               	  	<label for="ads-no">No</label>
					                               	  </div>


					                               </div>

							          	 	</div>
				                      
				       
-->
				                        <!-- Start submit field -->

							          	 	<div class="form-group row justify-content-center">
							          	 		
					                               <div class=" col-sm-8 col-md-4 col-12 ">
					                               	  
					                               	  <input type="submit" value="Add Category" class="btn btn-light btn-lg" />

					                               </div>

							          	 	</div>
				                        <!-- End submit field -->

						          	 </form>

						         </div>

		           

		                  
                                
			          <?php }elseif ($do == 'Insert'){  // insert category page 
		    	      


						     if($_SERVER['REQUEST_METHOD']=='POST')

						          {           // get the variables from the form 

		                                     echo "<h1 class='text-center'>Insert Category</h1>";
			                                 echo "<div class ='container'>";

											   $name         = $_POST['name'];
											   $ar_name      = $_POST['ar_name'];
		                                    //   $desc         = $_POST['description'];
		                                       $parent       = $_POST['parent'];
		                                       $order        = $_POST['ordering'];
		                                      /* $visible      = $_POST['visibility'];
		                                       $comment      = $_POST['commenting'];
		                                       $ads          = $_POST['ads'];
		                                       */
											  $FormErrors =array();
			                                  // check if category exist in database 
											  if (strlen($name) < 3) {

												$FormErrors[]  = "Category Name Can't Be Less Than <strong> 3 Characters </strong>";
			 
												}
			 
												if (strlen($name) > 20) {
			 
												$FormErrors[]  = "Category Name Can't Be more Than <strong>20 Characters</strong>";
			 
												}

												if (strlen($ar_name) < 3) {

													$FormErrors[]  = "Category Arabic Name Can't Be Less Than <strong> 3 Characters </strong>";
				 
													}
				 
												if (strlen($ar_name) > 30) {
				
												$FormErrors[]  = "Category Arabic Name Can't Be more Than <strong>30 Characters</strong>";
				
												}
													
												/* if (strlen($desc) < 10) {

													$FormErrors[]  = "Description Can't Be Less Than <strong> 10 Characters </strong>";
				 
													}
				 
												if (strlen($desc) > 100) {
				
												$FormErrors[]  = "Description Can't Be more Than <strong>100 Characters</strong>";
				
												}

												*/
			
											$check= checkItem("Name" , "categories" ,  $name);

			                                   if ($check == 1 ) {

			                               	     $TheMsg = "<div class ='alert alert-danger'>Sorry This Category Is Exist</div> ";
			                               	     redirectHome($TheMsg , 'back');
											   }
											   
											   foreach ($FormErrors as $error) {
	                                  
												echo "<div class ='alert alert-danger' role='alert'>" . $error . "</div>";
		   
											  }
												 // check if there is no error proceed the update operation
		   
											  if (empty($FormErrors)) {
			                               	  


			                                          // Insert category Info In Database
			                                       
			                                      $stmt = $conn ->prepare("INSERT Into categories(Name  , parent ,Ordering,ar_Name )
			                                                               VALUES (:zname,:zparent, :zorder,:zarname)");

				                                  $stmt -> execute(array(
				                                     'zname'    =>    $name ,
				                                    // 'zdesc'    =>    $desc ,
				                                     'zparent'  =>    $parent ,
													 'zorder'   =>    $order ,
													 'zarname'  =>    $ar_name
				                                     /*'zvisible' =>    $visible ,
				                                     'zcomment' =>    $comment ,
				                                     'zads'     =>    $ads */

				                                    ));

				                                      // echo success message 

				                                    $TheMsg = "<div class ='alert alert-success'>". $stmt->rowCount() . " Category Inserted </div>";
		                                            redirectHome($TheMsg , 'back');

			                                        }
			                               
				        
						       }else{  

						            	   echo "<div class= 'container'>";


						            	   $TheMsg = "<div class ='alert alert-danger'>Sorry You Can Not Browse This Page Directly</div>";

						                   redirectHome($TheMsg , 'back');

						                   echo "</div>";

						            }

		                echo "</div>";
		                     
		                

			       }elseif ($do == 'Edit'){
			       
			         

	                 // edit page 

                     // check if get request Catid is numeric and get the integer value of it

	                 $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

	                 // echo $userid;

	                 // select all data depend on this ID

	                 $stmt = $conn -> prepare("SELECT * From  categories  where  ID =?  ");

                     // excute query

			         $stmt -> execute(array($catid));

			         // fetch the data 

			         $cat= $stmt -> fetch();

			         // the row count

			         $count = $stmt->rowCount();

                     // if there's such id show the form

	                if ( $count >0) {
		           ?>
   </br>

					         <h1 class="text-center">Edit <?php echo $cat['Name'] ?></h1>
					  
						         <div class="container">

						          	 <form class="form-horizontal" action="?do=Update" method="POST">
						          	 	<input type="hidden" name="catid" value="<?php echo $catid ?>"/>
						          	 
				                        <!-- Start Name field -->
				     
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Name</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	  <input type="text" name="name" class="form-control form-control-lg" required="required" placeholder="Name Of The Category" value="<?php echo $cat['Name'] ?>" />

					                               </div>

							          	 	</div>
				                        <!-- End Name field -->
										
										<!-- Start arabic name field -->
										
										<div class="form-group row justify-content-center">
							          	 		
												   <label class="col-sm-2 col-form-label-lg">Arabic Name</label>
	
													   <div class="col-sm-10 col-md-6 ">
															 
															 <input type="text" name="ar_name" class="form-control form-control-lg"  autocomplete="off" required="required" placeholder="Name Of The Category" value="<?php echo $cat['ar_Name']?>" />
	
													   </div>
	
												   </div>
									


										<!-- end arabic name field -->

				                        <!-- Start Description field

							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Description</label>

					                               <div class="col-sm-10 col-md-6">
					                               	 
					                               	  <input type="text" name="description" class="form-control form-control-lg"  placeholder="Descripe The Category" value="<?php echo $cat['Description'] ?>" />
					                               	  

					                               </div>

							          	 	</div>
				                         End Description field -->

				        

				           
				                        <!-- Start ordering field -->

							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Ordering</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	  <input type="text" name="ordering" class="form-control form-control-lg"  placeholder="Number To Arrange The Categories"  value="<?php echo $cat['Ordering'] ?>"/>

					                               </div>

							          	 	</div>
				                        <!-- End ordering field -->


				                        <!-- start category type  -->
				                        
											<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Parent ?</label>

					                               <div class="col-sm-10 col-md-6 ">
					                               	  
					                               	<select name="parent">
					                               		
					                               		<option value="0">none</option>
					                               		<?php 

					                               		$allCats =getAllfrom('*','categories' ,'WHERE parent = 0' ,'','ID');
					                               		foreach ($allCats as $c ) {
					                               			echo "<option value='".$c['ID']."'";

					                               			if ($cat['parent'] == $c['ID'] ) {
					                               				
					                               				echo "selected";
					                               			} 

					                               			echo ">" .$c['Name']."</option>";
					                               		}

					                               		 ?>

					                               	</select>

					                               </div>

							          	 	</div>

				                        <!-- end category type  -->

				                        <!-- Start visibility field -->
<!--
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Visible</label>

					                               <div class="col-sm-10 col-md-6">
					                               	  
					                               	  <div>
					                               	  	<input id="vis-yes" type="radio" name="visibility" value="0" 
					                               	  	<?php /* if ($cat['Visibility'] == 0)
					                               	  	        {
					                               	  		 echo "checked";
					                               	          	} ?> />
					                               	  	<label for="vis-yes">Yes</label>
					                               	  </div>
					                               	  <div>
					                               	  	<input id="vis-no" type="radio" name="visibility" value="1" 
					                               	  	<?php if ($cat['Visibility'] == 1)
					                               	  	        {
					                               	  		 echo "checked";
					                               	          	} */?> />
					                               	  	<label for="vis-no">No</label>
					                               	  </div>


					                               </div>

							          	 	</div>
-->
				                        <!-- End visibility field -->
				                        <!-- Start commenting field -->

<!--

							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Allow Commenting</label>

					                               <div class="col-sm-10 col-md-6">
					                               	  
					                               	  <div>
					                               	  	<input id="com-yes" type="radio" name="commenting" value="0"
					                               	  	<?php /*if ($cat['Allow_Comment'] == 0)
					                               	  	        {
					                               	  		 echo "checked";
					                               	          	} ?> />
					                               	  	<label for="com-yes">Yes</label>
					                               	  </div>
					                               	  <div>
					                               	  	<input id="com-no" type="radio" name="commenting" value="1"
					                               	  	<?php if ($cat['Allow_Comment'] == 1)
					                               	  	        {
					                               	  		 echo "checked";
					                               	          	} */ ?>  />
					                               	  	<label for="com-no">No</label>
					                               	  </div>


					                               </div>

							          	 	</div>
-->
				                        <!-- End commenting field -->
				                        <!-- Start Ads field -->
<!--
							          	 	<div class="form-group row justify-content-center">
							          	 		
				                               <label class="col-sm-2 col-form-label-lg">Allow Ads</label>

					                               <div class="col-sm-10 col-md-6">
					                               	  
					                               	  <div>
					                               	  	<input id="ads-yes" type="radio" name="ads" value="0" 
					                               	  	<?php /* if ($cat['Allow_Ads'] == 0)
					                               	  	        {
					                               	  		 echo "checked";
					                               	          	} ?> />
					                               	  	<label for="ads-yes">Yes</label>
					                               	  </div>
					                               	  <div>
					                               	  	<input id="ads-no" type="radio" name="ads" value="1" 
					                               	  	<?php if ($cat['Allow_Ads'] == 1)
					                               	  	        {
					                               	  		 echo "checked";
					                               	          	} */?> />

					                               	  	<label for="ads-no">No</label>
					                               	  </div>


					                               </div>

							          	 	</div>
	--> 	
				                        <!-- End Ads field -->
				       

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

			         

			       }elseif ($do == 'Update'){
			       
			           echo "<h1 class='text-center'>Update Category</h1>";
	           echo "<div class ='container'>";


				     if($_SERVER['REQUEST_METHOD']=='POST')

				          {           // get the variables from the form 
                                        
                                       $id      = $_POST['catid'];
									   $name    = $_POST['name'];
									   $ar_name = $_POST['ar_name'];
                                     //  $desc     = $_POST['description'];
                                       $order   = $_POST['ordering'];
                                       $parent   = $_POST['parent'];
                                     /*  $visible = $_POST['visibility'];
                                       $comment   = $_POST['commenting'];
                                       $ads   = $_POST['ads'];*/
									   $FormErrors =array();
									   // check if category exist in database 
									   if (strlen($name) < 3) {

										 $FormErrors[]  = "Category Name Can't Be Less Than <strong> 3 Characters </strong>";
	  
										 }
	  
										 if (strlen($name) > 20) {
	  
										 $FormErrors[]  = "Category Name Can't Be more Than <strong>20 Characters</strong>";
	  
										 }

										 if (strlen($ar_name) < 3) {

											 $FormErrors[]  = "Category Arabic Name Can't Be Less Than <strong> 3 Characters </strong>";
		  
											 }
		  
										if (strlen($ar_name) > 30) {
		
										$FormErrors[]  = "Category Arabic Name Can't Be more Than <strong>30 Characters</strong>";
		
										}
											 
									/*	 if (strlen($desc) < 10) {

											 $FormErrors[]  = "Description Can't Be Less Than <strong> 10 Characters </strong>";
		  
											 }
		  
										 if (strlen($desc) > 100) {
		 
										 $FormErrors[]  = "Description Can't Be more Than <strong>100 Characters</strong>";
		 
										 }
								     */
								
										 foreach ($FormErrors as $error) {
	                                  
											echo "<div class ='alert alert-danger' role='alert'>" . $error . "</div>";
	   
										  }
											 // check if there is no error proceed the update operation
	   
								 if (empty($FormErrors)) {
											 

	                            // Update the database with this info 

                                $stmt = $conn ->prepare("UPDATE categories 
                                	                     SET Name =? ,
                                	                         Ordering=? ,
                                	                         parent = ?,
															 ar_Name =?
                                	                         
                                	                     WHERE ID=? ");

                                $stmt -> execute(array( $name ,$order ,$parent ,$ar_name,$id));
 
                                // echo success message 

                                $TheMsg = "<div class ='alert alert-success'>". $stmt->rowCount() . " Record Updated </div>";
                                
                                redirectHome($TheMsg , 'back');
								 }


				            }else{  

				                    $TheMsg ="<div class ='alert alert-danger'>Sorry You Can Not Browse This Page Directly</div>";

				                     redirectHome($TheMsg );

				                  
       
				                 }

                echo "</div>";


			       }elseif ($do == 'Delete'){
			       
			          echo "<h1 class='text-center'>Delete Category</h1>";
	                 echo "<div class ='container'>";
  

	                     // check if get request catid is numeric and get the integer value of it

		                 $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

		                 // echo $userid;

		                 // select all data depend on this ID

		                 

		                 $check = checkItem('ID' , 'categories' ,  $catid);

	                   

	                     // if there's such id show the form

		                if ( $check > 0 ) {
	                     
	                     $stmt = $conn -> prepare("DELETE From categories WHERE  ID = :zid");

	                     $stmt->bindParam(":zid",$catid);

	                     $stmt->execute();

	                     $TheMsg = "<div class ='alert alert-success'> Category Deleted </div>";

                         redirectHome($TheMsg ,'back');



		                }else{   
		                	     $TheMsg = "<div class ='alert alert-danger'>This ID Is Not Exist</div>";

		                         redirectHome($TheMsg);
				               

		                    }

	                echo "</div>";

			       }

			   include $tbl."footer.php";

}else{					
	          
	          header('Location: index.php');
	          exit();

	        }

	     ob_end_flush();
?>

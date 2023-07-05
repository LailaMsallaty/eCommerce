<?php 

/*
================================================================
== manage comments page
== you can   edit | delete | Approve comments from here 
================================================================

*/
 ob_start(); // output buffering start 

 session_start();

  $pageTitle = 'Comments';
       
        if(isset($_SESSION['Username'])) // If there is a session already registered
{  

         

	           include 'init.php';


	           $do = isset($_GET['do']) ? $_GET['do']  : 'Manage';

	                 // start manage page

	           if ($do == 'Manage'){           // manage members page 		   
               
                    
               $stmt = $conn ->prepare("SELECT comments.* , items.Name AS Item_Name , users.Username AS Member
               	                        FROM 
               	                                comments
               	                        INNER JOIN
               	                                items
               	                        ON  
               	                                items.Item_ID = comments.item_id
               	                        INNER JOIN 
               	                                users
               	                        ON
               	                                users.UserID = comments.user_id 
               	                        ORDER BY c_id desc");

                     // execute the statement

               $stmt->execute();

                     // asign to variable

               $comments = $stmt->fetchAll();



               if (!empty($comments)) {
	          	?>
                 
                  <h1 class="text-center">Manage Comments</h1>
			  
				  <div class="container">

					  	<div class="table-responsive">
					  		
					  		<table class=" text-center main-table table table-bordered">
					  			
					  			 <tr>

					  				<td>#ID</td>
					  				<td>Comments</td>
					  				<td>Item Name</td>
					  				<td>User Name</td>
					  				<td>Added Date</td>
					  				<td>Control</td>

					  		     </tr>

					     <?php 
 
	                                   foreach ($comments as $comment ) {
	                                   
	                                   echo "<tr>";
	                                   

	                                      echo "<td>" . $comment['c_id'] . "  </td>";
	                                      echo "<td>" . $comment['comment'] . "</td>";
	                                      echo "<td>" . $comment['Item_Name'] . "   </td>";
	                                      echo "<td>" . $comment['Member'] . "</td>";
	                                      echo "<td> ". $comment['comment_date'] ." </td>";
	                                      echo "<td>
	                                                 <a href='comments.php?do=Edit&comid=". $comment['c_id']."' class='btn btn-light'><i class ='fa fa-edit'></i> Edit</a>
						  					         <a href='comments.php?do=Delete&comid=". $comment['c_id']."' class='btn btn-dark confirm'><i class='fas fa-times'></i> Delete</a>";

                                        if ($comment['status']==0) {
                                         
                                           echo " <a href='comments.php?do=Approve&comid=". $comment['c_id']."' class='btn btn-info activate'><i class='fas fa-check'></i> Approve</a>";
                                        }


						  				  echo "</td>";
	                                   echo "</tr>";
 
	                                   }


					     ?>

					  		    
					  		</table>


					  	</div>

				  </div>
              
                  <?php }else{
                  	echo "<div class='container'>";
                      echo "<div class='nice-message'>There's No Comment To Show</div>";
                  	echo "</div>";

                  	
                } ?>


	         <?php }elseif ($do == 'Edit')

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

			         <h1 class="text-center">Edit Comment</h1>
			  

				         <div class="container">

				          	 <form class="form-horizontal" action="?do=Update" method="POST">
				          	 	<input type="hidden" name="comid" value="<?php echo $comid ?>">

		                        <!-- Start comment field -->
		     
					          	 	<div class="form-group row justify-content-center">
					          	 		
		                               <label class="col-sm-2 col-form-label-lg">Comment</label>

			                               <div class="col-sm-10 col-md-6 ">  
			                               	  <textarea class="form-control" name="comment"><?php echo $row['comment']; ?></textarea>
			                               </div>

					          	 	</div>
		                        <!-- End comment field -->

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


	           echo "<h1 class='text-center'>Update Comment</h1>";
	           echo "<div class ='container'>";


				     if($_SERVER['REQUEST_METHOD']=='POST')

				          {           // get the variables from the form 
                                        
                                       $comid    = $_POST['comid'];
                                       $comment  = $_POST['comment'];
                                   
 

	                                  

                                // Update the database with this info 


                                $stmt = $conn ->prepare("UPDATE comments SET comment =?  WHERE c_id=? ");

                                $stmt -> execute(array($comment ,$comid));

                                  // echo success message 

                               $TheMsg = "<div class ='alert alert-success'>". $stmt->rowCount() . " Comment Updated </div>";
                                
                                redirectHome($TheMsg , 'back');

	                                 
	                              
			                         



				            }else{  

				                    $TheMsg ="<div class ='alert alert-danger'>Sorry You Can Not Browse This Page Directly</div>";

				                     redirectHome($TheMsg );

				                  
       
				                 }

                echo "</div>";

	          }elseif ($do == 'Delete')   // Delete  page
                {
	                 echo "<h1 class='text-center'>Delete Comment</h1>";
	                 echo "<div class ='container'>";
  

	                     // check if get request comid is numeric and get the integer value of it

		                 $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;


		                 // select all data depend on this ID

		                 

		                 $check = checkItem('c_id' , 'comments' ,  $comid);

	                   

	                     // if there's such id show the form

		                if ( $check > 0 ) {
	                     
	                     $stmt = $conn -> prepare("DELETE From comments WHERE c_id = :zcom");

	                     $stmt->bindParam(":zcom",$comid);

	                     $stmt->execute();

	                     $TheMsg = "<div class ='alert alert-success'>Comment Deleted </div>";

                         redirectHome($TheMsg ,'back');



		                }else{   
		                	     $TheMsg = "<div class ='alert alert-danger'>This ID Is Not Exist</div>";

		                         redirectHome($TheMsg);
				               

		                    }

	                echo "</div>";

	          }elseif ($do=='Approve') {
	          	
                   
	                 echo "<h1 class='text-center'>Approve Comment</h1>";
	                 echo "<div class ='container'>";
  

	                     // check if get request comid is numeric and get the integer value of it

		                 $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

		         

		                 // select all data depend on this ID

		                 

		                 $check = checkItem('c_id' , 'comments' ,  $comid);

	                   

	                     // if there's such id show the form

		                if ( $check > 0 ) {
	                     
	                     $stmt = $conn -> prepare("UPDATE comments SET status = 1 WHERE c_id = ?");

	                     $stmt->execute(array($comid));

	                     $TheMsg = "<div class ='alert alert-success'>". $stmt->rowCount() . " Comment Updated </div>";

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
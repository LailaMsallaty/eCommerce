<?php 

/*
================================================================
== manage comments page
== you can   edit | delete | Approve comments from here 
================================================================

*/
 ob_start(); // output buffering start 

 session_start();

  $pageTitle = 'Cards';
       
  if(isset($_SESSION['Username'])) // If there is a session already registered
{  

         

	           include 'init.php';


	           $do = isset($_GET['do']) ? $_GET['do']  : 'Manage';

	                 // start manage page

	           if ($do == 'Manage'){           // manage members page 		   
               
                    
               $stmt = $conn ->prepare("SELECT  items.* , card.*,users.*
                                            
                                        from items
                                        
                                        inner  join card

										on items.Item_ID = card.item_id
										
										inner join users
										
										on users.UserID = card.member_id");

                     // execute the statement

               $stmt->execute();

                     // asign to variable

               $cards = $stmt->fetchAll();



           if (!empty($cards)) {
	          	?>
                 
                  <h1 class="text-center">Cards</h1>
			  
				  <div class="container">

					  	<div class="table-responsive">
					  		
					  		<table class=" text-center main-table table table-bordered">
					  			
					  			 <tr>

					  				<td>#ID</td>
					  				<td>Item Name</td>
					  				<td>User Name</td>
					  				<td>Quantity</td>
					  			

					  		     </tr>

					     <?php 

	                                 foreach ($cards as $card ) {
	                                   
	                                   echo "<tr>";
	                                   

	                                      echo "<td>" . $card['card_id'] . "  </td>";
                                          echo "<td>" . $card['Name'] . "   </td>";
	                                      echo "<td>" . $card['Username'] . "</td>";
	                                      echo "<td> ". $card['quantity'] ." </td>";
	                                    
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
                
                    }

        }  
}else{					
	          
    header('Location: index.php');
    exit();

  }
include $tbl."footer.php";
ob_end_flush();
?>

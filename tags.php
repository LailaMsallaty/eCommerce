
<?php 
	session_start();
	include 'init.php';
?>



			<?php

              // $category = isset($_GET['pageid']) && is_numeric($_GET['pageid']) ? intval($_GET['pageid']) : 0;

					

 
	           if (isset($_GET['name'])) {

	         	  $tag = $_GET['name'];

	         	   echo "<div class='container'>" ;
					
	         	      echo " <h1 class='text-center'>".$tag."</h1>";

	         	      echo "<div class='row'>";

	             
				  $tagItems = getAllfrom("*","items" ,"WHERE tags LIKE '%$tag%' " ,"AND Approve = 1","Item_ID");
                      
                       
                
					             foreach ($tagItems as $item) {
									echo "<div class=' col-sm-6 col-md-4 col-lg-3 '>";
									echo "<div class='card item-box 'style = 'height: 600px;'>";
									   echo "<span class ='price-tag' >". $item['Price']." ".$lang['S.P']."</span>";
									   echo "<img class='img-fluid img-item ' src='admin\uploads\items\\".$item['item_photo']."' alt='' />";
									   echo "<div class='caption'>";
										   echo "<h3><a href='items.php?itemid=" . $item['Item_ID'] . "'>" . $item['Name'] . "</a></h3>";
										   echo "<p class='description' style='height:80px;'>" . $item['Description'] . "</p>";
										   echo "<p><span style='color:#777;'></br>|  ".$lang['QUANTITY']." : ".$item['quantity']."</span></p>";
										   if (isset($_SESSION['user'])) {
											
												if( $item['Member_ID'] == $info['UserID'] || $item['quantity']==0)
												 echo "<p class='country'>" . $item['Country_Made'] ."</p>";
										   
												else
													echo " <p class='country' >" . $item['Country_Made'] ."  <a href='index.php?add_card=".$item['Item_ID']."' class='btn btn-dark btn-sm'><i class ='fa fa-plus'></i>&nbsp; ".$lang['ADD_TO_CARD']."</a></p>";
			
												
										  }
										  else if($item['quantity']==0)
										  {echo "<p class='country'>" . $item['Country_Made'] ."</p>";}
										   else echo "<p class='country'>" . $item['Country_Made'] ." <a href='login.php' class='btn btn-dark btn-sm'><i class ='fa fa-plus'></i>&nbsp; ".$lang['ADD_TO_CARD']."</a></p>";
										   echo "<div class='date'>" . $item['Add_Date'] . "</div>";
			
									   echo "</div>";
									echo "</div>";
								echo "</div>";
					             
					             }
				   

				  }else{
							         echo "<div class ='container'>";

							             echo "<div class ='alert alert-danger'>You Must Enter Tag Name</div>";

							         echo "</div>";
		                  }

		         
					             
			?>
   </div>
</div>
        

       <div style="margin-top:460px;">
    <?php 
  include $tbl."footer.php"; 
  ob_end_flush();
?>
 
  </div>


  
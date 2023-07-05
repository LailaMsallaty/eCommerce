
<?php 
	session_start();
	 $pageTitle = 'Category Items';
	include 'init.php';
?>
<?php

 $category =intval($_GET['pageid']);

 $category=getAllfrom("*","categories" ,"WHERE ID = {$category} " ,"","ID","");

 foreach ( $category as $cat ){
 	
  ?>
  <?php
  
  if (!isset($_GET['lang']))

  $_GET['lang'] = "en";


  if ($_GET['lang']=="en") 

  { 
	  $_SESSION['lang'] = "en";

	 

	   

		 ?>
			<div class="container"> 
			<h1 class="text-center"><?php echo $lang['SHOW'] ;?> <?php echo $cat['Name']?>  </h1>
			<div class="row">
		<?php

		
  }else if($_GET['lang']=="ar")

	{
		$_SESSION['lang'] = "ar" ;
		
	
  
			?>
			<div class="container"> 
			<h1 class="text-center"><?php echo $lang['SHOW'] ;?> <?php echo $cat['ar_Name']?>  </h1>
			<div class="row">
		<?php

		  
	} 
}		
		
              // $category = isset($_GET['pageid']) && is_numeric($_GET['pageid']) ? intval($_GET['pageid']) : 0;
 

 
	  if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {

	              $category =intval($_GET['pageid']);

				  $allItems = getAllfrom("*","items" ,"WHERE Cat_ID = {$category} " ,"AND Approve = 1","Item_ID");
                      
                          if (count($allItems) > 0) {
						  
					             foreach ($allItems as $item) {
									echo "<div class=' col-sm-6 col-md-4 col-lg-3 '>";
									echo "<div class='card item-box ' style='height:600px;'>";
									   echo "<span class ='price-tag' >". $item['Price']." ".$lang['S.P']."</span>";
									   echo "<img class='img-fluid img-item ' src='admin\uploads\items\\".$item['item_photo']."' alt='' />";
									   echo "<div class='caption'>";
										   echo "<h3><a href='items.php?itemid=" . $item['Item_ID'] . "'>" . $item['Name'] . "</a></h3>";
										   echo "<p class='description' style='height:80px;'>" . $item['Description'] . "</p>";
										   echo"<p><span style='color:#777;'></br>|  ".$lang['QUANTITY']." : ".$item['quantity']."</span></p>";
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

						}else {
							echo "<div class='container'>";
							echo "<div class='alert alert-danger'>".$lang['NO_ITEMS']."</div>";
							echo "</div>";
						}	 


					
				    
		  }else{
					         echo "<div class ='container'>";

					             echo "<div class ='alert alert-danger'>".$lang['ADD_PAGE_ID']."</div>";

							 echo "</div>";
							 
                  }
			?>
   </div>
</div>
				
<div style="margin-top:280px;">
 <?php 
include $tbl."footer.php"; 

ob_end_flush();			?>
</div>
	

  
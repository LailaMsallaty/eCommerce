<?php  
ob_start();
session_start();

  $pageTitle = 'Homepage';

		include 'init.php';
  

if (!isset($_GET['add_card']) && !isset($_GET['do'])) {
?>
<section id="banner">
	<div class="container">
		<div class="row">	
			<div class="col-md-6">
				
				<p class="promo-title"><h1 class="title"><?php echo $lang['TITLE']?></h1></p>
				<p  style="font-size:30px; color :#"><?php echo $lang['WELCOME']?></p>


			</div>

			<div class="col-md-6 text-center">
				<img src="computers-clipart-shopping-19.png" class="img-fluid" style="width: 500px; height: 350px;">

			</div>
		</div>
	</div>

	
</section>
<div style="height: 150px; overflow: hidden;">
  <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
    <path d="M0.00,92.27 C216.83,192.92 304.30,8.39 500.00,109.03 L500.00,0.00 L0.00,0.00 Z" style="stroke: none;fill: #343a40;"></path>
  </svg>
</div>


<!--<img class=" d-block img-fluid m-auto" width='40px' height='40px' src="385-3856300_no-avatar-png.png" alt="">-->


<div class="container"> 
  <h1 class="text-center"><?php echo $lang['ITEMS_SHOW']?></h1>
   <div class="row" >
			<?php

				
			  $allItems = getAllfrom('*','items' ,'WHERE Approve = 1' ,'','Item_ID');
	             foreach ( $allItems as $item) {

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
	 ?>  </div>
	 </div>
	  <?php

ob_end_flush();
include $tbl."footer.php"; 
}

elseif(isset($_GET['add_card'])){
	
?>
 

 <h1 class="text-center"><?php echo $lang['ADD'] ?> <?php echo $lang['ITEM'] ?> </h1>
<div class="container">

	
		<form class="form-horizontal" action="?do=add_to_card&itemid=<?php echo $_GET['add_card'] ?>" method="POST">
		   <div class="form-group row justify-content-center">
														
			<label class="col-sm-2 col-form-label-lg"><?php echo $lang['QUANTITY']?></label>

			<div class="col-sm-10 col-md-6">
				
				<input type="number" name="qty" class="form-control form-control-lg" required="required" placeholder="<?php echo $lang['PLACEHOLDER_ITEM_QUANTITY']?>"  />

			</div>

		  </div>

		   <div class="form-group row justify-content-center">
														
				<div class="col-sm-8 col-md-4 col-12">
				
				<input type="submit" name="add-quantity" value="<?php echo $lang['ADD']?>" class="btn btn-light btn-lg" style="color:#fff;" />

				</div>

			</div>
		</form>
	</div>
	<div style="margin-top:230px;">
 <?php 
include $tbl."footer.php"; 

ob_end_flush();			?>
</div>
	
<?php
 }
	
elseif (isset($_POST['add-quantity'])) {

	echo "<h1 class='text-center'>". $lang['ADD_TO_CARD']."</h1>";
	echo "<div class ='container'>";
	
	$req_qty = $_POST['qty'];

	$FormErrors = array();

	if ($req_qty == 0 || $req_qty < 0) {

	$FormErrors[]= $lang['ITEM_QTY_VALIDATE'];
		
	}
	foreach ($FormErrors as $error)
	{
	   
	   echo "<div class='container'><div class='alert alert-danger' role='alert'> " .  $error . "</div></div>";

	}

	if (empty($FormErrors)) {
	
	

	$userid = isset($_GET['add_card']) && is_numeric($_GET['add_card']) ? intval($_GET['add_card']) : 0;

	$add_quantity = $_POST['add-quantity'];

	if (isset($_GET['itemid']) && is_numeric($_GET['itemid'])) {

	$item_id = $_GET['itemid'];
	
	$stmt = $conn->prepare("SELECT * from items where Item_ID = $item_id ");
	$stmt->execute();

	$items = $stmt->fetchAll();

	foreach ($items as $item) {

		$deference = $item['quantity'] - $req_qty;
	

	
	if ( $deference < 0 || $item['quantity'] == 0) {

		$TheMsg = "<div class='container'><div class='alert alert-danger' role='alert'> ". $lang['NO_ENOUGH_ITEMS']." ".$item['quantity']."</div></div>";

		redirectHome($TheMsg );

	}else{

	$stmt = $conn->prepare("UPDATE items set quantity = $deference where  Item_ID = $item_id ");
	$stmt->execute();
		
			if (isset($_SESSION['user'])) {
			
				
				$insert = $conn ->prepare("INSERT into card(item_id,member_name,member_id,quantity) values(:zitem,:zmember,:zmid,:zqty)");
		
				$insert->execute(array(

					'zitem'   => $item_id ,
					'zmember'   => $_SESSION['user'] ,
					'zmid'     =>  $_SESSION['uid'] ,
					'zqty'    => $req_qty
					
				   ));

			}
			$TheMsg = "<div class='container'><div class ='alert alert-success'>". $lang['ADD_TO_CARD_MSG']." </div></div>";
                                    
			redirectHome($TheMsg , 'back');
	    }


      }

	}
  }
  
echo "</div>";
}

else{

	$TheMsg ="<div class='container'><div class ='alert alert-danger'>".$lang['BROWSE_DIRECTLY_ERROR']."</div></div>";

	redirectHome($TheMsg );


}
?>

			

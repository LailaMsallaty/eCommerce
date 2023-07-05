
<!DOCTYPE html>
   <html>
	   <head>
	   	<meta charset="utf-8"/>
	   	<title><?php getTitle() ?></title>
	   	  
		   	<link rel="stylesheet" href="<?php  echo $css;?>bootstrap.min.css"/>
		    <link rel="stylesheet" href="<?php  echo $css;?>fontawesome.min.css"/>
            <link rel="stylesheet" href="<?php  echo $css;?>brands.min.css"/>
            <link rel="stylesheet" href="<?php  echo $css;?>solid.min.css"/>
		    <link rel="stylesheet" href="<?php  echo $css;?>jquery-ui.css"/>
		    <link rel="stylesheet" href="<?php  echo $css;?>jquery.selectBoxIt.css"/>
		   	<link rel="stylesheet" href="<?php  echo $css;?>front.css"/>

       
           
	   </head>
   <body>
  <div  class="upper-bar">

     <div  class="container">
     	<?php
      
		  if(isset($_SESSION['user']))

			   {    $getUser = $conn ->prepare(" SELECT * FROM users Where Username = ? ");

					$getUser->execute(array($sessionUser));


					$info = $getUser -> fetch();

					$count = $getUser->rowCount();
					
					if ($count==0) {
						
						
							session_unset();
							 header('Location: index.php'); // Redirect To HomePage
		
							exit();
							
					}

				    $userid = $info['UserID'];

			    ?>         
				    <img  class ="my-image img-fluid rounded-circle " src='<?php
			        if($info['avatar'] == '385-3856300_no-avatar-png.png')
			        echo $info['avatar'] ;
			        else echo "admin\uploads\avatars\\". $info['avatar']; ?>' alt='' />

				    
	                        <div class="btn-group my-info " role="group">
	                        	<span id="btnGroupDrop1" class=" dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                        		<?php echo $_SESSION['user'] ?>
	                        	</span>
	                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
	                        	<div>
	                        		<a class="dropdown-item" href="profile.php"><?php echo $lang['MY_PROFILE']?></a>
	                        	    <a class="dropdown-item" href="newad.php"><?php echo $lang['NEW_ITEM']?></a>
	                        	    <a class="dropdown-item" href="profile.php#my-ads"><?php echo $lang['MY_ITEMS']?></a>
	                        	    <div class="dropdown-divider"></div>
	                        		<a class="dropdown-item" href="logout.php"><?php echo $lang['LOG_OUT']?></a>
	                        	</div>
	                         </div>
							</div>
							<?php 

						if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {

							$category =intval($_GET['pageid']);
							
						
							?>
					     <div class="float-right ">
						    <a href="?pageid=<?php echo $category; ?>&lang=en" class="login-logout"><?php echo $lang['lang_en'] ?></a>
						  | <a href="?pageid=<?php echo $category; ?>&lang=ar" class="login-logout"><?php echo $lang['lang_ar']?></a>
						 </div>
						 
					<?php 
						}
						else if(isset($_GET['itemid']) && is_numeric($_GET['itemid']) && !isset($_GET['do'])) { 

							$item =intval($_GET['itemid']); ?>
							
						 <div class="float-right ">
						    <a href="?itemid=<?php echo $item; ?>&lang=en" class="login-logout"><?php echo $lang['lang_en'] ?></a>
						  | <a href="?itemid=<?php echo $item; ?>&lang=ar" class="login-logout"><?php echo $lang['lang_ar']?></a>
						 </div>
						
						<?php }

						else if(isset($_GET['userid']) && is_numeric($_GET['userid']) && isset($_GET['do'])) { 

							$user =intval($_GET['userid']); ?>
							
						<div class="float-right ">
						  <a href="?do=<?php echo $_GET['do']; ?>&userid=<?php echo $user; ?>&lang=en" class="login-logout"><?php echo $lang['lang_en'] ?></a>
						| <a href="?do=<?php echo $_GET['do']; ?>&userid=<?php echo $user; ?>&lang=ar" class="login-logout"><?php echo $lang['lang_ar']?></a>
						</div>

						<?php }

						else if(isset($_GET['do']) && isset($_GET['itemid']) && is_numeric($_GET['itemid']) ) { 

							$item =intval($_GET['itemid']); ?>
							
						<div class="float-right ">
						  <a href="?do=<?php echo $_GET['do']; ?>&itemid=<?php echo $item; ?>&lang=en" class="login-logout"><?php echo $lang['lang_en'] ?></a>
						| <a href="?do=<?php echo $_GET['do']; ?>&itemid=<?php echo $item; ?>&lang=ar" class="login-logout"><?php echo $lang['lang_ar']?></a>
						</div>

						<?php }

						else if(isset($_GET['add_card']) &&  is_numeric($_GET['add_card']) ) { 

							 ?>
							
						<div class="float-right ">
						  <a href="?add_card=<?php echo $_GET['add_card']; ?>&lang=en" class="login-logout"><?php echo $lang['lang_en'] ?></a>
						| <a href="?add_card=<?php echo $_GET['add_card']; ?>&lang=ar" class="login-logout"><?php echo $lang['lang_ar']?></a>
						</div>

						<?php }


						else if(isset($_GET['name']) ) { 

							?>
						
						<div class="float-right ">
						<a href="?name=<?php echo $_GET['name']; ?>&lang=en" class="login-logout"><?php echo $lang['lang_en'] ?></a>
						| <a href="?name=<?php echo $_GET['name']; ?>&lang=ar" class="login-logout"><?php echo $lang['lang_ar']?></a>
						</div>

						<?php }


						else { 

						?>
							
						<div class="float-right ">
							<a href="?lang=en" class="login-logout"><?php echo $lang['lang_en'] ?></a>
						| <a href="?lang=ar" class="login-logout"><?php echo $lang['lang_ar']?></a>
						</div>
						
						<?php }


						


		   	  }else{

     	           ?>
				     	<a href="login.php">	
				     		<strong class="login-logout"><?php echo $lang['LOG_IN']?> / <?php echo $lang['SIGN_UP']?></strong>
				     	</a>
						<?php 

						if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {

							$category =intval($_GET['pageid']);
							
						
							?>
						 <div class="float-right ">
						    <a href="?pageid=<?php echo $category; ?>&lang=en" class="login-logout"><?php echo $lang['lang_en'] ?></a>
						  | <a href="?pageid=<?php echo $category; ?>&lang=ar" class="login-logout"><?php echo $lang['lang_ar']?></a>
						 </div>
						 
					<?php 
						}
						else if(isset($_GET['itemid']) && is_numeric($_GET['itemid'])) { 

							$item =intval($_GET['itemid']); ?>
							
						 <div class="float-right ">
						    <a href="?itemid=<?php echo $item; ?>&lang=en" class="login-logout"><?php echo $lang['lang_en'] ?></a>
						  | <a href="?itemid=<?php echo $item; ?>&lang=ar" class="login-logout"><?php echo $lang['lang_ar']?></a>
						 </div>
						
						<?php }

						else if(isset($_GET['name']) ) { 

							?>

						<div class="float-right ">
						<a href="?name=<?php echo $_GET['name']; ?>&lang=en" class="login-logout"><?php echo $lang['lang_en'] ?></a>
						| <a href="?name=<?php echo $_GET['name']; ?>&lang=ar" class="login-logout"><?php echo $lang['lang_ar']?></a>
						</div>

						<?php }



						else { 

						?>
						
						<div class="float-right ">
							<a href="?lang=en" class="login-logout"><?php echo $lang['lang_en'] ?></a>
						| <a href="?lang=ar" class="login-logout"><?php echo $lang['lang_ar']?></a>
						</div>
					
						<?php }

     	  } ?>
     </div>



   </div>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-inverse ">
          <div class="container">

          	
            <a class="navbar-brand " href="index.php?lang=<?php echo $_SESSION['lang']; ?>"><img class="logo" src="red-simple-shopping-cart-icon-12.png">  <?php echo $lang['HOME']?></a>
             

             	 <div class="navbar-header ">
					   
					          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							    <span class="navbar-toggler-icon"></span>
							  </button>
			    </div>
			            
				  <div class="collapse navbar-collapse justify-content-end" id="app-nav">
           
				    <ul class="nav navbar-nav " >
				     
				         <?php

					if (!isset($_SESSION['lang']))

					$_SESSION['lang'] = "en";

			
								if ($_SESSION['lang']=="en") 

									{ 
										

										$allCats = getAllfrom("*" , "categories", "WHERE parent = 0","","ID","ASC");
										foreach ( $allCats as $cat )
										 {
								
											echo "<li class ='nav-item active' >
													<a href ='categories.php?pageid=".$cat['ID']."&lang=".$_SESSION['lang']."' class ='nav-link'>
													" . $cat['Name'] . "
													</a>
													</li>";

									      }
							    	}else if($_SESSION['lang']=="ar")

									  {
										  
										  $allCats = getAllfrom("*" , "categories", "WHERE parent = 0","","ID","ASC");
									      foreach ( $allCats as $cat )
											{
									
												echo "<li class ='nav-item active' >
														<a href ='categories.php?pageid=".$cat['ID']."&lang=".$_SESSION['lang']."' class ='nav-link'>
														" . $cat['ar_Name'] . "
														</a>
														</li>";

											}
									  }
				    	
				          ?>
				   </ul>
			
			
			
	       </div>
	   </div>
		</nav>

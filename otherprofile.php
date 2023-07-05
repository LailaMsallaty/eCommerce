<?php 
ob_start();
session_start();

/*
================================================================
== manage prifile page
== you can edit profile from here 
================================================================

*/
  $pageTitle = $_GET['name'] .' Profile';

  include 'init.php';

 if (isset($_SESSION['user'])) {
        
		 if(isset($_GET['name'])){

		  $name = $_GET['name'];

		}

    $getUser = $conn ->prepare(" SELECT * FROM users Where Username = ? ");

    $getUser->execute(array($name));

    $info = $getUser -> fetch();

    $userid = $info['UserID'];

    ?>
 <h1 class="text-center"><?php echo $info['Username']."".$lang['FOR']." ". $lang['PROFILE']?></h1>

    <div class="profile">

       <img class='img-fluid rounded-circle d-block m-auto' src="<?php
        if($info['avatar'] == '385-3856300_no-avatar-png.png')
        echo $info['avatar'] ;
        else echo "admin\uploads\avatars\\". $info['avatar']; ?>"  style="width: 300px; height: 300px;"/>


    </div>
    	<div class="information block">
    		
    		<div class="container">
              <div class="card card-default">
                <div class="card-header"><?php echo $info['Username'];  ?> <?php echo $lang['INFORMATION']?></div>
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
                      <span><?php echo $lang['REGISTER_DATE']?></span> : <?php echo $info['Date'] ?>
                    </li>
                    

                	</ul>
                  
                </div>
              </div>

    	    </div>
    	</div>
    	<div id="my-ads" class="my-ads block">
    		
    		<div class="container">
              <div class="card card-primary">
               <div class="card-header"><?php echo $info['Username']."".$lang['FOR']." ";?><?php echo $lang['ITEMS']?></div>
                <div class="card-body">           	
	               
				<?php
                $myItems =getAllfrom ("*" , "items", "where Member_ID = $userid ","AND Approve =1","Item_ID",);
                  if (!empty($myItems)){

                       echo " <div class='row'>";

      		             foreach ($myItems as $item) {
                       
                        echo "<div class = ' col-sm-12 col-md-6 col-lg-3'>";
                        echo "<div class='card item-box-profile' style='height:600px;'>";

                           echo "<span class ='price-tag' >". $item['Price']." ".$lang['S.P']."</span>";
                           echo "<div><img class='img-fluid img-item' src='admin\uploads\items\\".$item['item_photo']."' alt='' /></div>";

                             echo "<div class='caption'>";
                               echo "<h3><a href='items.php?itemid=" . $item['Item_ID'] . "'>" . $item['Name'] . "</a></h3>";
                               echo "<p class='description' style=' margin-left: 10px ; height:80px; '>" . $item['Description'] . "</p>";
                               echo "<p> <span style='color:#777;'></br>|  ".$lang['QUANTITY']." : ".$item['quantity']."</span></p>";
                               echo " <p class='country' >" . $item['Country_Made'] ."  <a href='index.php?add_card=".$item['Item_ID']."' class='btn btn-dark btn-sm'><i class ='fa fa-plus'></i>&nbsp; ".$lang['ADD_TO_CARD']."</a></p>";
                               echo "<div class='date'>" . $item['Add_Date'] . "</div>";
                             echo "</div>";
                        echo "</div>";
                      echo "</div>";
                 
                 }
                 echo "</div>";
                     }else {

                     echo $lang['NO_ITEMS'];

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

         on users.Username = card.member_name
         where users.UserID = ?
         and items.Approve=1
         ");

        // execute the statement

        $stmt->execute(array($userid));

        // asign to variable

        $items = $stmt->fetchAll();

                  if (!empty($items)){

                       echo " <div class='row'>";

      		             foreach ($items as $item) {
                       
      		             	echo "<div class = ' col-sm-12 col-md-6 col-lg-3'>";
      		                    echo "<div class='card item-box-profile' style='height:600px;'>";
  
      		                       echo "<span class ='price-tag' >". $item['Price']." ".$lang['S.P']."</span>";
                                 echo "<div><img class='img-fluid img-item' src='admin\uploads\items\\".$item['item_photo']."' alt='' /></div>";

      	                           echo "<div class='caption'>";
      		                           echo "<h3><a href='items.php?itemid=" . $item['Item_ID'] . "'>" . $item['Name'] . "</a></h3>";
                                     echo "<p class='description' style=' margin-left: 10px ; height:80px; '>" . $item['Description'] . " </p>";
                                     echo "<p> <span style='color:#777;'></br>|  ".$lang['QUANTITY']." : ".$item['quantity']."</span></p>";
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
                     $myComments =getAllfrom("comment" , "comments", "where user_id = $userid ","","c_id",);
			              

			               if (! empty($myComments)) {
			              
			                 foreach ( $myComments as $comment ) {
			                  echo "<p>". $comment['comment'] ."</p><hr>";
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
 }else{
     
       header('Location: login.php');
       exit();

     }
        include $tbl."footer.php"; 

ob_end_flush();
 ?>
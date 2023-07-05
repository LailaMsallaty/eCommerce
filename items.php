<?php  
ob_start();
session_start();

  $pageTitle = 'Show Item';

  include 'init.php';

 $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

     // echo $itemid;

     // select all data depend on this ID

  $stmt = $conn -> prepare("SELECT
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
                            where
                               Item_ID =?
                            AND 
                               Approve  =1");

         // excute query

   $stmt -> execute(array($itemid));

   // the row count

   $count = $stmt->rowCount();

       // if there's such id show the form

if ( $count > 0) {
 
 // fetch the data 

   $item= $stmt -> fetch();


?>
    
    <h1 class="text-center"><?php echo $item['Name']  ?></h1>
    <div class="container">
      <div class="row">
          <div class="col-lg-3 col-md-5  ">
            <img class='img-fluid item-photo' src='<?php echo "admin\uploads\items\\".$item['item_photo']  ?>' alt='' />
          </div>
          <div class="col-md-9 item-info">
             

              <p><?php echo $item['Description'] ?></p>

              <ul class="list-unstyled">
                  <li>
                    <i class="fa fa-calendar fa-fw"></i>
                    <span> <?php echo $lang['ADDED_DATE']?></span> : <?php echo $item['Add_Date'] ?>
                  </li>
                  <li>
                    <i class="fa fa-money-bill-wave fa-fw"></i>
                    <span>  <?php echo $lang['PRICE']?></span> : <?php echo $item['Price'] ?> <?php echo $lang['S.P']?>  
                  </li>
                  <li>
                    <i class="fa fa-building fa-fw"></i>
                    <span>  <?php echo $lang['MADE_IN']?></span> : <?php echo $item['Country_Made'] ?>
                  </li>
                  <li>
                    <i class="fa fa-tags fa-fw"></i>
                    <span>  <?php echo $lang['CATEGORY']?></span> : <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"><?php echo $item['Category_name'] ?></a>
                  </li>
                  <li>
                    <i class="fa fa-user fa-fw"></i>
                    <span>  <?php echo $lang['ADDED_BY']?></span> : <a href="otherprofile.php?name=<?php  echo $item['Username'] ?>"><?php echo $item['Username'] ?></a>
                  </li>
                  <li>
                  <i class="fas fa-list-ul"></i>
                    <span>  <?php echo $lang['STATUS']?></span> : <?php if ($item['Status']==1){
                      echo $lang['NEW'];}
                      else if($item['Status']==2){  echo $lang['LIKE_NEW'];}
                      else if($item['Status']==3){ echo $lang['USED'];}
                      else{echo $lang['VERY_OLD'];}
                     ?>
                  </li> 
                  <li class="tags-items">
                    <i class="fas fa-tag"></i>
                    <span>  <?php echo $lang['TAGS']?></span> :
                    <?php

                            $allTags = explode(",", $item['tags']);

                            foreach ($allTags as $tag )
                          {
                             $tag = str_replace(' ','',$tag);
                             $lowertag = strtolower($tag);

                               if (!empty($tag))
                               {
                                       echo "<a href ='tags.php?name=". $lowertag . " '>" . $tag . "</a> ";
                               }
                          }

                    ?>
                  </li>
                  <li>
                  <i class="fas fa-sort-amount-up"></i>
                    <span>  <?php echo $lang['QUANTITY']?></span> : <?php echo $item['quantity'] ?>
                  </li>
             </ul>
          </div>
      </div>

      <hr class="custom-hr">

      <?php if (isset($_SESSION['user'])) { ?>

      <!-- start add comment -->

        <div class="row">
          <div class="col-md-3"></div>
          <div class="add-comment">
            <div class="col-md-9">
              <h3><?php echo $lang['ADD_COMMENT']?></h3>
              <form action="<?php echo $_SERVER['PHP_SELF'] ."?itemid=". $item['Item_ID']; ?>" method="POST">
                <textarea required name="comment"></textarea>
                <input class="btn btn-light" type="submit" style="color:#fff;" value="<?php echo $lang['ADD']?>"/>
              </form>

              <?php

                  if($_SERVER['REQUEST_METHOD']=='POST') {

                    $comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                    $userid  = $_SESSION['uid'];
                    $itemid  = $item['Item_ID'];

                    if (!empty($comment)) {

                     $stmt = $conn->prepare(" INSERT INTO 
                                                     comments(comment , status , comment_date, item_id, user_id ) 
                                               VALUES(:zcomment ,0, NOW(),:zitemid,:zuserid)");
                     $stmt->execute(array(

                       'zcomment' => $comment,
                       'zitemid'  => $itemid ,
                       'zuserid'  => $userid

                     ));

                     if ($stmt) {
                        echo "<div class='alert alert-success' >". $lang['APPROVE_COMMENT']."</div>";
                     }
                    }
                   }
              ?>
            </div>
        </div>
        </div>
    <!-- end add comment -->
  <?php }else{
               echo "<a href ='login.php' class='login-logout'>".$lang['LOG_IN']." </a>" .$lang['OR']. " <a class='login-logout' href ='login.php'>".$lang['SIGN_UP']." </a>".$lang['COMMENT_IF_NO_SESSION'];

             } ?>
      <hr class="custom-hr">
        <?php 

               $stmt = $conn ->prepare("SELECT comments.* ,users.Username AS Member,avatar
                                        FROM 
                                                comments
                                        INNER JOIN 
                                                users
                                        ON
                                                users.UserID = comments.user_id 
                                        WHERE 
                                                Item_ID = ?
                                        AND 
                                                status =1
                                        ORDER BY c_id desc");

                     // execute the statement

               $stmt->execute(array($item['Item_ID']));

                     // asign to variable

               $comments = $stmt->fetchAll();

              
             foreach ($comments as $comment )

             { ?>
                  <div class="comment-box">
                        <div class='row'>
                        <div class='col-sm-3 text-center'>
                           <img class='img-fluid rounded-circle d-block m-auto' src='<?php echo "admin\uploads\avatars\\".$comment['avatar']  ?>' alt='' />
                           <?php echo "<a class='login-logout' href='otherprofile.php?name=".$comment['Member']."' >".$comment['Member']."</a>"; ?>
                        </div>
                        <div class='col-sm-9'>
                          <p class="lead "><?php echo $comment['comment'] ?></p>
                        </div>
                      </div>   
                  </div>
                  <hr class="custom-hr">

       <?php } ?>
       </div>
 

 <?php
        }else{

         echo "<div class ='container'>";

             echo "<div class ='alert alert-danger'>".$lang['NO_SUCH_ITEM']."</div>";

         echo "</div>";

        }

        ?> 
       <div style="margin-top:460px;">
    <?php 
  include $tbl."footer.php"; 

  ob_end_flush();			?>
  </div>
    
  
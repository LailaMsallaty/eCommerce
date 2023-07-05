  <?php  

        ob_start(); // output buffering start 

        session_start();


       
        if(isset($_SESSION['Username'])) // If there is a session already registered
        {  

          $pageTitle = 'Dashboard';

          include 'init.php';

         // print_r($_SESSION);

         /* start dashboard page */

          $numUsers = 5; // number of latest users
          
          $latestUsers = getLatest("*" , "users" , "UserID" ,$numUsers);  // latest users Array

          $numItems = 5; // number of latest items

          $latestItems = getLatest("*" , "items" , "Item_ID" ,$numItems);  // latest items Array

          $numComments = 5 ; // number of latest comments
        
         ?>
             <div class="home-stats"> 
                   <div class="container  text-center">               
                        <h1>Dashboard</h1>
                        <div class="row">
                            <div class="col-md-6 col-lg-3 col-sm-12">                       
                                 <div class="stat st-members">
                                      <i class="fa fa-users "></i>
                                      <div class="info">
                                         Total Members
                                       <span><a href="members.php"><?php echo countItems('UserID', 'users'); ?></a></span> 
                                      </div>
                                 </div>
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12">                     
                                 <div class="stat st-pending">
                                      <i class="fa fa-user-plus"></i>
                                      <div class="info">
                                         Pending Members
                                       <span><a href="members.php?do=Manage&page=Pending">
                                        <?php echo checkItem("RegStatus", "users", 0); ?></a></span>
                                      </div>
                                 </div>
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12">                       
                                 <div class="stat st-items">
                                     <i class="fa fa-tag"></i>
                                     <div class="info">
                                       Total Items
                                     <span><a href="items.php"><?php echo countItems('Item_ID', 'items'); ?></a></span>    
                                     </div>
                                 </div>
                            </div>
                            <div class="col-md-6 col-lg-3 col-sm-12">                       
                                 <div class="stat st-comments">
                                    <i class="fa fa-comments"></i>
                                    <div class="info">
                                      Total Comments
                                       <span>
                                         <a href="comments.php"><?php echo countItems('c_id', 'comments'); ?></a>
                                       </span>
                                    </div>
                                     
                                 </div>
                            </div>
                        </div>
                   </div>
             </div>


            <div class="latest">
               <div class="container">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="card card-default">
                          <div class="card-header">
                             <i class="fa fa-users"></i> Latest <?php echo $numUsers; ?> Registerd Users
                             <span class="toggle-info float-right">
                               <i class="fa fa-minus fa-lg"></i>
                             </span>
                          </div>
                          <div class="card-body">
                            <ul class="list-unstyled latest-users">
                                  <?php 
                                     if (! empty($latestUsers)) { 
                                     foreach ($latestUsers as $user)
                                        {
                                               
                                     echo "<li>". $user['Username'] . "
                                             <a href='members.php?do=Edit&userid=". $user['UserID'] . "'>
                                                 <span class='btn btn-success float-right'><i class = 'fa fa-edit'></i>
                                                  Edit ";

                                            if ($user['RegStatus']==0) {
                                         
                                                     echo " <a href='members.php?do=Activate&userid=". $user['UserID']."' class='btn btn-info float-right activate'><i class='fas fa-check'></i> Activate</a>";



                                                                      }


                                           echo" </span>
                                             </a>
                                           </li>";
  

                                        }
                                      }else
                                            { echo "There's No Member To Show";}
                                  ?>
                            </ul>
                          </div>
                      </div>
                    </div>
                     <div class="col-sm-6">
                      <div class="card card-default">
                          <div class="card-header">
                             <i class="fa fa-tag"></i> Latest <?php echo $numItems; ?>  Items
                              <span class="toggle-info float-right">
                               <i class="fa fa-minus fa-lg"></i>
                             </span>
                          </div>
                          <div class="card-body">
                            
                             <ul class="list-unstyled latest-users">
                                  <?php 
                                   if (! empty($latestItems)) { 
                                     foreach ($latestItems as $item)
                                        {
                                               
                                     echo "<li>". $item['Name'] . "
                                             <a href='items.php?do=Edit&itemid=". $item['Item_ID'] . "'>
                                                 <span class='btn btn-success float-right'><i class = 'fa fa-edit'></i>
                                                  Edit ";

                                            if ($item['Approve']==0) {
                                         
                                                     echo " <a href='items.php?do=Approve&itemid=". $item['Item_ID']."' class='btn btn-info float-right activate'><i class='fas fa-check'></i> Approve</a>";



                                                                      }


                                           echo" </span>
                                             </a>
                                           </li>";
  

                                        }
                                      }else  { echo "There's No Item To Show";}
                                  ?>
                            </ul>

                          </div>
                      </div>
                    </div>
                  </div>
         <!-- start latest comments -->
                <div class="row">
                    <div class="col-sm-6">
                      <div class="card card-default">
                          <div class="card-header">
                             <i class="fa fa-comments"></i> Latest <?php echo $numComments; ?> Comments
                             <span class="toggle-info float-right">
                               <i class="fa fa-minus fa-lg"></i>
                             </span>
                          </div>
                          <div class="card-body">
                              <?php
                 
                                    $stmt = $conn ->prepare("SELECT comments.* ,avatar, users.Username AS Member
                                                              FROM 
                                                                      comments
                                                              INNER JOIN 
                                                                      users
                                                              ON
                                                                      users.UserID = comments.user_id
                                                              ORDER BY c_id desc
                                                              
                                                              limit   $numComments ");

                                           // execute the statement

                                     $stmt->execute();

                                           // asign to variable

                                     $comments = $stmt->fetchAll();
                                     if (!empty($comments)) {
                                      
                                     foreach ($comments as $comment) {

                                    
                                      echo "<div class='comment-box'>";
                                     
                                       echo "<span class='member-n'><img class='img-fluid rounded-circle ' src='";
                                     if($comment['avatar'] == '385-3856300_no-avatar-png.png')
                                       echo $comment['avatar'] ."'" ;
                                    else {echo "uploads/avatars/". $comment['avatar']."'";}
                                     echo "style='width: 50px; height: 50px;' id ='imagepreview' alt='Image Preview'/>
                                       <a href ='members.php?do=Edit&userid=" . $comment['user_id'] ."'>" . $comment['Member'] ."</a></span>";
                                       echo "<p class='member-c'>" . $comment['comment'] ."</p>";
                                      echo "</div>";
                                     
                                     }
                                    }else
                                    { echo "There's No Comment To Show"; }



                              ?>
                          </div>
                       </div>
                     </div>
                 </div>
                  <!-- end latest comments -->
               </div>
             </div>

        <?php

         /* end dashboard page */

          include $tbl."footer.php";
        }
        else
        {
          header('Location: index.php');
          exit();
        }

        ob_end_flush();
   ?>
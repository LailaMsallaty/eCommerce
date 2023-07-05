<?php  
        session_start();
        $noNavbar  = '';
        $pageTitle = 'Login';

       // print_r($_SESSION);

        if(isset($_SESSION['Username']))        // If there is a session already registered
        {
           header('Location: Dashboard.php');  //redirect to dashboard page


        }
        include 'init.php';
        
       //Check if User  comming from HTTP Post Request

       if($_SERVER['REQUEST_METHOD']=='POST')
       {
            
            $username = $_POST['user'];
            $password = $_POST['pass'];
            $HashedPass = sha1($password);

            //  echo $HashedPass;
           // echo $username ."".$password;


         // check if the user exist in database

         $stmt = $conn -> prepare("SELECT
                                      UserId, Username ,Password 
                                   From 
                                       users 
                                   where 
                                       Username = ? 
                                   And 
                                       Password = ? 
                                   AND 
                                       GroupID = 1
                                   limit  1");

         $stmt -> execute(array($username ,$HashedPass));
         $row= $stmt -> fetch();
         $count = $stmt->rowCount();

            //echo $count . '  ';
            // if count > 0 this mean the database contain record about this username

        if ($count > 0)
        {
          // $_SESSION['Username'] = $row['Username'];
           $_SESSION['Username'] = $username; //register session name
           $_SESSION['ID'] = $row['UserId'];  //register session ID
           $_SESSION['pass'] = $row['Password']; 
           header('Location: Dashboard.php'); //redirect to dashboard page
           exit();
              //echo "welcome".' '.$username;
         }
       }
?>

 

     <form class="login" action="<?PHP echo $_SERVER['PHP_SELF'] ?> " method="POST">
  	   	<h4 class="text-center Admin-login">Admin Login</h4>
             <input class="form-control form-control-lg" type="text" name="user" placeholder="username" autocomplete="off"/>
 
             <input class=" form-control form-control-lg" type="password"  name="pass" placeholder="password" autocomplete="off"/>
  		<input class="btn btn-light btn-block btn-lg" type="submit" value="Login" />
  
     </form>
		<!-- <?php 
              
           //   echo lang('MESSAGE').' '.LANG('ADMIN');
             
		     ?>
      	-->

  <?php include $tbl."footer.php"; ?>
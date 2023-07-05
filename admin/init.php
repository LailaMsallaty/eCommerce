<?php 

include 'connect.php';
    //Routes

		  $tbl  = 'includes/templates/';   // Template Directory 
      $lang = 'includes/languages/';  //  Language Directory
      $func = 'includes/functions/'; //   Function Directory
		  $css  = 'layout/css/';        //    Css Directory
		  $js   = 'layout/js/';        //     js Directory
         
     
$sessionUser ='';

if (isset($_SESSION['Username'])) {

 $sessionUser = $_SESSION['Username'];
}
    //include the important files

        include  $func.'functions.php';
        include  $lang.'english.php';
        include $tbl.'header.php'; 

    //include navbar on all pages except the one with $noNavbar variable
        
     if(!isset($noNavbar))
       {
        include $tbl.'navbar.php'; 
       }



?>
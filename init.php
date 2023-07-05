<?php 

// error Reporting

ini_set('display_errors', 'on');
error_reporting(E_ALL);

$sessionUser ='';

if (isset($_SESSION['user'])) {

 $sessionUser = $_SESSION['user'];

}

include 'admin/connect.php';
    //Routes

		  $tbl  = 'includes/templates/';   // Template Directory 
      $lang = 'includes/languages/';  //  Language Directory
      $func = 'includes/functions/'; //   Function Directory
		  $css  = 'layout/css/';        //    Css Directory
		  $js   = 'layout/js/';        //     js Directory
         

    //include the important files

        include  $func.'functions.php';
        include  'config.php';
        include $tbl.'header.php'; 
       
  



?>
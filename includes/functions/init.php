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

         

    //include the important files

      
        include  'config.php';
     
       
  



?>
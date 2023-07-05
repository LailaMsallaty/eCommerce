<?php

/*
**
** Template Page
**
*/

 ob_start();  // output buffering start 

 session_start();

 $pageTitle = '';


 if(isset($_SESSION['Username'])) // If there is a session already registered
{  

         

	           include 'init.php';


	           $do = isset($_GET['do']) ? $_GET['do']  : 'Manage';

	                 

		          if ($do == 'Manage'){           // manage members page 


		          }elseif ($do == 'Add'){


	              }elseif ($do == 'Insert'){
	       
	         

	              }elseif ($do == 'Edit'){
	       
	         

	              }elseif ($do == 'Update'){
	       
	         

	              }elseif ($do == 'Delete'){
	       
	         

	              }elseif ($do == 'Activate'){
	       
	         

	              }
	                include $tbl."footer.php";
}
        else
	        {
	          
	          header('Location: index.php');
	          exit();

	        }

	     ob_end_flush();
?>
<?php



/*
** get  all function v2.0
** Function to get the all from database 
*/


function getAllfrom ($field , $table ,$Where =NULL , $and =NULL,$orderfield ,$ordering ='DESC'){

  global $conn;


    $getAll = $conn ->prepare("SELECT $field FROM  $table $Where $and ORDER BY $orderfield $ordering  ");

    $getAll->execute();

    $all =  $getAll -> fetchAll();

    return  $all;

} 

/*
         title function v1.0
		 title function that echo the page title in case the page has the variable 
		 $PageTitle and echo default title for other pages

*/
 function getTitle()
 {


    global $pageTitle;


		if(isset($pageTitle))
	       
	          {
			      echo "$pageTitle";
			  }

	    else{ echo "Default"; }


 }       

 /*
 ** Home Redirect Function  v2.0
 ** [ this function accept parameters ]
 ** $TheMsg = echo the message [ error | success | warning  ]
 ** $url = the link you want to Redirect to 
 ** $seconds  = seconds before Redirecting 
 */

  function redirectHome( $TheMsg , $url = null ,$seconds = 3 ){

   if ($url === null) {
  
    $url = 'index.php';
    $link = 'HomePage';

  }else{

           if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

              $url = $_SERVER['HTTP_REFERER'];

              $link = 'Previous Page';

           }else {

              $url = 'index.php';

              $link = 'HomePage';

           }

        

       }

  echo $TheMsg;

  echo "<div class ='alert alert-info' role='alert'>You Wil Be Directed To ".$link." After $seconds seconds</div> ";

  header("refresh:$seconds;url=$url");

  exit();

 }
 
 /*
 ** check items function v1.0
 ** function to check item in database [ function accept parameters ]
 ** $select = the item to select [ example : user , item , category ] 
 ** $from   = the table to select from [ example : users , items , categories ]
 ** $value  = the value of select [ example :laila , box , electronies ]
 */

function checkItem( $select , $from , $value){

    global $conn ;

  	$statement = $conn -> prepare("SELECT $select FROM $from WHERE $select =?");

    $statement->execute(array($value));

    $count = $statement -> rowCount();

    return $count;
 
}

/*
** count number of items function v1.0
** function to count number of items rows 
** $item = item to count
** $table = the table to choose from 
*/

function countItems($item , $table){

          
          global $conn;


          $stmt2 = $conn ->prepare("SELECT COUNT($item) FROM $table ");

              // execute the statement

          $stmt2 ->execute();

                      
          return $stmt2 ->fetchColumn();


}


/*
** get latest record function v1.0
** Function to get the latest items from database [users , items , comments]
** $select = the field to select
** $table = the table to choose from
** $limit = number of record to get 
** $order = the DESC ordering
*/


function getLatest ($select , $table ,$order, $limit = 5){

  global $conn;

    $getStmt = $conn ->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit ");

    $getStmt->execute();

    $rows =  $getStmt -> fetchAll();

    return  $rows;

} 
?>
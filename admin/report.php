<?php

/*
**
** Report Page
**
*/

 ob_start();  // output buffering start 

 session_start();

 $pageTitle = 'Reports';


if(isset($_SESSION['Username'])) // If there is a session already registered  
{
         include 'init.php';
         

        ?>
        </br>
<div class="container" class=''>
     


 <div class="row" class='justify-content-center' style='margin-top:10px;'>
                <div class='col-sm-4'>
                   
                     <form  method='POST' action="#">
                        <label class="requiredField" for="date">
                        Date
                        </label>
                            
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar">
                                    </i>
                                </div>
                                <input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" type="text"/>
                            
                            </div>
                        
                        <input name="_honey" style="display:none" type="text"/>
                        <div class="input-group-append">
                            <button class="btn btn-light btn-sm mt-2" type="submit">Go</button>
                        </div>      
                 
                     </form>
                  
                </div>
           
           
             <div class='col-sm-4'>
                <form style='margin-top:31px;' method='POST' action="#">
                        <input type="text" name='price' class="form-control" placeholder="Enter The Price Item to Search">

                        <div class="input-group-append">
                            <button class="btn btn-light btn-sm mt-2" type="submit">Go</button>
                        </div>    
                </form>                   
                  
             </div>
           

             <div class='col-sm-4 '>
                <form style='margin-top:31px;' method='POST' action="#">
                        <input type="text" name='country' class="form-control" placeholder="Enter The Country Item to Search">
              
                        <div class="input-group-append">
                            <button class="btn btn-light btn-sm mt-2" type="submit">Go</button>
                        </div>    
                              
                  
                </form>
              </div>

                <div class='col-sm-4'>
                    <form  style='margin-top:31px;' method='POST' action="#">
                        <select  class="form-control" name="status" class="custom-select " >
                            <option value="0">...</option>
                            <option value="1">New</option>
                            <option value="2">like New</option>
                            <option value="3">Used</option>
                            <option value="4">Old</option>
                        </select>
                
                            <div class="">
                                <button  class="mt-2 btn btn-light btn-sm  " type="submit">Go</button>
                            </div>  
                </form>
               </div>

               <div class='col-sm-4'>
                    <form  style='margin-top:31px;' method='POST' action="#">
                    <select name="category">
                                <option value="0">...</option>
                                <?php 
                        $allCats = getAllfrom ('*' , 'categories' ,'WHERE parent = 0', '','ID');
                    
                        foreach ($allCats as $Cat ) {
                        echo "<option value ='".$Cat['ID']."'>".$Cat['Name']."</option>";

                        $childCats = getAllfrom ("*" , "categories" ,"WHERE parent =".$Cat['ID']."", "","ID");

                        foreach ( $childCats as $child ) {
                        
                        echo "<option value ='". $child['ID']."'> *** ". $child['Name']."</option>";


                        }
                    }   
                                ?>
                     </select>
                
                            <div class="">
                                <button  class="mt-2 btn btn-light btn-sm  " type="submit">Go</button>
                            </div>  
                </form>
               </div>

               <div class='col-sm-4'>
                <form style='margin-top:31px;' method='POST' action="#">
                        <input type="number" name='qty' class="form-control" placeholder="Enter The Quantity Item to Search">

                        <div class="input-group-append">
                            <button class="btn btn-light btn-sm mt-2" type="submit">Go</button>
                        </div>    
                </form>                   
                  
             </div>
     
   </div>
                <div class="row " style='margin-top:40px; margin-bottom:40px;'>
                   <div class='col-lg-3 col-sm-6 col-md-6'>
                        <form method='POST' action="#" style='margin-bottom:20px;'>
                            <button name='interactive' class="btn btn-dark btn-sm" type="submit">Most interactive Users </button>
                        </form>
                    </div>
                    <div class='col-lg-3 col-sm-6 col-md-6'>
                        <form method='POST' action="#" style='margin-bottom:20px;'>
                         <button name='soldout' class="btn btn-dark btn-sm" type="submit">Sold out Items</button>
                        </form>
                    </div>
                    <div class='col-lg-3 col-sm-6 col-md-6'>
                        <form  method='POST' action="#" style='margin-bottom:20px;'>
                            <button name='available' class="btn btn-dark btn-sm" type="submit">Available Items</button>
                        </form>
                    </div>
                    <div class='col-lg-3 col-sm-6 col-md-6'>
                        <form  method='POST' action="#" style='margin-bottom:20px;'>
                            <button name='popular' class="btn btn-dark btn-sm" type="submit">Most popular Item</button>
                        </form>
                    </div>
                                 
                 </div>    
</div>
        
        
        <?php

if($_SERVER['REQUEST_METHOD']=='POST')

{  
    if(isset($_POST['status'])){

                    $status = $_POST['status'];

                    $stmt1 = $conn ->prepare("SELECT *
                    FROM items
                    where Status = ?
                     ");

                    // execute the statement

                    $stmt1->execute(array($status));

                    // asign to variable

                    $rows = $stmt1->fetchAll();

                 
                    if ( ! empty($rows)){
                    ?>
                      <div class="container" class=''>
                    <div class='col-12'>
                    
                        <textarea style='font-size:30px;' class='form-control text-center' name="result" id='note' cols="30" rows="10" ><?php foreach ($rows as $row ) {echo "
";echo $row['Name']."
";
                                }
                                   
                            ?>
                        
                        </textarea>
                        
                    </div>
                    </div>
                     
                    <?php
                }else{

                    ?>
                    <div class="container" class=''>
                    <div class='col-12'>
                    <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" >No Records to Show
                    </textarea>
                    </div>
                    </div>
                    <?php
            }
            }


     else if(isset($_POST['price'])){

                    $price = $_POST['price'];

                    $stmt2 = $conn ->prepare("SELECT *
                    FROM items
                    where Price = ?
                     ");

                    // execute the statement

                    $stmt2->execute(array($price));

                    // asign to variable

                    $rows = $stmt2->fetchAll();

                 
                    if ( ! empty($rows)){
                    ?>
                      <div class="container" class=''>
                    <div class='col-12'>
                    
                    <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" ><?php foreach ($rows as $row ){echo "
".$row['Name']." ...... ".$row['Price']." ( s.p )
";
                                }
                                   
                            ?>
                        
                        </textarea>
                        
                    </div>
                    </div>
                     
                    <?php
                }else{

                        ?>
                        <div class="container" class=''>
                        <div class='col-12'>
                        <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" >No Records to Show
                        </textarea>
                        </div>
                        <div>
                        <?php
                }
            }


    else if(isset($_POST['country'])){

                $country = $_POST['country'];

                $stmt3 = $conn ->prepare("SELECT *
                FROM items
                where Country_Made = ?
                 ");

                // execute the statement

                $stmt3->execute(array($country));

                // asign to variable

                $rows = $stmt3->fetchAll();

             
                if ( ! empty($rows)){
                ?>
                  <div class="container" class=''>
                <div class='col-12'>
                
                <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" ><?php foreach ($rows as $row ){echo "
".$row['Name']." ...... ".$row['Country_Made']."
";
                            }
                               
                        ?>
                    
                    </textarea>
                    
                </div>
                </div>
                 
                <?php
            }else{

                    ?>
                    <div class="container" class=''>
                    <div class='col-12'>
                    <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" >No Records to Show
                    </textarea>
                    </div>
                    <div>
                    <?php
            }
        }

        
    else if(isset($_POST['date'])){

        $date = $_POST['date'];

        $stmt4 = $conn ->prepare("SELECT * 
        FROM items 
        WHERE DATE_FORMAT(CAST(Add_Date as DATE),'%m/%d/%Y') = ?
         ");
        // execute the statement

        $stmt4->execute(array($date));

        // asign to variable

        $rows = $stmt4->fetchAll();

     
        if ( ! empty($rows)){
        ?>
          <div class="container" class=''>
        <div class='col-12'>
        
        <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" ><?php foreach ($rows as $row ){echo "
".$row['Name']." ...... ".$row['Add_Date']."
";
                    }
                       
                ?>
            
            </textarea>
            
        </div>
        </div>
         
        <?php
    }else{

            ?>
            <div class="container" class=''>
            <div class='col-12'>
            <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" >No Records to Show
            </textarea>
            </div>
            <div>
            <?php
    }
}
    else if(isset($_POST['available'])){

        $available = $_POST['available'];

        $stmt5 = $conn ->prepare("SELECT * 
        FROM items 
        WHERE quantity > 0
        order by quantity
        desc
        ");
        // execute the statement

        $stmt5->execute();

        // asign to variable

        $rows = $stmt5->fetchAll();

    
        if ( ! empty($rows)){
        ?>
        <div class="container" class=''>
        <div class='col-12'>
        
        <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" ><?php foreach ($rows as $row ){echo "
".$row['Name']." ...... ".$row['quantity']."
";
                    }
                    
                ?>
            
            </textarea>
            
        </div>
        </div>
        
        <?php
    }else{

            ?>
            <div class="container" class=''>
            <div class='col-12'>
            <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" >No Records to Show
            </textarea>
            </div>
            <div>
            <?php
    }
    }

    else if(isset($_POST['soldout'])){

        $soldout = $_POST['soldout'];

        $stmt6 = $conn ->prepare("SELECT * 
        FROM items 
        WHERE quantity = 0
        ");
        // execute the statement

        $stmt6->execute();

        // asign to variable

        $rows = $stmt6->fetchAll();

    
        if ( ! empty($rows)){
        ?>
        <div class="container" class=''>
        <div class='col-12'>
        
        <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" ><?php foreach ($rows as $row ){echo "
".$row['Name']." ...... ".$row['quantity']."
";
                    }
                    
                ?>
            
            </textarea>
            
        </div>
        </div>
        
        <?php
    }else{

            ?>
            <div class="container" class=''>
            <div class='col-12'>
            <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" >No Records to Show
            </textarea>
            </div>
            <div>
            <?php
    }
    }

    else if(isset($_POST['popular'])){

        $popular = $_POST['popular'];

        $stmt7 = $conn ->prepare("SELECT items.* , card.*, count(card.item_id) As Count
        FROM items
        inner join card
        on
        items.Item_ID = card.item_id
        group by card.item_id
        order by Count desc
        
        ");
        // execute the statement

        $stmt7->execute();

        // asign to variable

        $rows = $stmt7->fetchAll();

    
        if ( ! empty($rows)){
        ?>
        <div class="container" class=''>
        <div class='col-12'>
        
        <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" ><?php foreach ($rows as $row ){echo "
".$row['Name']." ...... ".$row['Count']."
";}
                    
                ?>
            
            </textarea>
            
        </div>
        </div>
        
        <?php
    }else{

            ?>
            <div class="container" class=''>
            <div class='col-12'>
            <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" >No Records to Show
            </textarea>
            </div>
            <div>
            <?php
    }
    }
            
  else if(isset($_POST['category'])){

    $category = $_POST['category'];

    $stmt8 = $conn ->prepare("SELECT items.* , categories.Name As CatName
    FROM items
    inner join categories
    on items.Cat_ID = categories.ID
    where categories.ID =?
     ");

    // execute the statement

    $stmt8->execute(array($category));

    // asign to variable

    $rows = $stmt8->fetchAll();

 
    if ( ! empty($rows)){
    ?>
      <div class="container" class=''>
    <div class='col-12'>
    
        <textarea style='font-size:30px;' class='form-control text-center' name="result" id='note' cols="30" rows="10" ><?php foreach ($rows as $row ) {echo "
";echo $row['Name']." ...... ".$row['CatName']."
";}
                   
            ?>
        
        </textarea>
        
    </div>
    </div>
     
    <?php
}else{

    ?>
    <div class="container" class=''>
    <div class='col-12'>
    <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" >No Records to Show
    </textarea>
    </div>
    </div>
    <?php
}
}

else if(isset($_POST['qty'])){

    $quantity = $_POST['qty'];

    $stmt9 = $conn ->prepare("SELECT *
    FROM items
    where quantity = ?
     ");

    // execute the statement

    $stmt9->execute(array($quantity));

    // asign to variable

    $rows = $stmt9->fetchAll();

 
    if ( ! empty($rows)){
    ?>
      <div class="container" class=''>
    <div class='col-12'>
    
    <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" ><?php foreach ($rows as $row ){echo "
".$row['Name']." ...... ".$row['quantity']."
";
                }
                   
            ?>
        
        </textarea>
        
    </div>
    </div>
     
    <?php
}else{

        ?>
        <div class="container" class=''>
        <div class='col-12'>
        <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" >No Records to Show
        </textarea>
        </div>
        <div>
        <?php
}
}

    else{

        $interactive = $_POST['interactive'];

        $stmt10 = $conn ->prepare("SELECT users.* , items.*, count(items.Member_ID) As Count
        FROM users
        inner join items
        on
        users.UserID = items.Member_ID
        group by items.Member_ID
        order by Count desc
        
        ");
        // execute the statement

        $stmt9->execute();

        // asign to variable

        $rows = $stmt10->fetchAll();

    
        if ( ! empty($rows)){
        ?>
        <div class="container" class=''>
        <div class='col-12'>
        
        <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" ><?php foreach ($rows as $row ){echo "
".$row['Username']." ...... ".$row['Count']."
";}
                    
                ?>
            
            </textarea>
            
        </div>
        </div>
        
        <?php
    }else{

            ?>
            <div class="container" class=''>
            <div class='col-12'>
            <textarea style='font-size:30px;' class='form-control text-center' name="result" cols="30" rows="10" >No Records to Show
            </textarea>
            </div>
            <div>
            <?php
    }
    }

    
}     

}else{					
	          
    header('Location: index.php');
    exit();

  }
include $tbl."footer.php";
ob_end_flush();
?>
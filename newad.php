<?php  
ob_start();
session_start();

  $pageTitle = 'Create New Item';

  include 'init.php';

 if (isset($_SESSION['user'])) {
        
  if($_SERVER['REQUEST_METHOD']=='POST')
           {
              // upload variable 

              $photo = $_FILES['image'];

              $photoName = $_FILES['image']['name'];
              $photoSize  = $_FILES['image']['size'];
              $photoTmp  = $_FILES['image']['tmp_name'];
              $photoType = $_FILES['image']['type'];

              // List of allowed types to upload 

              $photoAllowedExtention = array("jpeg","jpg","png","gif");

              // Get Avatar extention 

              $photoExtention = explode('.' ,$photoName);
              $end  = end($photoExtention);
              $str = strtolower($end);

              $formErrors = array();
              $name      = $_POST['name'];
              $desc      = $_POST['description'];
              $price     = $_POST['price'];
              $country   = $_POST['country'];
              $status    = $_POST['status'];
              $cat       = $_POST['category'];
              $tags      = $_POST['tags'];
              $qty       =  $_POST['qty'];


              




           if (empty($name))
            {

            $formErrors[] = $lang['ITEM_NAME_VALIDATE'];;
                                 
            }
           if (strlen($name) < 3) {

            $formErrors[]  = $lang['ITEM_NAME_VALIDATE2'];;

           }
            
           if (strlen($desc) < 10) {

            $formErrors[]  = $lang['ITEM_DESCRIPTION_VALIDATE3'];

            }
            if (strlen($desc) > 100) {

            $formErrors[]  = $lang['ITEM_DESCRIPTION_VALIDATE2'];

            }
            if (empty($desc))
            {

            $formErrors[] = $lang['ITEM_DESCRIPTION_VALIDATE'];
                                 
            }
           if (strlen($country) < 3)
            {
 
            $formErrors[]  = $lang['ITEM_COUNTRY_VALIDATE2'];
 
            }
           if (empty($country))
            {

            $formErrors[] =  $lang['ITEM_COUNTRY_VALIDATE'];
                                 
            }
         

           if ($price < 0 || $price == 0 ) {

            $formErrors[] = $lang['ITEM_PRICE_VALIDATE2'];
         
          }
          if ($qty < 0 || $qty == 0) {

            $formErrors[] = $lang['ITEM_QTY_VALIDATE'];
        
          }
           if ($status == 0 )
           {

            $formErrors[]  = $lang['ITEM_STATUS_VALIDATE'];

           }
           if ($cat == 0)
           {
 
            $formErrors[]  = $lang['ITEM_CATEGORY_VALIDATE'];
 
           }

           if (empty($photoName))
           {
                                  
             $formErrors[] = $lang['ITEM_PHOTO_VALIDATE2'];

           }
                                 
           if (!empty($photoName) && ! in_array($str, $photoAllowedExtention)){

            $formErrors[] = $lang['ITEM_PHOTO_VALIDATE'];

           }

         
          

                         
            // 1024 byte * 4 = 4 kb = 4096 byte * 1024 = 4194304 byte = 4 mb

           if ($photoSize > 4194304){

            $formErrors[] = $lang['ITEM_PHOTO_VALIDATE3'];

           }

           if (empty($formErrors))
            {

                                    $photo = rand() .'_'.$photoName;
                                    move_uploaded_file($photoTmp, "admin\uploads\items\\" .$photo);
                    
 
                                       // Insert item Info In Database
                                    
                                   $stmt = $conn ->prepare("INSERT Into 
                                                            items(Name ,Description ,Price ,Country_Made , Status ,Add_Date , Cat_ID ,Member_ID ,tags ,quantity, item_photo)
                                                            VALUES (:zname, :zdesc, :zprice, :zcountry, :zstatus ,now(), :zcat, :zmember ,:ztags , :zqty ,:zphoto)");
 
                                    $stmt->execute(array(

                                      'zname'   => $name ,
                                      'zdesc'   => $desc ,
                                      'zprice'  => $price ,
                                      'zcountry'=> $country,
                                      'zstatus' => $status ,
                                      'zcat'    => $cat,
                                      'zmember' => $_SESSION['uid'] ,
                                      'ztags'   => $tags ,
                                      'zphoto'     => $photo,
                                      'zqty'    => $qty 
                                      
                                      
                                    ));

                                      // echo success message 

                                        if ($stmt) {

                                      $successMsg = $lang['ITEM_ADDED'];
                                        }
                   
                                      else {
                                                          
                                        echo "<div class ='alert alert-danger'>". $lang['ERROR']." </div>";
                                        
                                      }
                    }
                               


        }

?>
    
    <h1 class="text-center"><?php echo $lang['CREATE_NEW_ITEM'] ?></h1>
    	<div class="create-ad block">
    		
    		<div class="container">
              <div class="card card-default">
                <div class="card-header"><?php echo $lang['NEW_ITEM'] ?></div>
                <div class="card-body">
                	<div class ='row'>
                    <div class="col-md-8">                        
                      <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"  enctype="multipart/form-data"  id="idForm">
                                             
                                                    <!-- Start Name field -->
                                 
                                                <div class="form-group row justify-content-center">
                                                  
                                                           <label class="col-sm-3 col-form-label-lg text-center"><?php echo $lang['NAME']?></label>

                                                             <div class="col-sm-7 col-md-9  ">
                                                                
                                                                <input
                                                                 pattern =".{3,}"
                                                                 title ="This Field Require At Least 3 Characters"
                                                                 type="text" name="name" class="form-control form-control-lg live"  placeholder="<?php echo $lang['PLACEHOLDER_ITEM_NAME']?>" 
                                                                data-class =".live-title" required="required"/>

                                                             </div>

                                                </div>
                                                    <!-- End Name field -->

                                                     <!-- Start Description field -->
                                 
                                                <div class="form-group row justify-content-center">
                                                  
                                                           <label class="col-sm-3 col-form-label-lg text-center"><?php echo $lang['DESCRIPTION']?></label>

                                                             <div class="col-sm-7 col-md-9 ">
                                                          
                                                                <textarea  pattern =".{10,}"
                                                                 title ="This Field Require At Least 10 Characters" name="description" id="" cols="30" rows="3" class="form-control form-control-lg live" placeholder="<?php echo $lang['PLACEHOLDER_ITEM_DESCRIPTION']?>" 
                                                                data-class =".live-desc" required></textarea>

                                                             </div>

                                                </div>
                                                    <!-- End Description field -->    

                                                    <!-- Start Price field -->
                                 
                                                <div class="form-group row justify-content-center">
                                                  
                                                           <label class="col-sm-3 col-form-label-lg text-center"><?php echo $lang['PRICE']?></label>

                                                             <div class="col-sm-7 col-md-9 ">
                                                                
                                                                <input type="text" name="price" class="form-control form-control-lg live" placeholder="<?php echo $lang['PLACEHOLDER_ITEM_PRICE']?>" 
                                                                data-class =".live-price" required />

                                                             </div>

                                                </div>
                                                    <!-- End Price field -->      

                                                    <!-- Start Country field -->
                                 
                                                <div class="form-group row justify-content-center">
                                                  
                                                           <label class="col-sm-3 col-form-label-lg text-center"><?php echo $lang['COUNTRY']?></label>

                                                             <div class="col-sm-7 col-md-9 ">
                                                                
                                                                <input type="text" name="country" class="form-control form-control-lg"  placeholder="<?php echo $lang['PLACEHOLDER_ITEM_COUNTRY']?>" required   />

                                                             </div>

                                                </div>
                                                    <!-- End Country field -->  

                                                    <!-- Start Status field -->
                                 
                                                <div class="form-group row justify-content-center">
                                                  
                                                           <label class="col-sm-3 col-form-label-lg text-center"><?php echo $lang['STATUS']?></label>

                                                             <div class="col-sm-7 col-md-9 ">                
                                                                <select name="status" required >
                                                                  <option value="0">...</option>
                                                                  <option value="1"><?php echo $lang['NEW']?></option>
                                                                  <option value="2"><?php echo $lang['LIKE_NEW']?></option>
                                                                  <option value="3"><?php echo $lang['USED']?></option>
                                                                  <option value="4"><?php echo $lang['VERY_OLD']?></option>
                                                                </select>

                                                             </div>

                                                </div>
                                                    <!-- End Status field -->   

                                                     <!-- Start Categories field -->
                                 
                                                <div class="form-group row justify-content-center">
                                                  
                                                           <label class="col-sm-3 col-form-label-lg text-center"><?php echo $lang['CATEGORY']?></label>

                                                             <div class="col-sm-7 col-md-9 ">                
                                                                <select name="category" required >
                                                                  <option value="0">...</option>
                                                                <?php 

                                                   $cats =  getAllfrom('*','categories' ,'','','ID');

                                                   foreach ($cats as $Cat ) {
                                                     if (isset($_SESSION['lang']) && $_SESSION['lang']=='ar' ) {
                                                      echo "<option value ='".$Cat['ID']."'>".$Cat['ar_Name']."</option>";
                                                     }else
                                                     echo "<option value ='".$Cat['ID']."'>".$Cat['Name']."</option>";
                                                   }
                                                     
                                                             ?>
                                                                </select>

                                                             </div>

                                                </div>
                                                    <!-- End Categories field --> 

                                                    <!-- Start Tags field -->
                                 
                                                <div class="form-group row justify-content-center">
                                                  
                                                           <label class="col-sm-3 col-form-label-lg text-center"><?php echo $lang['TAGS']?></label>

                                                             <div class="col-sm-7 col-md-9 ">
                                                                
                                                                <input type="text" name="tags" class="form-control form-control-lg"  placeholder="<?php echo $lang['PLACEHOLDER_ITEM_TAGS']?>"  />

                                                             </div>

                                                </div>
                                                    <!-- End Tags field -->

                                                   <!-- Start qty field -->
                                 
                                                 <div class="form-group row justify-content-center">
                                                  
                                                  <label class="col-sm-3 col-form-label-lg text-center"><?php echo $lang['QUANTITY']?></label>

                                                    <div class="col-sm-7 col-md-9 ">
                                                       
                                                       <input type="text" name="qty" class="form-control form-control-lg" required="required" placeholder="<?php echo $lang['PLACEHOLDER_ITEM_QUANTITY']?>"  />

                                                    </div>

                                                 </div>
                                                  <!-- End qty field -->

                                                    <!-- Start Item photo field -->

                                                  <div class="form-group row justify-content-center">
                                                    
                                                             <label class="col-sm-3 col-form-label-lg text-center"><?php echo $lang['ITEM_PHOTO']?></label>

                                                               <div class="col-sm-7 col-md-9">
                                                                  
                                                                  <input type="file" name="image" class="form-control form-control-lg" required="required" id="idupload"/>

                                                               </div>

                                                    </div>
                                                  

                                                   <!-- End Item photo field -->

                                                   <!-- Start submit field -->

                                                <div class="form-group row justify-content-center">
                                                  
                                                             <div class=" col-sm-4 col-md-6  col-lg-6">
                                                                
                                                                <input type="submit"  value="<?php echo $lang['ADD']?>" class="btn btn-light btn-lg" />

                                                             </div>

                                                </div>
                                                    <!-- End submit field -->

                                             </form>


                      </div>   
                      <div class="col-md-4">  
                          <div class='card item-box live-preview' style='height:500px; width:300px;'>
                               <span class ='price-tag' >
                              <span class="live-price">0</span> <?php echo $lang['S.P']?>
                               </span>
                               <img class='img-fluid'  src='computers-clipart-shopping-19.png' id ="imagepreview" alt="Image Preview" />
                               <div class='caption'>
                                    <h3 class="live-title"><?php echo $lang['NAME']?></h3>
                                    <p class="live-desc"><?php echo $lang['DESCRIPTION']?></p>
                               </div>
                          </div>
                      </div>                 
                   </div>

                   <!-- start looping through errors -->
                    
                     <?php
                                if (!empty($formErrors)) {
                                 foreach ($formErrors as $error) {
                                   echo "<div class='alert alert-danger' > " .  $error . "</div>";
                                 }
                                }
                                 if (isset($successMsg)) {
             
                                     echo "<div class ='alert alert-success success'>" . $successMsg . "</div>";
                                   }
                     ?>

                    <!-- end looping through errors -->


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
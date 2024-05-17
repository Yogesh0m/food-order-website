<?php include('partials-front/menu.php'); ?>
<?php
   //Check whethet food id is set or not
   if(isset($_GET['food_id']))
   {
     $food_id=$_GET['food_id'];
     //Get the Details of the selected food
     $sql="SELECT * FROM tbl_food WHERE id=$food_id";
     $res=mysqli_query($conn,$sql);
     $count=mysqli_num_rows($res);
     
     //Check whether the data is available or not
     if($count==1)
     {
       $row=mysqli_fetch_assoc($res);

       $title=$row['title'];
       $price=$row['price'];
       $image_name=$row['image_name'];
     }
     else
     {
        header('location:' .SITEURL);
     }
   }
   else
   {
    header('location:' .SITEURL);
   }


?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php
                           //Check the image is available or not
                           if($image_name=="")
                           {
                            echo "<div class='error'>Image not Available.</div>";
                           }
                           else
                           {
                             ?>
                              <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                             <?php
                           }
                        
                        ?>
                       
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">
                        <p class="food-price">₹<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Yogesh Srivastava" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9760xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. yogeshshrivastav1234@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    
               
    
                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary" >

</form>
    
                </fieldset>

            </form>
                 <?php
                     //Check submit button or not
                     if(isset($_POST['submit']))
                     {
                        //Getting all Details from the Form
                      $food=$_POST['food'];
                      $price=$_POST['price'];
                      $qty=$_POST['qty'];
                      $total=$price * $qty;
                      $order_date=date("Y-m-d H:i:s A"); // //i=minitues, s=second, A=AM or PM
                      $status="ordered";  //Ordered, On Delivery, Delivery, Cancelled
                      $customer_name=$_POST['full-name'];
                      $customer_contact=$_POST['contact'];
                      $customer_email=$_POST['email'];
                      $customer_address=$_POST['address'];

                      //Set the order in DATABASE
                      //Crearte SQL QUERY to save the data
                      $sql2="INSERT INTO tbl_order SET 

                      food='$food',
                      price='$price',
                      qty='$qty',
                      total='$total',
                      order_date='$order_date',
                      status='$status',
                      customer_name='$customer_name',
                      customer_contact='$customer_contact',
                      customer_email='$customer_email',
                      customer_address='$customer_address'
                       ";

                       //Execute the query
                       $res2=mysqli_query($conn,$sql2);
                       
                       //Check the query is executed or not
                       if($res2==true)
                       {
                        $_SESSION['order']= "<div class='success text-center'>Food Ordered Successfully.</div>" ;
                        header('location:' .SITEURL);

                       }
                       else
                       {
                        $_SESSION['order']= "<div class='error text-center'>Failed to order Food.</div>" ;
                        header('location:' .SITEURL);

                       }

                     }
                   
                 ?>
        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>
<?php

session_start();

error_reporting(0);

include_once 'db_conn.php';

include_once 'header.php';


     $id = ($_GET['productID']);
     
     $string=strpos($id," ");
     
     $seller_email= substr($id,0,$string);
     
     $productId=substr($id,$string);
     
     $user_email=$_SESSION['username'];
          
     $productInfo="SELECT Product_Name,url FROM product_info WHERE Buyer_Email ='$user_email' AND Seller_Email ='$seller_email' AND Item_ID='$productId'";
    
     
     $result = mysqli_query($conn, $productInfo);
     
    
    
   
?>



<div class="container">
 <form method="POST" id="comment_form">
    Please give comment to this item
    
  
    <select>
        <?php $row1 = mysqli_fetch_array($result);?>
        
        <option value= "<?php echo $row1[0]; ?>">
            <?php echo $row1[0];?>
        </option>
        
        
    </select>
     <img src = "<?php echo $row1[1] ?>">
     <div class="form-group">
      <input type="text" name="comment_name" id="comment_name" class="form-control" value="<?php echo $_SESSION['username'] ?>" readonly/>
      
            <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5"></textarea>
           </div>
           <div class="form-group">
           
             <input type="hidden" name="Seller_Email" id="Seller_Email" value="<?php echo $seller_email ?>" />
             
            <input type="hidden" name="comment_id" id="comment_id" value="0" />
            <input type="hidden" name="productID" id="productID" value="<?php echo  $productId ?>" />
            <input type="submit" style=color:black name="submit" id="submit" class="btn btn-info" value="Submit" />
            <input type="button" onclick="location.href='./buy_record.php';"  style=color:black name="cancel" id="cancel" class="btn btn-info" value="Cancel" /></a>
           </div>
          </form>


</div>

<script>
 
$(document).ready(function(){




 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  
  var seller_email = $("#Seller_Email").val();

 
  

  
  $.ajax({
   url:"add_comment.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {


    if(data.error != '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');

     
    alert("Comment success");
    
    
    document.location.href = ('others_info.php?email='+seller_email);
 


    }
   }
  });
  
  
 
 
 });

 
 



});
</script>


<?php
    include_once 'footer.php';
?>
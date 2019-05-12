<?php







$connect = new PDO('mysql:host=localhost;dbname=s356f', 'root', '');

$error = '';
$comment_name = '';
$comment_content = '';
$Seller_Email = '';
$productId='';


if(empty($_POST["comment_name"]))
{
 $error .= '<p class="text-danger">Name is required</p>';
}
 
else
{
 
 

 $comment_name = $_POST["comment_name"];

}

if(empty($_POST["comment_content"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
}
else
{
 $comment_content = $_POST["comment_content"];

}

if(empty($_POST["Seller_Email"]))
{
 $error .= '<p error </p>';
}
else
{
 $Seller_Email = $_POST["Seller_Email"];

}

if(empty($_POST["productID"]))
{
 $error .= '<p error </p>';
}
else
{
 $productId=  $_POST["productID"];

}


if($error == '')
{
 $query = "
 INSERT INTO tbl_comment 
 (parent_comment_id, comment, Login_Email,Seller_Email,productID) 
 VALUES (:parent_comment_id, :comment, :Login_Email ,:Seller_Email,:productID)
 ";

 $query2="
 UPDATE product_info SET Comment='Y' WHERE Item_ID=$productId
 ";
 
 
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':parent_comment_id' => $_POST["comment_id"],
   ':comment'    => $comment_content,
   ':Login_Email' => $comment_name,
   ':Seller_Email' =>$Seller_Email,
   ':productID'=>$productId
  
  )

  
 );
 
 $statement2 = $connect->prepare($query2);
 $statement2->execute();
 
 
  
 $error = '<label class="text-success">Comment Added</label>';
 

}

$data = array(
 
 'error'  => $error
);

echo json_encode($data);

?>
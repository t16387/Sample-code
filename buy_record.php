<?php
    session_start();
    error_reporting(0);
    include_once 'header.php';
?>

<div class="container" style="margin-bottom: 20px;">

    <div class="col-md-12">

        <?php
            echo'<h2 class="page-header">Buy record of ' . $_SESSION['NickName'] . '</h2>';
        ?>

        <table class="table table-striped">

            <tr><th>Product Name</th><th>Price</th><th>Brand</th><th>Seller Email</th><th>Buy Date</th><th class = "notranslate">Like/Diske</th><th class="comment">Comment</th></tr>

            <?php
                $buy_record_sql = 'select Product_Name, Price, Brand, Seller_Email, Sell_Date, Islike, Item_ID,Comment from product_info where Buyer_Email = "' .$_SESSION['username'] .'" order by Sell_Date DESC';
                function Searching($buy_record_sql) {
                    include 'db_conn.php';
                    $resultas = mysqli_query($conn, $buy_record_sql);
                    return $resultas;
                }
            ?>

            <?php
                $buy_record_search = Searching($buy_record_sql);
            ?>

            <?php
                while ($buy_record_row = mysqli_fetch_array($buy_record_search)):
                    echo '<tr><td class = "notranslate">'.$buy_record_row[0].'</td><td class = "notranslate">'.$buy_record_row[1].'</td><td class = "notranslate">'.$buy_record_row[2].'</td>'
                        . '<td class = "notranslate"><a href=\'others_info.php?email='.$buy_record_row[3].'\';return false;>'.$buy_record_row[3].'</a></td><td class = "notranslate">'.$buy_record_row[4].'</td>';
                    if($buy_record_row[5] == ""){
                        echo '<td class = "notranslate"><form method="POST" action="?"><button class="btn btn-default" type="submit" name="like" value='.$buy_record_row[6].'>Like</button>'
                                . '<button class="btn btn-default" type="submit" name="dislike" value='.$buy_record_row[6].'>DisLike</button></td>';
                    }
                    elseif($buy_record_row[5] == "L"){
                        echo '<td class = "notranslate">Liked</td>';
                    }
                    elseif($buy_record_row[5] == "D"){
                        echo '<td class = "notranslate">Disliked</td>';
                    }
                    
                     if($buy_record_row[7] == ""||$buy_record_row[7] == "N"){
                echo'<td> <a href=\'comment.php?email&productID='.$buy_record_row[3].'+'.$buy_record_row[6].'\'; onclick="return confirm(\'You want to leave a comment?\')">No Comment</a></td></tr>';
                      
               }
               
              
               
                elseif($buy_record_row[7] == "Y"){
                  echo'<td> <a href=\'comment.php?email&productID='.$buy_record_row[3].'+'.$buy_record_row[6].'\'; onclick="return confirm(\'You want to add some more comments?\')">Commented</a></td></tr>';
             
               }
               
               
                endwhile;
            ?>

        </table>

    <div>

<div>

<?php
    if(isset($_POST['like'])){
        include 'db_conn.php';
        $query13 = "UPDATE product_info SET Islike = 'L' WHERE Item_ID = ".$_POST['like']."";
        if(mysqli_query($conn, $query13)){
            echo'<script>window.alert("Liked!")</script>';
            echo'<script>window.location = "?"</script>';
        }
    }
    if(isset($_POST['dislike'])){
        include 'db_conn.php';
        $query13 = "UPDATE product_info SET Islike = 'D' WHERE Item_ID = ".$_POST['dislike']."";
        if(mysqli_query($conn, $query13)){
            echo'<script>window.alert("Disliked!")</script>';
            echo'<script>window.location = "?"</script>';
        }
    }
?>


<?php
    include_once 'footer.php';
?>

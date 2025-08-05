<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once("dbconnect.php");
try{
    $sql= "SELECT  p.productID, p.productName, 
        p.price, p.description, p.Qty,
        p.imagePath, c.catName as category
        from product p, category c 
        where p.category = c.catID";
        $stmt= $conn->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll();
}catch(PDOException $e){
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "navbarcopy.php"; ?>
        </div>

        <div class="row"> <!--content-->
            <div class="col-md-3 py-5 px-5">
                <a href="insert_product.php" class="btn btn-outline-primary">New Product</a>

            </div>
            <div class="col-md-3">
                <!-- Sidebar or empty for now -->
            </div>
            <div class="col-md-9"> <!--table view-->
                <?php 
                if (isset($_SESSION['message'])) {
                    echo "<p class='alert alert-success'>$_SESSION[message]</p>";
                    unset($_SESSION['message']);
                }
                ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Category</td>
                            <td>Price</td>
                            <td>Quantity</td>
                            <td>Description</td>
                            <td>Image Path</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($products as $product)
                        {
                            echo"<tr>
                                <td>$product[productName]</td>
                                <td>$product[category]</td>
                                <td>$product[price]</td>
                                <td>$product[Qty]</td>
                                <td>$product[description]</td>
                                <td><img src=$product[imagePath] style=width:100px; height:100px></td>
                            </tr>";
                        }
                    ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</body>

</html>

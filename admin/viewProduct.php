<?php
require_once "dbconnect.php";

try {
    $sql = "SELECT p.productID, p.productName, c.catName, p.price, p.description, p.qty, p.imagePath
            FROM product p
            JOIN category c ON p.category = c.catID";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll();
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .table-wrapper {
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 1100px;
        }

        h3 {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        thead th {
            background-color: #0d6efd;
            color: white;
            vertical-align: middle;
        }

        tbody tr:hover {
            background-color: #e8f0ff;
            transition: 0.3s;
        }

        td, th {
            vertical-align: middle !important;
        }

        img {
            border-radius: 8px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div class="container table-wrapper">
    <h3>Product List</h3>
    <table class="table table-bordered align-middle table-hover text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price ($)</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($products)) : ?>
            <?php foreach ($products as $p) : ?>
                <tr>
                    <td><?= $p['productID'] ?></td>
                    <td><?= htmlspecialchars($p['productName']) ?></td>
                    <td><?= htmlspecialchars($p['catName']) ?></td>
                    <td><?= number_format($p['price'], 2) ?></td>
                    <td><?= nl2br(htmlspecialchars($p['description'])) ?></td>
                    <td><?= $p['qty'] ?></td>
                    <td>
                        <img src="<?= $p['imagePath'] ?>" alt="Product Image" width="70" height="60">
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="7" class="text-center text-danger">No products available.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>

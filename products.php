<?php
require_once('../config/functions.php');

if (!isAdminLoggedIn()) {
    redirect('../login.php');
}

$message = '';
$messageType = '';

// Handle product addition
if ($_POST && isset($_POST['add_product'])) {
    $name = sanitize($_POST['name']);
    $description = sanitize($_POST['description']);
    $price = floatval($_POST['price']);
    $category = sanitize($_POST['category']);
    $stock = intval($_POST['stock']);
    
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadResult = uploadImage($_FILES['image']);
        if ($uploadResult['success']) {
            $imageName = $uploadResult['filename'];
        } else {
            $message = $uploadResult['message'];
            $messageType = 'danger';
        }
    }
    
    if (empty($message)) {
        if (addProduct($name, $description, $price, $category, $stock, $imageName)) {
            $message = 'Product added successfully!';
            $messageType = 'success';
        } else {
            $message = 'Failed to add product.';
            $messageType = 'danger';
        }
    }
}

// Handle product deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $productId = intval($_GET['delete']);
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$productId])) {
        $message = 'Product deleted successfully!';
        $messageType = 'success';
    } else {
        $message = 'Failed to delete product.';
        $messageType = 'danger';
    }
}

$products = getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management | Merena Brand</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f4f4;
        }
        
        .sidebar {
            height: 100vh;
            background: linear-gradient(135deg, #d63384, #a52061);
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            padding: 20px 0;
        }
        
        .sidebar .logo {
            text-align: center;
            font-family: 'Great Vibes', cursive;
            font-size: 2rem;
            color: white;
            margin-bottom: 30px;
        }
        
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        
        .sidebar ul li {
            margin: 10px 0;
        }
        
        .sidebar ul li a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px 25px;
            transition: all 0.3s;
        }
        
        .sidebar ul li a:hover {
            background: rgba(255,255,255,0.1);
            padding-left: 35px;
        }
        
        .sidebar ul li a.active {
            background: rgba(255,255,255,0.2);
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .product-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .btn-admin {
            background-color: #d63384;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
            margin: 2px;
        }
        
        .btn-admin:hover {
            background-color: #a52061;
            color: white;
        }
        
        .btn-danger {
            background-color: #dc3545;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
        }
        
        .form-control {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">Merena Admin</div>
        <ul>
            <li><a href="dashboard.php"><i class='bx bx-home'></i> Dashboard</a></li>
            <li><a href="products.php" class="active"><i class='bx bx-package'></i> Products</a></li>
            <li><a href="orders.php"><i class='bx bx-shopping-bag'></i> Orders</a></li>
            <li><a href="customers.php"><i class='bx bx-user'></i> Customers</a></li>
            <li><a href="../index.php"><i class='bx bx-arrow-back'></i> View Site</a></li>
            <li><a href="logout.php"><i class='bx bx-log-out'></i> Logout</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1><i class='bx bx-package'></i> Products Management</h1>
        </div>
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Add Product Form -->
        <div class="product-card">
            <h3>Add New Product</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="name" class="form-control" placeholder="Product Name" required>
                        <textarea name="description" class="form-control" placeholder="Product Description" rows="3"></textarea>
                        <input type="number" name="price" class="form-control" placeholder="Price" step="0.01" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="category" class="form-control" placeholder="Category" required>
                        <input type="number" name="stock" class="form-control" placeholder="Stock Quantity" required>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
                <button type="submit" name="add_product" class="btn-admin">Add Product</button>
            </form>
        </div>
        
        <!-- Products List -->
        <div class="product-card">
            <h3>All Products (<?php echo count($products); ?>)</h3>
            
            <?php if (empty($products)): ?>
                <p>No products found.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <?php if ($product['image']): ?>
                                            <img src="../uploads/<?php echo $product['image']; ?>" class="product-image" alt="<?php echo $product['name']; ?>">
                                        <?php else: ?>
                                            <div class="product-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center;">No Image</div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['category']); ?></td>
                                    <td><?php echo formatCurrency($product['price']); ?></td>
                                    <td><?php echo $product['stock']; ?></td>
                                    <td>
                                        <span class="badge <?php echo $product['status'] == 'active' ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo ucfirst($product['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="?delete=<?php echo $product['id']; ?>" class="btn-admin btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

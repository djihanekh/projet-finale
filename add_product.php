<?php

require_once('../config/functions.php');

session_start();
require_once(__DIR__.'/../config/database.php');
require_once(__DIR__. '/../config/functions.php');
// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$messageType = '';

// Handle form submission
if ($_POST && isset($_POST['add_product'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $category = trim($_POST['category']);
    $stock = intval($_POST['stock']);
    $status = $_POST['status'];
    
    // Handle image upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $file_type = $_FILES['image']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                $image = $new_filename;
            } else {
                $message = "Failed to upload image";
                $messageType = 'danger';
            }
        } else {
            $message = "Invalid image type. Please upload JPG, PNG, GIF, or WebP";
            $messageType = 'danger';
        }
    }
    
    if (empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image, category, stock, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $description, $price, $image, $category, $stock, $status])) {
            $message = "Product added successfully!";
            $messageType = 'success';
            // Clear form
            $_POST = [];
        } else {
            $message = "Failed to add product";
            $messageType = 'danger';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Merena Brand</title>
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
        
        .sidebar ul li a:hover, .sidebar ul li a.active {
            background: rgba(255,255,255,0.1);
            padding-left: 35px;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            max-width: 800px;
        }
        
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .form-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #d63384;
            box-shadow: 0 0 0 3px rgba(214, 51, 132, 0.1);
        }
        
        .btn-primary {
            background-color: #d63384;
            border-color: #d63384;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background-color: #a52061;
            border-color: #a52061;
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">Merena Admin</div>
        <ul>
            <li><a href="dashboard.php"><i class='bx bx-home'></i> Dashboard</a></li>
            <li><a href="add_product.php" class="active"><i class='bx bx-plus'></i> Add Product</a></li>
            <li><a href="all_product.php"><i class='bx bx-package'></i> All Products</a></li>
            <li><a href="orders.php"><i class='bx bx-shopping-bag'></i> Orders</a></li>
            <li><a href="../index.php"><i class='bx bx-arrow-back'></i> View Site</a></li>
            <li><a href="logout.php"><i class='bx bx-log-out'></i> Logout</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1><i class='bx bx-plus'></i> Add New Product</h1>
        </div>
        
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="form-card">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Product Name *</label>
                            <input type="text" name="name" class="form-control" required 
                                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Category *</label>
                            <input type="text" name="category" class="form-control" required
                                   placeholder="e.g., Dresses, Tops, Bottoms"
                                   value="<?php echo isset($_POST['category']) ? htmlspecialchars($_POST['category']) : ''; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4"
                              placeholder="Product description..."><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Price (DA) *</label>
                            <input type="number" name="price" class="form-control" step="0.01" min="0" required
                                   value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Stock Quantity *</label>
                            <input type="number" name="stock" class="form-control" min="0" required
                                   value="<?php echo isset($_POST['stock']) ? $_POST['stock'] : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-control" required>
                                <option value="active" <?php echo (isset($_POST['status']) && $_POST['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo (isset($_POST['status']) && $_POST['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Product Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this)">
                    <img id="imagePreview" class="image-preview" alt="Image Preview">
                    <small class="text-muted">Supported formats: JPG, PNG, GIF, WebP (Max size: 5MB)</small>
                </div>
                
                <div class="form-group text-center">
                    <button type="submit" name="add_product" class="btn btn-primary">
                        <i class='bx bx-plus'></i> Add Product
                    </button>
                    <a href="all_product.php" class="btn btn-secondary ms-3">
                        <i class='bx bx-list-ul'></i> View All Products
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>



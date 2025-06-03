<?php
session_start();

// Check if user is admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

$product_id = $_GET['id'] ?? 0;

// Sample product data (in real app, fetch from database)
$products = [
    1 => [
        'id' => 1,
        'name' => 'Elegant Dress',
        'price' => 4600,
        'old_price' => 5000,
        'description' => 'This elegant dress is perfect for special occasions.',
        'category' => 'dresses',
        'sizes' => 'S,M,L,XL',
        'colors' => 'Black,White,Red',
        'inventory' => 15,
        'image' => '5836860766173646696_121.jpg'
    ],
    2 => [
        'id' => 2,
        'name' => 'Lovely Dress',
        'price' => 3600,
        'old_price' => 0,
        'description' => 'A lovely dress for your daily elegance.',
        'category' => 'dresses',
        'sizes' => 'S,M,L',
        'colors' => 'Pink,Blue',
        'inventory' => 20,
        'image' => 'projet.jpg'
    ]
];

$product = $products[$product_id] ?? null;

if (!$product) {
    header('Location: all_products.php');
    exit;
}

$message = '';
$messageType = '';

if ($_POST && isset($_POST['update_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $old_price = $_POST['old_price'];
    $product_description = $_POST['product_description'];
    $product_category = $_POST['product_category'];
    $product_sizes = implode(',', $_POST['product_sizes'] ?? []);
    $product_colors = implode(',', $_POST['product_colors'] ?? []);
    $inventory = $_POST['inventory'];
    
    // Handle file upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $uploadDir = '../uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = uniqid() . '_' . $_FILES['product_image']['name'];
        $uploadPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadPath)) {
            $message = "Product updated successfully! New image uploaded: " . $fileName;
            $messageType = 'success';
        } else {
            $message = "Product updated but image upload failed.";
            $messageType = 'warning';
        }
    } else {
        $message = "Product updated successfully!";
        $messageType = 'success';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Merena Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #e91e63;
            --secondary: #fce4ec;
            --dark: #212121;
            --light: #ffffff;
            --gray: #f5f5f5;
            --border: #e0e0e0;
            --success: #4caf50;
            --warning: #ff9800;
            --danger: #f44336;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--gray);
            color: var(--dark);
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 240px;
            background-color: var(--light);
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            padding: 20px 0;
        }
        
        .brand {
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            border-bottom: 1px solid var(--border);
            margin-bottom: 20px;
        }
        
        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .nav-item {
            margin-bottom: 5px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: #616161;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: var(--secondary);
            color: var(--primary);
        }
        
        .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        
        .main-content {
            flex: 1;
            padding: 30px;
            max-width: 800px;
        }
        
        .header {
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }
        
        .form-card {
            background: var(--light);
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
        }
        
        .form-col {
            flex: 1;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        
        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(233, 30, 99, 0.1);
        }
        
        .form-textarea {
            height: 120px;
            resize: vertical;
        }
        
        .file-upload-area {
            border: 2px dashed var(--border);
            border-radius: 6px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .file-upload-area:hover {
            border-color: var(--primary);
            background-color: var(--secondary);
        }
        
        .upload-icon {
            font-size: 48px;
            color: var(--primary);
            margin-bottom: 15px;
        }
        
        .upload-text {
            color: #666;
            margin-bottom: 10px;
        }
        
        .file-input {
            display: none;
        }
        
        .current-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }
        
        .form-submit {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            width: 100%;
        }
        
        .form-submit:hover {
            background-color: #c2185b;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(233, 30, 99, 0.3);
        }
        
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #4caf50;
        }
        
        .alert-warning {
            background-color: #fff3e0;
            color: #f57c00;
            border: 1px solid #ff9800;
        }
        
        .size-checkboxes, .color-checkboxes {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .checkbox-item input[type="checkbox"] {
            margin: 0;
        }
        
        .back-btn {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .back-btn:hover {
            background-color: #5a6268;
            color: white;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="brand">MERENA</div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="nav-item"><a href="add_product.php" class="nav-link"><i class="fas fa-plus-circle"></i> Add Product</a></li>
                <li class="nav-item"><a href="all_products.php" class="nav-link active"><i class="fas fa-product-hunt"></i> All Products</a></li>
                <li class="nav-item"><a href="orders.php" class="nav-link"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                <li class="nav-item"><a href="../index.php" class="nav-link"><i class="fas fa-arrow-left"></i> View Site</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <a href="all_products.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to All Products
            </a>
            
            <div class="header">
                <h1 class="page-title"><i class="fas fa-edit"></i> Edit Product: <?php echo htmlspecialchars($product['name']); ?></h1>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <i class="fas fa-<?php echo $messageType == 'success' ? 'check-circle' : 'exclamation-triangle'; ?>"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="form-card">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="product_name" class="form-input" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Price (DZ) *</label>
                                <input type="number" name="product_price" class="form-input" step="0.01" value="<?php echo $product['price']; ?>" required>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Old Price (DZ)</label>
                                <input type="number" name="old_price" class="form-input" step="0.01" value="<?php echo $product['old_price']; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Category *</label>
                                <select name="product_category" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <option value="dresses" <?php echo $product['category'] == 'dresses' ? 'selected' : ''; ?>>Dresses</option>
                                    <option value="blouses" <?php echo $product['category'] == 'blouses' ? 'selected' : ''; ?>>Blouses</option>
                                    <option value="pants" <?php echo $product['category'] == 'pants' ? 'selected' : ''; ?>>Pants</option>
                                    <option value="skirts" <?php echo $product['category'] == 'skirts' ? 'selected' : ''; ?>>Skirts</option>
                                    <option value="accessories" <?php echo $product['category'] == 'accessories' ? 'selected' : ''; ?>>Accessories</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-col">
                            <div class="form-group">
                                <label class="form-label">Inventory Count *</label>
                                <input type="number" name="inventory" class="form-input" value="<?php echo $product['inventory']; ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Product Description *</label>
                        <textarea name="product_description" class="form-textarea" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Available Sizes</label>
                        <div class="size-checkboxes">
                            <?php 
                            $currentSizes = explode(',', $product['sizes']);
                            $allSizes = ['XS', 'S', 'M', 'L', 'XL'];
                            foreach ($allSizes as $size): 
                            ?>
                            <div class="checkbox-item">
                                <input type="checkbox" name="product_sizes[]" value="<?php echo $size; ?>" id="size-<?php echo strtolower($size); ?>" <?php echo in_array($size, $currentSizes) ? 'checked' : ''; ?>>
                                <label for="size-<?php echo strtolower($size); ?>"><?php echo $size; ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Available Colors</label>
                        <div class="color-checkboxes">
                            <?php 
                            $currentColors = explode(',', $product['colors']);
                            $allColors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Pink'];
                            foreach ($allColors as $color): 
                            ?>
                            <div class="checkbox-item">
                                <input type="checkbox" name="product_colors[]" value="<?php echo $color; ?>" id="color-<?php echo strtolower($color); ?>" <?php echo in_array($color, $currentColors) ? 'checked' : ''; ?>>
                                <label for="color-<?php echo strtolower($color); ?>"><?php echo $color; ?></label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Current Product Image</label>
                        <div style="text-align: center; margin-bottom: 15px;">
                            <img src="../attached_assets/<?php echo $product['image']; ?>" alt="Current Image" class="current-image">
                        </div>
                        <label class="form-label">Upload New Image (Optional)</label>
                        <div class="file-upload-area" onclick="document.getElementById('product_image').click()">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="upload-text">Click to upload new image or drag and drop</div>
                            <div style="font-size: 12px; color: #999;">PNG, JPG, GIF up to 10MB</div>
                        </div>
                        <input type="file" name="product_image" id="product_image" class="file-input" accept="image/*">
                    </div>
                    
                    <button type="submit" name="update_product" class="form-submit">
                        <i class="fas fa-save"></i> Update Product
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Image preview functionality
        document.getElementById('product_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const currentImg = document.querySelector('.current-image');
                    currentImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Drag and drop functionality
        const uploadArea = document.querySelector('.file-upload-area');
        
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('product_image').files = files;
                document.getElementById('product_image').dispatchEvent(new Event('change'));
            }
        });
    </script>
</body>
</html>

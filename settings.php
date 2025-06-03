<?php
session_start();

// Check if user is admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: ../login.php');
    exit;
}

$message = '';
$messageType = '';

if ($_POST && isset($_POST['update_settings'])) {
    // Handle settings update
    $message = "Settings updated successfully!";
    $messageType = 'success';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Merena Admin</title>
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
        
        .settings-card {
            background: var(--light);
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            margin-bottom: 25px;
        }
        
        .card-header {
            padding: 20px 30px;
            border-bottom: 1px solid var(--border);
            background-color: var(--secondary);
        }
        
        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary);
            margin: 0;
        }
        
        .card-body {
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
            height: 100px;
            resize: vertical;
        }
        
        .form-submit {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
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
        
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background-color: var(--primary);
        }
        
        input:checked + .slider:before {
            transform: translateX(26px);
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
                <li class="nav-item"><a href="all_products.php" class="nav-link"><i class="fas fa-product-hunt"></i> All Products</a></li>
                <li class="nav-item"><a href="orders.php" class="nav-link"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                <li class="nav-item"><a href="customers.php" class="nav-link"><i class="fas fa-users"></i> Customers</a></li>
                <li class="nav-item"><a href="settings.php" class="nav-link active"><i class="fas fa-cog"></i> Settings</a></li>
                <li class="nav-item"><a href="../index.php" class="nav-link"><i class="fas fa-arrow-left"></i> View Site</a></li>
                <li class="nav-item"><a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="page-title"><i class="fas fa-cog"></i> Settings</h1>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <i class="fas fa-<?php echo $messageType == 'success' ? 'check-circle' : 'exclamation-triangle'; ?>"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <!-- Store Settings -->
            <div class="settings-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-store"></i> Store Information</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label class="form-label">Store Name</label>
                            <input type="text" name="store_name" class="form-input" value="Merena Brand" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Store Email</label>
                                    <input type="email" name="store_email" class="form-input" value="contact@merena.com" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Store Phone</label>
                                    <input type="text" name="store_phone" class="form-input" value="+213 555 0100" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Store Address</label>
                            <textarea name="store_address" class="form-textarea" required>Algiers, Algeria</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Store Description</label>
                            <textarea name="store_description" class="form-textarea" required>Merena Brand is your go-to destination for fashion that combines elegance, comfort, and affordability.</textarea>
                        </div>
                        
                        <button type="submit" name="update_settings" class="form-submit">
                            <i class="fas fa-save"></i> Save Store Settings
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Shipping Settings -->
            <div class="settings-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-shipping-fast"></i> Shipping Settings</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Home Delivery Fee (DZ)</label>
                                    <input type="number" name="delivery_fee" class="form-input" value="300" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Free Shipping Threshold (DZ)</label>
                                    <input type="number" name="free_shipping_threshold" class="form-input" value="8000">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Delivery Areas</label>
                            <textarea name="delivery_areas" class="form-textarea" required>All 48 wilayas of Algeria</textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Estimated Delivery Time</label>
                                    <input type="text" name="delivery_time" class="form-input" value="2-5 business days" required>
                                </div>
                            </div>
                            <div class="form-col">
                                <div class="form-group">
                                    <label class="form-label">Enable Pickup Option</label>
                                    <label class="switch">
                                        <input type="checkbox" name="enable_pickup" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" name="update_shipping" class="form-submit">
                            <i class="fas fa-save"></i> Save Shipping Settings
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Notification Settings -->
            <div class="settings-card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-bell"></i> Notification Settings</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label class="form-label">Email Notifications</label>
                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                                <label class="switch">
                                    <input type="checkbox" name="email_new_orders" checked>
                                    <span class="slider"></span>
                                </label>
                                <span>New Orders</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                                <label class="switch">
                                    <input type="checkbox" name="email_low_stock" checked>
                                    <span class="slider"></span>
                                </label>
                                <span>Low Stock Alerts</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <label class="switch">
                                    <input type="checkbox" name="email_new_customers" checked>
                                    <span class="slider"></span>
                                </label>
                                <span>New Customer Registrations</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Admin Email for Notifications</label>
                            <input type="email" name="admin_email" class="form-input" value="admin@merena.com" required>
                        </div>
                        
                        <button type="submit" name="update_notifications" class="form-submit">
                            <i class="fas fa-save"></i> Save Notification Settings
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

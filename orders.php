<?php
require_once('../config/functions.php');

if (!isAdminLoggedIn()) {
    redirect('../login.php');
}

$message = '';

// Handle status updates
if ($_POST && isset($_POST['update_status'])) {
    $orderId = intval($_POST['order_id']);
    $newStatus = sanitize($_POST['new_status']);
    
    if (updateOrderStatus($orderId, $newStatus)) {
        $message = "Order #{$orderId} status updated to {$newStatus}";
    } else {
        $message = "Failed to update order status";
    }
}

$orders = getAllOrders();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management | Merena Brand</title>
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
        
        .order-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-pending { background: #ffc107; color: #000; }
        .status-processing { background: #17a2b8; color: #fff; }
        .status-shipped { background: #6f42c1; color: #fff; }
        .status-delivered { background: #28a745; color: #fff; }
        .status-cancelled { background: #dc3545; color: #fff; }
        
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
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">Merena Admin</div>
        <ul>
            <li><a href="dashboard.php"><i class='bx bx-home'></i> Dashboard</a></li>
            <li><a href="products.php"><i class='bx bx-package'></i> Products</a></li>
            <li><a href="orders.php" class="active"><i class='bx bx-shopping-bag'></i> Orders</a></li>
            <li><a href="customers.php"><i class='bx bx-user'></i> Customers</a></li>
            <li><a href="../index.php"><i class='bx bx-arrow-back'></i> View Site</a></li>
            <li><a href="logout.php"><i class='bx bx-log-out'></i> Logout</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1><i class='bx bx-shopping-bag'></i> Orders Management</h1>
        </div>
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="order-card">
            <h3>All Orders (<?php echo count($orders); ?>)</h3>
            
            <?php if (empty($orders)): ?>
                <p>No orders found.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?php echo $order['order_number']; ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($order['user_name'] ?? 'Guest'); ?><br>
                                        <small><?php echo htmlspecialchars($order['user_email'] ?? ''); ?></small>
                                    </td>
                                    <td><?php echo formatCurrency($order['total_amount']); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $order['status']; ?>">
                                            <?php echo ucfirst($order['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                    <td>
                                        <form method="POST" style="display: inline;">
                                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                            <select name="new_status" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                                                <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                                <option value="shipped" <?php echo $order['status'] == 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                                                <option value="delivered" <?php echo $order['status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                                <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                            <button type="submit" name="update_status" class="btn-admin">Update</button>
                                        </form>
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

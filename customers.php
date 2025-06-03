<?php
require_once('../config/functions.php');

if (!isAdminLoggedIn()) {
    redirect('../login.php');
}

$users = getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers Management | Merena Brand</title>
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
        
        .customer-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">Merena Admin</div>
        <ul>
            <li><a href="dashboard.php"><i class='bx bx-home'></i> Dashboard</a></li>
            <li><a href="products.php"><i class='bx bx-package'></i> Products</a></li>
            <li><a href="orders.php"><i class='bx bx-shopping-bag'></i> Orders</a></li>
            <li><a href="customers.php" class="active"><i class='bx bx-user'></i> Customers</a></li>
            <li><a href="../index.php"><i class='bx bx-arrow-back'></i> View Site</a></li>
            <li><a href="logout.php"><i class='bx bx-log-out'></i> Logout</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1><i class='bx bx-user'></i> Customers Management</h1>
        </div>
        
        <div class="customer-card">
            <h3>All Customers (<?php echo count($users); ?>)</h3>
            
            <?php if (empty($users)): ?>
                <p>No customers found.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['phone'] ?? 'Not provided'); ?></td>
                                    <td><?php echo htmlspecialchars($user['address'] ?? 'Not provided'); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>


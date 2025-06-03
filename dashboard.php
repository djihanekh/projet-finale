<?php
session_start();

// Check if user is admin
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Merena Brand</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #d63384;
        }
        
        .stat-card h3 {
            margin: 0;
            font-size: 2rem;
            color: #333;
        }
        
        .stat-card p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 1.1rem;
        }
        
        .btn-admin {
            background-color: #d63384;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
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
            <li><a href="orders.php"><i class='bx bx-shopping-bag'></i> Orders</a></li>
            <li><a href="customers.php"><i class='bx bx-user'></i> Customers</a></li>
            <li><a href="../index.php"><i class='bx bx-arrow-back'></i> View Site</a></li>
            <li><a href="logout.php"><i class='bx bx-log-out'></i> Logout</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <h1>Dashboard</h1>
            <p>Welcome, <?php echo $_SESSION['admin_name'] ?? $_SESSION['user']; ?>!</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <i class='bx bx-package'></i>
                <h3>24</h3>
                <p>Total Products</p>
            </div>
            
            <div class="stat-card">
                <i class='bx bx-shopping-bag'></i>
                <h3>156</h3>
                <p>Total Orders</p>
            </div>
            
            <div class="stat-card">
                <i class='bx bx-user'></i>
                <h3>89</h3>
                <p>Total Customers</p>
            </div>
            
            <div class="stat-card">
                <i class='bx bx-money'></i>
                <h3>582,400 DA</h3>
                <p>Total Revenue</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="stat-card">
                    <h4>Quick Actions</h4>
                    <a href="products.php" class="btn-admin">Manage Products</a>
                    <a href="orders.php" class="btn-admin">View Orders</a>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="stat-card">
                    <h4>Recent Activity</h4>
                    <p>5 new orders today</p>
                    <p>2 products added</p>
                    <p>3 customers registered</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
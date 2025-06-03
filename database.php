<?php
$host = 'localhost';
$dbname = 'merena_brand';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Create tables if they don't exist
function createTables() {
    global $pdo;
    
    try {
        // Admin table
        $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        // Users table
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            phone VARCHAR(20),
            address TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        // Products table with image support
        $pdo->exec("CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            image VARCHAR(255),
            category VARCHAR(100),
            stock INT DEFAULT 0,
            status ENUM('active', 'inactive') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        // Orders table
        $pdo->exec("CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            customer_name VARCHAR(100) NOT NULL,
            customer_email VARCHAR(100) NOT NULL,
            customer_phone VARCHAR(20) NOT NULL,
            customer_address TEXT NOT NULL,
            total_amount DECIMAL(10,2) NOT NULL,
            products TEXT,
            status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
            order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
        )");

        // Order items table
        $pdo->exec("CREATE TABLE IF NOT EXISTS order_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            product_id INT NOT NULL,
            product_name VARCHAR(255) NOT NULL,
            quantity INT NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        )");

        // Insert default admin if not exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE email = 'admin@merena.com'");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $pdo->prepare("INSERT INTO admins (name, email, password) VALUES (?, ?, ?)")
                ->execute(['Admin', 'admin@merena.com', $adminPassword]);
        }

        // Insert sample products if table is empty
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM products");
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            $products = [
                ['Elegant Dress', 'Beautiful elegant dress perfect for special occasions', 4500.00, 'dress1.jpg', 'Dresses', 25],
                ['Casual T-Shirt', 'Comfortable cotton t-shirt for everyday wear', 1200.00, 'tshirt1.jpg', 'Tops', 50],
                ['Designer Jeans', 'Premium quality denim jeans with modern fit', 3200.00, 'jeans1.jpg', 'Bottoms', 30],
                ['Summer Blouse', 'Light and airy blouse perfect for summer', 2100.00, 'blouse1.jpg', 'Tops', 40],
                ['Evening Gown', 'Stunning evening gown for formal events', 8500.00, 'gown1.jpg', 'Dresses', 15]
            ];
            
            $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image, category, stock) VALUES (?, ?, ?, ?, ?, ?)");
            foreach ($products as $product) {
                $stmt->execute($product);
            }
        }

    } catch(PDOException $e) {
        echo "Error creating tables: " . $e->getMessage();
    }
}

// Uncomment to create tables (run once)
// createTables();
?>

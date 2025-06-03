<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'merena_brand';
$username = 'root';
$password = '';

// For this example, we'll use a simple file-based storage
// In production, you should use a proper database
$users_file = 'users.json';

// Initialize users file if it doesn't exist
if (!file_exists($users_file)) {
    file_put_contents($users_file, json_encode([]));
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    
    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        // Load existing users
        $users = json_decode(file_get_contents($users_file), true);
        
        // Check if user already exists
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                $error = 'User with this email already exists';
                break;
            }
        }
        
        if (!$error) {
            // Add new user
            $new_user = [
                'id' => uniqid(),
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s'),
                'role' => 'user'
            ];
            
            $users[] = $new_user;
            file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
            
            $message = 'Account created successfully! You can now login.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Merena Brand - Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Open+Sans&display=swap" rel="stylesheet" />
 <style>
  body {
  font-family: 'Open Sans', sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
}

#top_section {
  padding: 10px 20px;
  background: linear-gradient(90deg, #ffe6ec, #f8b8d0);
  position: sticky;
  top: 0;
  z-index: 1000;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

#logo {
  font-family: 'Great Vibes', cursive;
  font-size: 2rem;
  color: #d63384;
  font-weight: bold;
}

#open-menu, #search, #cart {
  font-size: 28px;
  cursor: pointer;
  transition: 0.3s;
}

#open-menu:hover, #search:hover, #cart:hover {
  color: #d63384;
}

#menu {
  position: fixed;
  top: 0;
  left: -270px;
  width: 250px;
  height: 100%;
  background: #fff;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
  transition: left 0.3s ease;
  z-index: 9999;
  overflow-y: auto;
}

#menu.active {
  left: 0;
}

#menu ul {
  list-style: none;
  padding: 20px;
}

#menu ul li {
  margin-bottom: 15px;
}

#menu ul li a {
  text-decoration: none;
  color: #333;
  font-size: 18px;
  font-weight: 500;
}

#menu ul li a:hover {
  color: #d63384;
}

#menu i {
  margin-right: 10px;
  color: #d63384;
}

#close-menu {
  font-size: 30px;
  text-align: right;
  padding: 15px;
  cursor: pointer;
  color: #d63384;
}

#overlay_background {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: none;
  z-index: 9998;
}

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 80vh;
  padding: 20px;
}

.Signup-form {
  background-color: white;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  width: 100%;
  max-width: 500px;
}

.Signup-form h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #d6336c;
}

.Signup-form input {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 16px;
  box-sizing: border-box;
}

.Signup-form button {
  width: 100%;
  background-color: #d6336c;
  color: white;
  border: none;
  padding: 12px;
  font-size: 18px;
  border-radius: 8px;
  cursor: pointer;
}

.Signup-form button:hover {
  background-color: #c2185b;
}

.alert {
  padding: 15px;
  margin-bottom: 20px;
  border-radius: 4px;
}

.alert-success {
  color: #155724;
  background-color: #d4edda;
  border: 1px solid #c3e6cb;
}

.alert-danger {
  color: #721c24;
  background-color: #f8d7da;
  border: 1px solid #f5c6cb;
}

#cart-modal {
      position: fixed;
      top: 0;
      right: -400px;
      width: 350px;
      height: 100%;
      background-color: #fff;
      border-left: 2px solid #ddd;
      padding: 20px;
      transition: right 0.3s ease;
      box-shadow: -2px 0px 10px rgba(0, 0, 0, 0.15);
      z-index: 10000;
      display: flex;
      flex-direction: column;
    }
    #cart-modal.show {
      right: 0;
    }
    #cart-items li {
      padding: 10px;
      border-bottom: 1px solid #ddd;
    }
    .btn {
      background-color: #d63384;
      color: white;
      border: none;
      padding: 10px 20px;
      margin-top: 10px;
      transition: 0.3s;
    }
    .btn:hover {
      background-color: #a52061;
    }
 </style>
 
</head>
<body>

<!-- Navigation -->
<section id="top_section">
  <span id="open-menu" onclick="show_menu()"><i class='bx bx-menu'></i></span>
  <span id="logo">Merena Brand</span>
  <span id="cart"><i class="bx bx-cart"></i> <span id="cart-count">0</span></span>
</section>

<!-- Sidebar -->
<nav id="menu">
  <div id="close-menu" onclick="hide_menu()"><i class='bx bx-x-circle'></i></div>
  <ul>
    <li><a href="login.php"><i class='bx bx-user'></i> Login</a></li>
    <li><a href="index.php"><i class='bx bx-home'></i> Home</a></li>
    <li><a href="shop.php"><i class='bx bx-store'></i> Shop</a></li>
    <li><a href="about.php"><i class='bx bx-info-circle'></i> About Us</a></li>
  </ul>
</nav>
<div id="overlay_background" onclick="hide_menu()"></div>
<div id="cart-modal">
  <h5>Your Cart</h5>
  <ul id="cart-items"></ul>
  <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" onclick="clearCart()">Clear</button>
    <button class="btn" onclick="toggleCart()">Close</button>
    <a class="btn" href="buy.php">order</a>
  </div>
</div>

<!-- Sign Up Form -->
<div class="container">
  <form class="Signup-form" method="POST" action="">
    <h2>Sign Up</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="confirm-password">Confirm Password:</label>
    <input type="password" id="confirm-password" name="confirm-password" required>

    <button type="submit">Create Account</button>
    <p style="text-align: center; margin-top: 15px;">Already have an account? <a href="login.php">Login here</a></p>
  </form>
</div>

<!-- JS -->
<script>
  const menu = document.getElementById("menu");
  const overlay = document.getElementById("overlay_background");
  const cartBtn = document.getElementById("cart");
  const cartModal = document.getElementById("cart-modal");

  function show_menu() {
    menu.classList.add("active");
    overlay.style.display = "block";
  }

  function hide_menu() {
    menu.classList.remove("active");
    overlay.style.display = "none";
  }

  document.getElementById("open-menu").addEventListener("click", () => {
    if (menu.classList.contains("active")) {
      hide_menu();
    } else {
      show_menu();
    }
  });

  overlay.addEventListener("click", () => {
    hide_menu();
    cartModal.classList.remove('show');
  });
  document.getElementById("close-menu").addEventListener("click", hide_menu);

  // Cart functionality
  cartBtn.addEventListener("click", function() {
    cartModal.classList.toggle('show');
    overlay.style.display = cartModal.classList.contains('show') ? "block" : "none";
  });

  function toggleCart() {
    cartModal.classList.toggle('show');
    overlay.style.display = cartModal.classList.contains('show') ? "block" : "none";
  }

  let cart = [];

  function addToCart(name, price) {
    cart.push({ name, price });
    updateCart();
  }

  function updateCart() {
    const items = document.getElementById('cart-items');
    items.innerHTML = '';
    cart.forEach(item => {
      const li = document.createElement('li');
      li.textContent = `${item.name} - ${item.price}`;
      items.appendChild(li);
    });
    document.getElementById('cart-count').textContent = cart.length;
  }

  function clearCart() {
    cart = [];
    updateCart();
  }
</script>

</body>
</html>

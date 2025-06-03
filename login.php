<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simple authentication (you can enhance this with database)
    if ($email === 'admin@merena.com' && $password === 'admin123') {
        $_SESSION['user'] = $email;
        $_SESSION['is_admin'] = true;
        $_SESSION['admin_name'] = 'Admin';
        header('Location: dashboard.php');
        exit;
    } elseif (!empty($email) && !empty($password)) {
        $_SESSION['user'] = $email;
        header('Location: index.php');
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | Merena Brand</title>

  <!-- CSS & Fonts -->
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

    /* Sidebar Menu */
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

    /* Login Form */
    .login-container {
      max-width: 400px;
      margin: 100px auto;
      padding: 30px;
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #d6336c;
    }

    .login-container form {
      display: flex;
      flex-direction: column;
    }

    .login-container label {
      margin-bottom: 5px;
      font-weight: bold;
    }

    .login-container input {
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ebb7d1;
      border-radius: 6px;
    }

    .login-container button {
      padding: 12px;
      background-color:#ff508d;
      color: rgb(248, 243, 246);
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }

    .login-container button:hover {
      background-color: #f961be;
    }

    .signup-link {
      text-align: center;
      margin-top: 15px;
      color: #ff508d;
    }

    .error {
      color: red;
      text-align: center;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<!-- Navigation -->
<section id="top_section">
  <span id="open-menu"><i class='bx bx-menu'></i></span>
  <span id="logo">Merena Brand</span>
  <span id="cart"><i class="bx bx-cart"></i> <span id="cart-count">0</span></span>
</section>

<!-- Sidebar Menu -->
<nav id="menu">
  <div id="close-menu"><i class='bx bx-x-circle'></i></div>
  <ul>
    <li><a href="login.php"><i class='bx bx-user'></i> Login</a></li>
    <li><a href="index.php"><i class='bx bx-home'></i> Home</a></li>
    <li><a href="shop.php"><i class='bx bx-store'></i> Shop</a></li>
    <li><a href="about.php"><i class='bx bx-info-circle'></i> About Us</a></li>
  </ul>
</nav>
<div id="overlay_background"></div>

<!-- Login Form -->
<main class="login-container">
  <div class="login-card">
    <h2>Login to Merena</h2>
    <?php if (isset($error)): ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <div class="signup-link">
      Don't have an account? <a href="register.php">Sign Up</a>
    </div>
    <div class="signup-link">
      <small>Admin: admin@merena.com / admin123</small>
    </div>
  </div>
</main>

<script>
  const menu = document.getElementById("menu");
  const overlay = document.getElementById("overlay_background");

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

  overlay.addEventListener("click", hide_menu);
 overlay.addEventListener("click", hide_menu);
document.getElementById("close-menu").addEventListener("click", hide_menu);

</script>

</body>
</html>
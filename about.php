<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us | Merena Brand</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
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

    #open-menu, #cart ,#like {
      font-size: 28px;
      cursor: pointer;
      transition: 0.3s;
    }
    #open-menu:hover, #cart:hover, #like:hover {
      color: #d63384;
    }

    /* Menu from left */
    #menu {
      position: fixed;
      top: 0;
      right: -270px;
      width: 250px;
      height: 100%;
      background: #fff;
      box-shadow: -2px 0 10px rgba(0,0,0,0.15);
      transition: right 0.3s ease;
      z-index: 9999;
      overflow-y: auto;
    }

    #menu.active {
    left:  0;
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

    .about-container {
      max-width: 1000px;
      margin: 60px auto;
      padding: 40px;
      background-color: white;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    h1 {
      font-family: 'Great Vibes', cursive;
      font-size: 56px;
      color: #d63384;
      text-align: center;
      margin-bottom: 20px;
    }

    h2 {
      font-size: 28px;
      color: #a52061;
      margin-top: 40px;
    }

    p {
      font-size: 18px;
      line-height: 1.8;
    }

    footer {
      text-align: center;
      margin-top: 60px;
      padding: 20px;
      color: #888;
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

<div class="about-container">
  <h1>About Merena Brand</h1>

  <p>
    Merena Brand is more than just a clothing store — it's a lifestyle. Founded with passion and elegance,
    Merena is dedicated to empowering women through fashion that blends style, confidence, and affordability.
  </p>

  <h2>💡 Our Vision</h2>
  <p>
    To inspire every woman to feel beautiful and powerful in her own skin. We believe that fashion is not just
    about clothes, but about expressing identity and inner strength.
  </p>

  <h2>🎯 Our Mission</h2>
  <p>
    We create unique, high-quality, and elegant pieces that suit all tastes — while staying affordable and
    accessible to women everywhere. We are proudly based in Algeria and deliver across the country.
  </p>

  <h2>🌟 Why Choose Us?</h2>
  <ul>
    <li>✨ Guaranteed elegance and comfort</li>
    <li>💰 Affordable prices without compromise</li>
    <li>🚚 Fast delivery nationwide</li>
    <li>🛍️ Carefully curated styles for every occasion</li>
  </ul>
</div>

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
  document.getElementById("close-menu").addEventListener("click", hide_menu);
</script>

</body>
</html>

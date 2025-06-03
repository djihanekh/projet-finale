<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Shop | Merena Brand</title>

  <!-- CSS Libraries -->
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
    
    .product-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      background-color: #fff;
      margin: 15px;
      text-align: center;
      padding-bottom: 15px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .product-card img {
      width: 100%;
      height: 250px;
      object-fit: cover;
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
    /* Price style */
    .price {
      font-size: 1.3rem;
      color: #72B735;
      font-weight: bold;
      margin: 10px 0;
      letter-spacing: 1px;
    }
    /* Stars style */
    .rating {
      direction: rtl;
      unicode-bidi: bidi-override;
      display: inline-block;
      margin-bottom: 8px;
    }
    .rating input[type="radio"] {
      display: none;
    }
    .rating label {
      color: #ccc;
      font-size: 1.3rem;
      cursor: pointer;
      transition: color 0.2s;
      padding: 0 2px;
    }
    .rating input[type="radio"]:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
      color: #ffd700;
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

<div id="cart-modal">
  <h5>Your Cart</h5>
  <ul id="cart-items"></ul>
  <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" onclick="clearCart()">Clear</button>
    <button class="btn" onclick="toggleCart()">Close</button>
    <a class="btn" href="checkout.php">Order</a>
  </div>
</div>

<div class="container py-5">
  <div class="row">
    <?php
    // Sample products data
    $products = [
      ['id' => 1, 'name' => 'Elegant Dress', 'price' => '4600DA', 'image' => 'assets/photo_2025-06-04_00-09-23.jpg'],
      ['id' => 2, 'name' => 'Lovely Dress', 'price' => '3600DA', 'image' => 'assets/photo_2025-06-04_01-05-07.jpg'],
      ['id' => 3, 'name' => 'Elegant Dress', 'price' => '3600DA', 'image' => 'assets/photo_2025-06-04_00-56-57.jpg'],
      ['id' => 4, 'name' => 'Costume Merena', 'price' => '4900DA', 'image' => 'assets/photo_2025-06-04_00-55-25.jpg'],
      ['id' => 5, 'name' => 'Summer Collection', 'price' => '3800DA', 'image' => 'assets/photo_2025-06-04_01-05-21.jpg'],
      ['id' => 6, 'name' => 'Elegant Set', 'price' => '4200DA', 'image' => 'assets/']
    ];
    
    foreach($products as $product): 
    ?>
    <div class="col-md-4">
      <div class="product-card">
        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        <h5><?php echo $product['name']; ?></h5>
        <div class="rating">
          <input type="radio" id="star5-<?php echo $product['id']; ?>" name="rating<?php echo $product['id']; ?>"><label for="star5-<?php echo $product['id']; ?>">★</label>
          <input type="radio" id="star4-<?php echo $product['id']; ?>" name="rating<?php echo $product['id']; ?>"><label for="star4-<?php echo $product['id']; ?>">★</label>
          <input type="radio" id="star3-<?php echo $product['id']; ?>" name="rating<?php echo $product['id']; ?>"><label for="star3-<?php echo $product['id']; ?>">★</label>
          <input type="radio" id="star2-<?php echo $product['id']; ?>" name="rating<?php echo $product['id']; ?>"><label for="star2-<?php echo $product['id']; ?>">★</label>
          <input type="radio" id="star1-<?php echo $product['id']; ?>" name="rating<?php echo $product['id']; ?>"><label for="star1-<?php echo $product['id']; ?>">★</label>
        </div>
        <p class="price"><?php echo $product['price']; ?></p>
        <button class="btn" onclick="addToCartAndShow('<?php echo $product['name']; ?>', '<?php echo $product['price']; ?>')">Add to Cart</button>
        <a class="btn btn-buy" href="details.php?id=<?php echo $product['id']; ?>">Details</a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

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

  // Cart open/close
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

  // Add to Cart and open cart modal
  function addToCartAndShow(name, price) {
    addToCart(name, price);
    cartModal.classList.add('show');
    overlay.style.display = "block";
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

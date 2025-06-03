<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Merena Brand</title>

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

#hero_section {
  background: url(image/photo_2025-06-04_00-09-23.jpg) center/cover no-repeat fixed;
  height: 90vh;
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
}

.hero-content {
  padding: 60px;
  border-radius: 20px;
  text-align: center;
}

.btn-primary {
  background-color: #d63384;
  border: none;
  padding: 10px 20px;
  transition: 0.3s;
}

.btn-primary:hover {
  background-color: #a52061;
  transform: scale(1.1);
}

.product-card {
  border: 1px solid #ddd;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  background-color: #fff;
  margin: 15px;
  text-align: center;
  transition: all 0.3s ease-in-out;
}

.product-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

.product-card img {
  width: 100%;
  height: 250px;
  object-fit: cover;
}

.product-card h5 {
  font-size: 1.2rem;
  margin-top: 15px;
}

.product-card .price {
  font-size: 1.5rem;
  color: #72B735;
  font-weight: bold;
}

.container {
  padding: 50px 20px;
}

#about {
  background-image: url('attached_assets/butterfly_image.jpg');
  background-size: cover;
  background-position: center;
  padding: 60px 20px;
  color: white;
  text-align: center;
  border-radius: 20px;
}

#about h2 {
  font-family: 'Great Vibes', cursive;
  color: #d63384;
  font-size: 40px;
}

#about p {
  font-size: 18px;
  color: #121111;
}

.social-media a {
  margin: 0 15px;
  font-size: 30px;
  color: #d63384;
  transition: transform 0.3s ease;
}

.social-media a:hover {
  transform: scale(1.2);
}

.why-us {
  background-color: #fff;
  padding: 40px;
  text-align: center;
}

footer {
  background-color: #fff5f9;
  padding: 30px 20px;
  text-align: center;
}

footer a {
  color: #d63384;
  margin: 0 10px;
  font-size: 20px;
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

<!-- Cart Modal -->
<div id="cart-modal">
  <h5>Your Cart</h5>
  <ul id="cart-items"></ul>
  <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" onclick="clearCart()">Clear</button>
    <button class="btn" onclick="toggleCart()">Close</button>
    <a class="btn" href="checkout.php">Order</a>
  </div>
</div>

<!-- Hero Section -->
<section id="hero_section">
  <div class="hero-content">
    <h1 style="font-family: 'Great Vibes', cursive; font-size: 60px;">Unleash Your Style</h1>
    <p class="mb-4">Discover the perfect blend of elegance and confidence with Merena Brand.</p>
    <a href="shop.php" class="btn btn-primary">Shop now</a>
  </div>
</section>

<!-- About Us Section -->
<section id="about">
  <h2>About Us</h2>
  <p>Merena Brand is your go-to destination for fashion that combines elegance, comfort, and affordability.</p>
</section>

<!-- Products Section -->
<section id="products" class="py-5">
  <div class="container">
    <div class="row text-center">
      <?php
      // Sample products data
      $products = [
        ['id' => 1, 'name' => 'Elegant Dress', 'price' => '3600DA', 'image' => 'assets/photo_2025-06-04_00-09-23.jpg', 'description' => 'Elegant dress perfect for any occasion.'],
        ['id' => 2, 'name' => 'Costume Merena', 'price' => '4900DA', 'image' => 'assets/photo_2025-06-04_00-55-25.jpg', 'description' => 'Blazer oversize et pantalon carré.'],
        ['id' => 3, 'name' => 'Ensemble Mira', 'price' => '4600DA', 'image' => 'assets/photo_2025-06-04_00-56-11.jpg', 'description' => 'Elegant and modern outfit for all seasons.'],
        ['id' => 4, 'name' => 'Robe Lovely', 'price' => '3800DA', 'image' => 'assets/photo_2025-06-04_00-56-57.jpg', 'description' => 'A lovely dress for your daily elegance.']
      ];
      
      foreach($products as $product): 
      ?>
      <div class="col-md-3">
        <div class="product-card">
          <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
          <h5><?php echo $product['name']; ?></h5>
          <p class="price"><?php echo $product['price']; ?></p>
          <p class="product-description"><?php echo $product['description']; ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a href="shop.php" class="btn btn-primary">View All</a>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="why-us">
  <h2>Why Choose Merena Brand?</h2>
  <ul style="list-style: none; padding: 0; font-size: 18px;">
    <li> ✨ Guaranteed elegance and comfort</li>
    <li>💰 Affordable prices without compromise</li>
    <li>🚚 Fast delivery nationwide</li>
    <li>🛍️ Carefully curated styles for every occasion</li>
  </ul>
</section>

<!-- Footer -->
<footer>
  <p>Follow us:</p>
  <div class="social-media">
    <a href="https://www.instagram.com/merena_brand?igsh=YW9sZnA0bWZrcWNv"><i class="fab fa-instagram"></i></a>
    <a href="https://www.tiktok.com/@merena_brand?_t=ZM-8wnxwPZTsOr&_r=1"><i class="fab fa-tiktok"></i></a>
    <a href="https://www.facebook.com/share/15r4cEP5pt/"><i class="fab fa-facebook"></i></a>
  </div>
</footer>

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

function placeOrder() {
  if (cart.length === 0) {
    alert("Your cart is empty!");
    return;
  }
  alert("Thank you! Your order has been placed.");
  clearCart();
  toggleCart();
}

function clearCart() {
  cart = [];
  updateCart();
}
</script>

</body>
</html>

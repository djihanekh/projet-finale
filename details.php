<?php
session_start();

$product_id = $_GET['id'] ?? 1;

// Sample product data
$products = [
    1 => ['name' => 'Elegant Dress', 'price' => '4600DA', 'image' => 'attached_assets/5836860766173646696_121.jpg', 'description' => 'This elegant dress is perfect for special occasions. Made from high-quality fabric, it features a modern design and a comfortable fit.'],
    2 => ['name' => 'Lovely Dress', 'price' => '3600DA', 'image' => 'attached_assets/projet.jpg', 'description' => 'A lovely dress for your daily elegance. Perfect for casual and formal occasions.'],
    3 => ['name' => 'Elegant Dress', 'price' => '3600DA', 'image' => 'attached_assets/5811946850595493243_121.jpg', 'description' => 'Beautiful elegant dress with sophisticated design.'],
    4 => ['name' => 'Costume Merena', 'price' => '4900DA', 'image' => 'attached_assets/5983171833588991060_121.jpg', 'description' => 'Blazer oversize et pantalon carré. Perfect professional outfit.'],
    5 => ['name' => 'Summer Collection', 'price' => '3800DA', 'image' => 'attached_assets/5895388843861985312_121.jpg', 'description' => 'Beautiful summer collection piece.'],
    6 => ['name' => 'Elegant Set', 'price' => '4200DA', 'image' => 'attached_assets/5895388843861985313_121.jpg', 'description' => 'Elegant set for special occasions.']
];

$product = $products[$product_id] ?? $products[1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Details | Merena Brand</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Open+Sans&display=swap" rel="stylesheet" />
  <style>
    body {
      background: #f4f4f4;
      font-family: 'Open Sans', sans-serif;
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
    .details-container {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.08);
      margin: 40px auto;
      max-width: 800px;
      padding: 32px;
      display: flex;
      gap: 32px;
      align-items: flex-start;
    }
    .details-img {
      width: 320px;
      height: 400px;
      object-fit: cover;
      border-radius: 10px;
      border: 1px solid #eee;
    }
    .details-info h2 {
      color: #d63384;
      font-family: 'Great Vibes', cursive;
      font-size: 2.2rem;
      margin-bottom: 10px;
    }
    .details-info .price {
      color:  #72B735;
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 12px;
    }
    .details-info p {
      margin-bottom: 18px;
      color: #444;
    }
    .btn {
      background-color: #d63384;
      color: white;
      border: none;
      padding: 10px 24px;
      border-radius: 6px;
      font-size: 1rem;
      transition: 0.3s;
    }
    .btn:hover {
      background-color: #a52061;
    }
    .back-link {
      display: inline-block;
      margin: 20px 0 0 40px;
      color: #d63384;
      text-decoration: none;
      font-weight: bold;
    }
    .back-link:hover {
      text-decoration: underline;
      color: #a52061;
    }
    .select-group {
      margin-bottom: 16px;
    }
    .details-info .rating {
      direction: rtl;
      unicode-bidi: bidi-override;
      display: inline-block;
      margin-bottom: 12px;
    }
    .details-info .rating input[type="radio"] {
      display: none;
    }
    .details-info .rating label {
      color: #ccc;
      font-size: 1.5rem;
      cursor: pointer;
      transition: color 0.2s;
      padding: 0 2px;
    }
    .details-info .rating input[type="radio"]:checked ~ label,
    .details-info .rating label:hover,
    .details-info .rating label:hover ~ label {
      color: #ffd700;
    }
    .color-dot {
      display:inline-block;
      width:22px;
      height:22px;
      border-radius:50%;
      border:2px solid #eee;
      margin-right:6px;
      vertical-align:middle;
      cursor:pointer;
    }
    .color-dot.selected {
      border:2px solid #d63384;
      box-shadow: 0 0 0 2px #ffd6ea;
    }
    .comments-section {
      max-width: 800px;
      margin: 40px auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.08);
      padding: 30px;
    }
    .comments-section h4 {
      margin-bottom: 20px;
      color: #d63384;
    }
    .comment-box textarea {
      width: 100%;
      padding: 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
      resize: none;
    }
    .comment-box button {
      margin-top: 10px;
      background-color: #d63384;
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 6px;
    }
    .user-comment {
      margin-top: 20px;
      border-top: 1px solid #eee;
      padding-top: 10px;
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

  <a href="shop.php" class="back-link"><i class='bx bx-arrow-back'></i> Back to Shop</a>
  <div class="details-container">
    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="details-img">
    <div class="details-info">
      <h2><?php echo $product['name']; ?></h2>
      <div class="rating">
        <input type="radio" id="star5" name="rating"><label for="star5">★</label>
        <input type="radio" id="star4" name="rating"><label for="star4">★</label>
        <input type="radio" id="star3" name="rating"><label for="star3">★</label>
        <input type="radio" id="star2" name="rating"><label for="star2">★</label>
        <input type="radio" id="star1" name="rating"><label for="star1">★</label>
      </div>
      <div class="price"><?php echo $product['price']; ?></div>
      <div class="select-group">
        <strong>Size:</strong>
        <select class="form-select" style="width: auto; display: inline-block;">
          <option>S</option>
          <option>M</option>
          <option>L</option>
          <option>XL</option>
        </select>
      </div>
      <div class="select-group">
        <strong>Color:</strong>
        <span class="color-dot selected" style="background:rgb(176, 2, 2);" title="Pink" data-img="assets/"></span>
        <span class="color-dot" style="background:rgb(3, 3, 63);" title="Black" data-img="assets/"></span>
        <span class="color-dot" style="background:gray; border:2px solid #ccc;" title="White" data-img="assets/"></span>
      </div>
      <p><?php echo $product['description']; ?></p>
      <button class="btn" onclick="addToCartAndShow('<?php echo $product['name']; ?>', '<?php echo $product['price']; ?>')">Add to Cart</button>
    </div>
  </div>

  <div class="comments-section">
    <h4>Customer Comments</h4>
    <div class="comment-box">
      <textarea id="commentText" rows="4" placeholder="Write your comment..."></textarea>
      <button onclick="submitComment()">comment</button>
    </div>
    <div id="commentList"></div>
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

    // Color selection effect + change image
    document.querySelectorAll('.color-dot').forEach(dot => {
      dot.addEventListener('click', function() {
        document.querySelectorAll('.color-dot').forEach(d => d.classList.remove('selected'));
        this.classList.add('selected');
        // Change image
        const imgSrc = this.getAttribute('data-img');
        document.querySelector('.details-img').src = imgSrc;
      });
    });

    // Comments
    function submitComment() {
      const text = document.getElementById('commentText').value;
      if (text.trim() !== '') {
        const commentList = document.getElementById('commentList');
        const div = document.createElement('div');
        div.className = 'user-comment';
        div.textContent = text;
        commentList.appendChild(div);
        document.getElementById('commentText').value = '';
      }
    }
  </script>
</body>
</html>
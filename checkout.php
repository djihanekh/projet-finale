<?php
session_start();

if ($_POST) {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $email = $_POST['email'] ?? '';
    
    // Here you would normally save the order to database
    $success = "Order placed successfully! We'll contact you soon.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Checkout | Merena Brand</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet" />
  <style>
    body {
      background: #f4f4f4;
      font-family: 'Open Sans', sans-serif;
    }

    .checkout-container {
      max-width: 1100px;
      margin: 50px auto;
      background: white;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    h2 {
      margin-bottom: 20px;
      font-weight: bold;
      color: #d63384;
    }

    label {
      font-weight: 500;
      margin-bottom: 5px;
    }

    input, select {
      border-radius: 8px !important;
    }

    .form-section {
      border-right: 2px dashed #eee;
      padding-right: 30px;
    }

    .order-summary {
      padding-left: 30px;
    }

    .order-summary p {
      margin-bottom: 8px;
      font-size: 16px;
    }

    .total-price {
      font-size: 24px;
      font-weight: bold;
      color: #333;
    }

    .btn-confirm {
      background-color: #d63384;
      color: white;
      border-radius: 12px;
      padding: 12px;
      font-weight: bold;
      font-size: 16px;
      border: none;
    }

    .btn-confirm:hover {
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
    
    .success {
      color: green;
      text-align: center;
      margin-bottom: 20px;
      padding: 15px;
      background: #d4edda;
      border-radius: 8px;
    }
  </style>
</head>
<body>
    <a href="shop.php" class="back-link"><i class='bx bx-arrow-back'></i> Back to Shop</a>

<div class="container checkout-container">
  <?php if (isset($success)): ?>
    <div class="success"><?php echo $success; ?></div>
  <?php endif; ?>
  
  <div class="row">
    <!-- Form -->
    <div class="col-md-7 form-section">
      <h2>📦 Shipping Details</h2>
      <form method="POST">
        <div class="mb-3">
          <label>First Name</label>
          <input type="text" class="form-control" name="first_name" required>
        </div>
        <div class="mb-3">
          <label>Last Name</label>
          <input type="text" class="form-control" name="last_name" required>
        </div>
        <div class="mb-3">
          <label>Phone</label>
          <input type="text" class="form-control" name="phone" required>
        </div>
        <div class="mb-3">
          <label>State / Wilaya</label>
          <select class="form-select" name="state" required>
            <option value="">Select your state</option>
            <option>01 Adrar</option>
            <option>02 Chlef</option>
            <option>03 Laghouat</option>
            <option>04 Oum El Bouaghi</option>
            <option>05 Batna</option>
            <option>06 Béjaïa</option>
            <option>07 Biskra</option>
            <option>08 Béchar</option>
            <option>09 Blida</option>
            <option>10 Bouira</option>
            <option>11 Tamanrasset</option>
            <option>12 Tébessa</option>
            <option>13 Tlemcen</option>
            <option>14 Tiaret</option>
            <option>15 Tizi Ouzou</option>
            <option>16 Algiers</option>
            <option>17 Djelfa</option>
            <option>18 Jijel</option>
            <option>19 Sétif</option>
            <option>20 Saïda</option>
            <option>21 Skikda</option>
            <option>22 Sidi Bel Abbès</option>
            <option>23 Annaba</option>
            <option>24 Guelma</option>
            <option>25 Constantine</option>
            <option>26 Médéa</option>
            <option>27 Mostaganem</option>
            <option>28 M'Sila</option>
            <option>29 Mascara</option>
            <option>30 Ouargla</option>
            <option>31 Oran</option>
            <option>32 El Bayadh</option>
            <option>33 Illizi</option>
            <option>34 Bordj Bou Arréridj</option>
            <option>35 Boumerdès</option>
            <option>36 El Tarf</option>
            <option>37 Tindouf</option>
            <option>38 Tissemsilt</option>
            <option>39 El Oued</option>
            <option>40 Khenchela</option>
            <option>41 Souk Ahras</option>
            <option>42 Tipaza</option>
            <option>43 Mila</option>
            <option>44 Aïn Defla</option>
            <option>45 Naâma</option>
            <option>46 Aïn Témouchent</option>
            <option>47 Ghardaïa</option>
            <option>48 Relizane</option>
          </select>
        </div>
        <div class="mb-3">
          <label>City</label>
          <input type="text" class="form-control" name="city" required>
        </div>
        <div class="mb-3">
          <label>Full Address</label>
          <input type="text" class="form-control" name="address" required>
        </div>
        <div class="mb-3">
          <label>Email (optional)</label>
          <input type="email" class="form-control" name="email">
        </div>
        <button type="submit" class="btn btn-confirm">Confirm Order & Pay on Delivery</button>
      </form>
    </div>

    <!-- Order Summary -->
    <div class="col-md-5 order-summary">
      <h2>🛍 Your Order</h2>
      <p><strong>Product:</strong> Elegant Dress × 1</p>
      <p><strong>Price:</strong> 4600 DA</p>

      <div class="mb-3">
        <label><strong>Delivery Method:</strong></label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="delivery" checked>
          <label class="form-check-label">Home delivery — 300 DA</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="delivery">
          <label class="form-check-label">Pick-up from office — Free</label>
        </div>
      </div>

      <hr />
      <p class="total-price">Total: 4900 DA</p>
    </div>
  </div>
</div>

</body>
</html>

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body>
    <header class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <i class="fa-solid fa-shoe-prints fs-4 text-primary me-2"></i>
                <div>
                    <span style="font-weight: bold">Shoes</span><br />
                    <small>Shopping</small>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="./pages/cart.html">
                            <i class="fa-solid fa-cart-shopping"></i> $<span class="cart-total">0.00</span>
                            <span class="badge bg-danger rounded-circle products-number">0</span>
                        </a>
                    </li>

                    <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/backend/account.php">My Account</a></li>
                            <li><a class="dropdown-item" href="/pages/cart.html">Orders</a></li>
                            <li><a class="dropdown-item" href="/backend/logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-primary me-2" href="./pages/signin.html">Sign in</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="./pages/register.html">Register</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <h1 class="text-center mb-4">Our Products</h1>
        <div class="row g-4">
            <?php for ($i = 1; $i <= 8; $i++): ?>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <a href="./pages/product-details.html">
                        <?php
              $image_base = "images/product-" . ($i % 2 === 0 ? "red" : "blue");
              $extensions = ["jpeg", "avif", "jpg"];

              $image_path = "";
              foreach ($extensions as $ext) {
                if (file_exists("$image_base.$ext")) {
                  $image_path = "$image_base.$ext";
                  break;
                }
              }
              ?>
                        <img src="<?php echo $image_path; ?>" class="card-img-top" alt="Produc
                            class=" card-img-top" alt="Product" />
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">Product Title <?php echo $i; ?></h5>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur elit adipisicing.
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-danger">$<?php echo 100 + ($i * 10); ?></span>
                            <button class="btn btn-primary btn-sm add-to-cart" data-id="<?php echo $i; ?>">
                                <i class="fa-solid fa-cart-plus"></i> Add To Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </main>

    <footer class="text-center bg-light py-3 border-top">
        Developed by <span class="text-primary">Molham</span> © 2024
    </footer>

    <!-- JavaScript -->
    <script src="./js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
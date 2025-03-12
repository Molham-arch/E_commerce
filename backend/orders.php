<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/signin.html');
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT id, product_name, product_image, quantity, status FROM orders WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">My Orders</h2>
        <?php if (empty($orders)): ?>
        <p class="text-center">You have no orders yet.</p>
        <?php else: ?>
        <div class="row g-3">
            <?php foreach ($orders as $order): ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="../images/<?= htmlspecialchars($order['product_image']); ?>" class="card-img-top"
                        alt="Product">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($order['product_name']); ?></h5>
                        <p>Quantity: <?= htmlspecialchars($order['quantity']); ?></p>
                        <span class="badge bg-info"><?= htmlspecialchars($order['status']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</body>

</html>
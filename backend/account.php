<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/signin.html');
    exit;
}


$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();


$update_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];

    if (!empty($new_username) && !empty($new_email)) {
        $update_stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
        $update_stmt->bind_param("ssi", $new_username, $new_email, $user_id);
        if ($update_stmt->execute()) {
            $_SESSION['username'] = $new_username; 
            $update_message = '<div class="alert alert-success">Profile updated successfully.</div>';
        } else {
            $update_message = '<div class="alert alert-danger">Error updating profile.</div>';
        }
        $update_stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">My Account</h2>
        <?= $update_message; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username); ?>"
                    required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Profile</button>
        </form>
        <a href="logout.php" class="btn btn-danger w-100 mt-3">Logout</a>
    </div>
</body>

</html>
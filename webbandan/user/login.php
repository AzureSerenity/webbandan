<?php
    session_start();
    require_once "../database.php";

    $database = new Database();
    $conn = $database->dbConnection();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <!-- <link rel="stylesheet" href="../styles/login.css"> -->
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>WEB BÁN ĐÀN</h1>
        </div>
        <h2>Đăng nhập</h2>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST["email"];
                $matKhau = $_POST["matKhau"];
            
                $query = "SELECT * FROM nguoidung WHERE email = :email";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
                if ($user && password_verify($matKhau, $user["matKhau"])) {
                    $_SESSION["user"] = $user["hoTen"];
                    $_SESSION["email"] = $user["email"];
            
                    if ($user["email"] === "admin@gmail.com") {
                        $_SESSION["admin"] = true; 
                        header("Location: ../admin/list.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit();
                } else {
                    echo '<div class="error-message">Sai email hoặc mật khẩu!</div>';
                }
            }
        ?>
        <form method="POST">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="matKhau" placeholder="Mật khẩu" required>
            </div>
            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ghi nhớ mật khẩu</label>
            </div>
            <button type="submit">ĐĂNG NHẬP</button>
        </form>
        <div class="links">
            <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
        </div>
    </div>
</body>
</html>
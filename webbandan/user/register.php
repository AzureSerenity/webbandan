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
    <title>Đăng ký</title>
    <!-- <link rel="stylesheet" href="../styles/register.css"> -->
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>WEB BÁN ĐÀN</h1>
        </div>
        <h2>Đăng ký</h2>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $hoTen = $_POST["hoTen"];
                $email = $_POST["email"];
                $dienThoai = $_POST["soDienThoai"];
                $matKhau = password_hash($_POST["matKhau"], PASSWORD_DEFAULT);

                $query = "INSERT INTO nguoidung (hoTen, email, soDienThoai, matKhau) VALUES (:hoTen, :email, :soDienThoai, :matKhau)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":hoTen", $hoTen);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":soDienThoai", $dienThoai);
                $stmt->bindParam(":matKhau", $matKhau);
                
                if ($stmt->execute()) {
                    echo '<div class="success-message">Đăng ký thành công! <a href="login.php">Đăng nhập</a></div>';
                } else {
                    echo '<div class="error-message">Đăng ký thất bại!</div>';
                }
            }
        ?>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="hoTen" placeholder="Họ và tên" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="text" name="soDienThoai" placeholder="Số điện thoại">
            </div>
            <div class="form-group">
                <input type="password" name="matKhau" placeholder="Mật khẩu" required>
            </div>
            <button type="submit">ĐĂNG KÝ</button>
        </form>
        <div class="links">
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
        </div>
    </div>
</body>
</html>
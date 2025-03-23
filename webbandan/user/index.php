<?php
    session_start();
    require_once "../database.php";

    $database = new Database();
    $conn = $database->dbConnection();

    $query = "SELECT * FROM instrument";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $danList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
</head>
<body>
    <div class="header">
        <div class="nav-links">
            <?php
                if (isset($_SESSION["user"])) {
                    echo '<span>Xin chào, ' . $_SESSION["user"] . '</span>';
                    echo '<a href="logout.php"> Đăng xuất</a>';
                } else {
                    echo '<a href="login.php">Đăng nhập</a>';
                    echo '<a href="register.php">Đăng ký</a>';
                }
            ?>
        </div>
    </div>

    <h2>Danh sách đàn</h2>
    <table border="1">
        <tr>
            <th>Tên đàn</th>
            <th>Loại đàn</th>
            <th>Xuất xứ</th>
            <th>Giá thành</th>
            <th>Hãng</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
        </tr>
        <?php foreach ($danList as $dan): ?>
        <tr>
            <td><?php echo htmlspecialchars($dan["ten"]); ?></td>
            <td><?php echo htmlspecialchars($dan["loaiDan"]); ?></td>
            <td><?php echo htmlspecialchars($dan["xuatXu"]); ?></td>
            <td><?php echo number_format($dan["giaThanh"], 0, ',', '.') . " VND"; ?></td>
            <td><?php echo htmlspecialchars($dan["hang"]); ?></td>
            <td>
                <?php if (!empty($dan["hinhAnh"])): ?>
                    <img src="<?php echo htmlspecialchars($dan["hinhAnh"]); ?>" width="100">
                <?php else: ?>
                    Không có ảnh
                <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($dan["moTa"]); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
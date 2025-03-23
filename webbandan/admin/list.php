<?php
    session_start();
    require_once "../database.php";

    if (!isset($_SESSION["admin"])) {
        header("Location: login.php");
        exit();
    }

    $database = new Database();
    $conn = $database->dbConnection();

    $query = "SELECT instrument.*, loaidan.tenLoai FROM instrument JOIN loaidan ON instrument.loaiDan_id = loaidan.ma";    
    $stmt = $conn->query($query);
    $danList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Quản lý Danh sách đàn</title>
    <!-- <link rel="stylesheet" href="../styles/list.css"> -->
</head>
<body>
    <div class="admin-container">
        <h2 class="page-title">Danh sách đàn</h2>
        <div class="logout-link">
            <a href="../user/logout.php">Đăng xuất</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <th>Mã</th>
                <th>Tên</th>
                <th>Loại đàn</th>
                <th>Xuất xứ</th>
                <th>Giá thành</th>
                <th>Hãng</th>
                <th>Hình ảnh</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </thead>
            <tbody>
                <?php foreach ($danList as $dan) : ?>
                    <tr>
                        <td><?= $dan["ma"] ?></td>
                        <td><?= $dan["ten"] ?></td>
                        <td><?= $dan["tenLoai"] ?></td>
                        <td><?= $dan["xuatXu"] ?></td>
                        <td><?= number_format($dan["giaThanh"], 0, ',', '.') ?> đ</td>
                        <td><?= $dan["hang"] ?></td>
                        <td><img src="<?= $dan["hinhAnh"] ?>" alt="Hình đàn"></td>
                        <td class="truncate"><?= $dan["moTa"] ?></td>
                        <td class="action-links">
                            <a href="edit.php?ma=<?= $dan['ma'] ?>">Sửa</a> | 
                            <a href="delete.php?ma=<?= $dan['ma'] ?>" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="add-new">
            <a href="add.php" class="btn btn-primary">Thêm đàn</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
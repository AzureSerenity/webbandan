<?php
    session_start();
    require_once "../database.php";

    $database = new Database();
    $conn = $database->dbConnection();

    // them loaiDan
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
        $tenLoai = $_POST["tenLoai"];
        if (!empty($tenLoai)) {
            $query = "INSERT INTO loaidan (tenLoai) VALUES (:tenLoai)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":tenLoai", $tenLoai);
            $stmt->execute();
            header("Location: add_loaiDan.php");
            exit;
        }
    }

    // sua loaiDan
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
        $id = $_POST["id"];
        $tenLoai = $_POST["tenLoai"];
        if (!empty($tenLoai)) {
            $query = "UPDATE loaidan SET tenLoai = :tenLoai WHERE ma = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":tenLoai", $tenLoai);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            header("Location: add_loaiDan.php");
            exit;
        }
    }

    // xoa loaiDan
    if (isset($_GET["delete"])) {
        $id = $_GET["delete"];
        $query = "DELETE FROM loaidan WHERE ma = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        header("Location: add_loaiDan.php");
        exit;
    }

    // list loaiDan
    $query = "SELECT * FROM loaidan";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $loaiDanList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Loại Đàn</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Quản lý Loại Đàn</h2>

    <form method="POST" class="mb-3">
        <div class="input-group">
            <input type="text" name="tenLoai" class="form-control" placeholder="Nhập tên loại đàn" required>
            <button type="submit" name="add" class="btn btn-primary">Thêm</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Loại Đàn</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($loaiDanList as $loaiDan): ?>
                <tr>
                    <td><?= $loaiDan["ma"] ?></td>
                    <td><?= $loaiDan["tenLoai"] ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $loaiDan['ma'] ?>">Sửa</button>
                        
                        <a href="?delete=<?= $loaiDan["ma"] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                    </td>
                </tr>

                <div class="modal fade" id="editModal<?= $loaiDan['ma'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Chỉnh sửa loại đàn</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?= $loaiDan['ma'] ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Tên Loại Đàn</label>
                                        <input type="text" name="tenLoai" class="form-control" value="<?= $loaiDan['tenLoai'] ?>" required>
                                    </div>
                                    <button type="submit" name="edit" class="btn btn-success">Lưu</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </tbody>
        <a href="list.php" class="btn btn-secondary mb-3">Quay về</a>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
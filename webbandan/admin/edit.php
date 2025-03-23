<?php
    session_start();
    require_once "../database.php";

    if (!isset($_SESSION["admin"])) {
        header("Location: login.php");
        exit();
    }

    $database = new Database();
    $conn = $database->dbConnection();

    if (!isset($_GET["ma"])) {
        echo "Không tìm thấy đàn cần sửa!";
        exit();
    }

    $ma = $_GET["ma"];

    $query = "SELECT * FROM instrument WHERE ma = :ma";
    $stmt = $conn->prepare($query);
    $stmt->execute([":ma" => $ma]);
    $dan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dan) {
        echo "Đàn không tồn tại!";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ten = $_POST["ten"];
        $loaiDan = $_POST["loaiDan"];
        $xuatXu = $_POST["xuatXu"];
        $giaThanh = $_POST["giaThanh"];
        $hang = $_POST["hang"];
        $moTa = $_POST["moTa"];
        $hinhAnh = $dan["hinhAnh"]; 

        if (isset($_FILES["hinhAnh"]) && $_FILES["hinhAnh"]["error"] == 0) {
            $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
            $fileType = $_FILES["hinhAnh"]["type"];

            if (!in_array($fileType, $allowedTypes)) {
                die("Chỉ nhận file ảnh (JPG, JPEG, PNG, GIF, WEBP)!");
            }

            $targetDir = "../uploads/";
            $targetFile = $targetDir . basename($_FILES["hinhAnh"]["name"]);
            move_uploaded_file($_FILES["hinhAnh"]["tmp_name"], $targetFile);
            $hinhAnh = $targetFile;
        }

        $updateQuery = "UPDATE instrument SET ten = :ten, loaiDan = :loaiDan, xuatXu = :xuatXu, 
                        giaThanh = :giaThanh, hang = :hang, hinhAnh = :hinhAnh, moTa = :moTa 
                        WHERE ma = :ma";
        $stmt = $conn->prepare($updateQuery);
        $stmt->execute([
            ":ten" => $ten, ":loaiDan" => $loaiDan, ":xuatXu" => $xuatXu,
            ":giaThanh" => $giaThanh, ":hang" => $hang, ":hinhAnh" => $hinhAnh, ":moTa" => $moTa,
            ":ma" => $ma
        ]);

        header("Location: list.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin đàn</title>
    <!-- <link rel="stylesheet" href="../styles/add_edit.css"> -->
</head>
<body>
    <div class="admin-container">
        <div class="logo">
            <h1>WEB BÁN ĐÀN</h1>
        </div>
        <h2 class="page-title">Sửa thông tin đàn</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <label for="ten">Tên đàn</label>
                <input type="text" id="ten" name="ten" value="<?= htmlspecialchars($dan['ten']) ?>" required>
            </div>
            
            <div class="form-row">
                <label for="loaiDan">Loại đàn</label>
                <select id="loaiDan" name="loaiDan" required>
                    <option value="">-- Chọn loại đàn --</option>
                    <option value="Guitar" <?= $dan['loaiDan'] == 'Guitar' ? 'selected' : '' ?>>Guitar</option>
                    <option value="Organ" <?= $dan['loaiDan'] == 'Organ' ? 'selected' : '' ?>>Organ</option>
                    <option value="Piano" <?= $dan['loaiDan'] == 'Piano' ? 'selected' : '' ?>>Piano</option>
                    <option value="Ukulele" <?= $dan['loaiDan'] == 'Ukulele' ? 'selected' : '' ?>>Ukulele</option>
                </select>
            </div>
            
            <div class="form-row">
                <label for="xuatXu">Xuất xứ</label>
                <input type="text" id="xuatXu" name="xuatXu" value="<?= htmlspecialchars($dan['xuatXu']) ?>">
            </div>
            
            <div class="form-row">
                <label for="giaThanh">Giá thành (VND)</label>
                <input type="number" id="giaThanh" name="giaThanh" value="<?= htmlspecialchars($dan['giaThanh']) ?>" min="1" required>
            </div>
            
            <div class="form-row">
                <label for="hang">Hãng</label>
                <input type="text" id="hang" name="hang" value="<?= htmlspecialchars($dan['hang']) ?>">
            </div>
            
            <div class="form-row">
                <label for="hinhAnh">Hình ảnh</label>
                <input type="file" id="hinhAnh" name="hinhAnh" accept="image/*">
                <div class="current-image">
                    Ảnh hiện tại: <?= htmlspecialchars($dan['hinhAnh']) ?>
                </div>
            </div>
            
            <div class="form-row">
                <label for="moTa">Mô tả</label>
                <textarea id="moTa" name="moTa"><?= htmlspecialchars($dan['moTa']) ?></textarea>
            </div>
            
            <div class="actions">
                <a href="list.php" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-primary">LƯU</button>
            </div>
        </form>
    </div>
</body>
</html>
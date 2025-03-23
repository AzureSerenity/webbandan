<?php
    session_start();
    require_once "../database.php";

    if (!isset($_SESSION["admin"])) {
        header("Location: login.php");
        exit();
    }

    $database = new Database();
    $conn = $database->dbConnection();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ten = $_POST["ten"];
        $loaiDan = $_POST["loaiDan"];
        $xuatXu = $_POST["xuatXu"];
        $giaThanh = $_POST["giaThanh"];
        $hang = $_POST["hang"];
        $moTa = $_POST["moTa"];

        if ($giaThanh <= 0) {
            die("Giá thành phải lớn hơn 0 VND!");
        }

        if (isset($_FILES["hinhAnh"]) && $_FILES["hinhAnh"]["error"] == 0) {
            $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
            $fileType = $_FILES["hinhAnh"]["type"];

            if (!in_array($fileType, $allowedTypes)) {
                die("Chỉ chấp nhận file ảnh (JPG, JPEG, PNG, GIF, WEBP)!");
            }

            $targetDir = "../uploads/";
            $targetFile = $targetDir . basename($_FILES["hinhAnh"]["name"]);
            move_uploaded_file($_FILES["hinhAnh"]["tmp_name"], $targetFile);
            $hinhAnh = $targetFile;
        } else {
            die("Lỗi khi tải ảnh lên!");
        }

        $query = "INSERT INTO instrument (ten, loaiDan, xuatXu, giaThanh, hang, hinhAnh, moTa) VALUES 
                (:ten, :loaiDan, :xuatXu, :giaThanh, :hang, :hinhAnh, :moTa)";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            ":ten" => $ten, ":loaiDan" => $loaiDan, ":xuatXu" => $xuatXu,
            ":giaThanh" => $giaThanh, ":hang" => $hang, ":hinhAnh" => $hinhAnh, ":moTa" => $moTa
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
    <title>Thêm đàn mới</title>
    <!-- <link rel="stylesheet" href="../styles/add_edit.css"> -->
</head>
<body>
    <div class="admin-container">
        <div class="logo">
            <h1>WEB BÁN ĐÀN</h1>
        </div>
        <h2 class="page-title">Thêm đàn</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <label for="ten">Tên đàn</label>
                <input type="text" id="ten" name="ten" placeholder="Nhập tên đàn" required>
            </div>
            
            <div class="form-row">
                <label for="loaiDan">Loại đàn</label>
                <select id="loaiDan" name="loaiDan" required>
                    <option value="">-- Chọn loại đàn --</option>
                    <option value="Guitar">Guitar</option>
                    <option value="Organ">Organ</option>
                    <option value="Piano">Piano</option>
                </select>
            </div>
            
            <div class="form-row">
                <label for="xuatXu">Xuất xứ</label>
                <input type="text" id="xuatXu" name="xuatXu" placeholder="Nhập xuất xứ">
            </div>
            
            <div class="form-row">
                <label for="giaThanh">Giá thành (VND)</label>
                <input type="number" id="giaThanh" name="giaThanh" placeholder="Nhập giá thành" min="1" required>
            </div>
            
            <div class="form-row">
                <label for="hang">Hãng sản xuất</label>
                <input type="text" id="hang" name="hang" placeholder="Nhập hãng sản xuất">
            </div>
            
            <div class="form-row">
                <label for="hinhAnh">Hình ảnh</label>
                <input type="file" id="hinhAnh" name="hinhAnh" accept="image/*" required>
            </div>
            
            <div class="form-row">
                <label for="moTa">Mô tả</label>
                <textarea id="moTa" name="moTa" placeholder="Nhập mô tả chi tiết về đàn"></textarea>
            </div>
            
            <div class="actions">
                <a href="list.php" class="btn btn-secondary">Quay lại</a>
                <button type="submit" class="btn btn-primary">THÊM ĐÀN</button>
            </div>
        </form>
    </div>
</body>
</html>
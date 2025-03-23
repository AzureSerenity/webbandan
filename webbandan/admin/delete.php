<?php
    session_start();
    require_once "../database.php";

    if (!isset($_SESSION["admin"])) {
        header("Location: login.php");
        exit();
    }

    $database = new Database();
    $conn = $database->dbConnection();

    if (isset($_GET["ma"])) {
        $ma = $_GET["ma"];
        $query = "DELETE FROM instrument WHERE ma = :ma";
        $stmt = $conn->prepare($query);
        $stmt->execute([":ma" => $ma]);
    }

    header("Location: list.php");
    exit();
?>

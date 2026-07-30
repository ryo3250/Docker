<?php
// データベースへ接続するために必要な情報
// ホストはDBコンテナ
$host = 'mysql';
// mysql接続用のユーザー
$username = 'data_user';
$password = 'data';
$database = 'data_master';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['student_id']) && is_numeric($_POST['student_id'])) {
        $student_id_to_delete = $_POST['student_id'];

        try {
            $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // 不正なクエリ（SQLインジェクション）を防ぐためプリペアドステートメントを使用
            $sql = "DELETE FROM students WHERE student_id = :student_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':student_id', $student_id_to_delete, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "ID: " . htmlspecialchars($student_id_to_delete) . " deleted";
            } else {
                echo "ID: " . htmlspecialchars($student_id_to_delete) . " not found";
            }

        } catch(PDOException $e) {
            echo "delete FAILE: " . $e->getMessage();
        } finally {
            $conn = null;
        }
    } else {
        echo "request error";
    }
} else {
    echo "access error";
}
?>

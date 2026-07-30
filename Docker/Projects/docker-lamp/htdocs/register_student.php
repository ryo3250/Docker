<?php
// データベースへ接続するために必要な情報
// ホストはDBコンテナ
$host = 'mysql';
// mysql接続用のユーザー
$username = 'data_user';
$password = 'data';
$database = 'data_master';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // パラメータ取得
    $name = $_POST["name"];
    $class_id = $_POST["class_id"];

    // データの検証
    $name = htmlspecialchars(trim($name));
    $class_id = filter_var($class_id, FILTER_VALIDATE_INT);

    // バリデーションチェック
    if (empty($name)) {
        die("input name");
    }
    if ($class_id === false) {
        die("input class_id");
    }

    try {
        // PDOを使用してデータベースに接続
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
        // エラーモードを例外に設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // student_idの自動採番
        $sql_max_id = "SELECT MAX(student_id) FROM students";
        $stmt_max_id = $pdo->query($sql_max_id);
        $max_id = $stmt_max_id->fetchColumn();
        $next_student_id = ($max_id === null) ? 1 : $max_id + 1;

        // 不正なクエリ（SQLインジェクション）を防ぐためプリペアドステートメントを使用
        $sql = "INSERT INTO students (student_id, student_name, class_id) VALUES (:student_id, :student_name, :class_id)";
        $stmt = $pdo->prepare($sql);

        // パラメータをバインド
        $stmt->bindParam(':student_id', $next_student_id, PDO::PARAM_INT);
        $stmt->bindParam(':student_name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT);

        // SQLクエリを実行
        $stmt->execute();

        echo "regist OK <br>";
        echo "Student ID: " . htmlspecialchars($next_student_id) ;

    } catch(PDOException $e) {
        echo "regist FAILE" . $e->getMessage();
    } finally {
        // 接続を閉じる
        $pdo = null;
    }

} else {
    // POSTリクエスト以外でアクセスされた場合
    echo "request error";
}
?>

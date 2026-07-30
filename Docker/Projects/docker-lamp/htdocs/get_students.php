<?php
// データベースへ接続するために必要な情報
// ホストはDBコンテナ
$host = 'mysql';
// mysql接続用のユーザー
$username = 'data_user';
$password = 'data';
$database = 'data_master';

try {
    // PDOでMySQLに接続
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データの取得
    $stmt = $pdo->query("SELECT * FROM students");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 取得したデータをセッションに保存
    session_start();
    $_SESSION['data'] = $results;

    // リダイレクト
    header("Location: display_students.php");
    exit();

} catch (PDOException $e) {
    // エラー処理
    echo "データベースエラー: " . $e->getMessage();
}
?>

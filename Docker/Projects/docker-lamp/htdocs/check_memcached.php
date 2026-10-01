<?php
//データベースへの接続するために必要な情報
//ホストはDBコンテナ
$host = 'mysql';
//mysql接続用のユーザー
$username = 'data_user';
$password = 'data';
$database = 'data_master';

//キャッシュへの接続情報
$memcechedHost = 'memcached';
$memcechedPort = 11211;

$cacheKey = 'all_students_data';
//キャッシュの有効秒数
$expireSeconds = 60;

//Memcachedへの接続
$memceched = new memcached();
$memceched->addServer($memcechedHost, $memcechedPort);

echo "<h1>MySQL Data Caching with Memcached</h1>";

//Memcachedからデータを取得
$cachedData = $memceched->get($cacheKey);

if($cachedData){
    echo "<p>Data retrieved from Memcached (cache hit!).</p>";
    echo "<pre>";
    print_r(json_decode($cachedData, true));
    echo "</pre>";
}else{
    echo "<p>Data not found in Memcached (cache miss).Retrieving from MySQL...</p>";
    
    try{
    //PDOでMySQLに接続
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8",$username,
        $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        //データの取得
        $stmt = $pdo->query("SELECT * FROM students");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //データをMemcachedに保存
        $memceched->set($cacheKey,json_encode($results),$expireSeconds);

        echo "<p>Data retrieved from MySQL and saved to Memcached.</p>";
        echo "<pre>";
        print_r($results);
        echo "</pre>";

    }catch(PDOException $e){
        echo "<p>Error connecting to MySQL or fetching data:".$e->getMessage()."</p>";
    }
}

echo "<p>Current time:".date('Y-m-d H:i:s')."</p>";
echo "<p><a href='?clear_cache=1'>Clear Cache (and reload to see cache miss)</a></p>";

//キャッシュ削除機能
if(isset($_GET['clear_cache']) && $_GET['clear_cache'] == 1){
    if($memceched->delete($cacheKey)){
        echo "<p>Cache for '$cacheKey' cleared!</p>";        
    }else{
        echo "<p>Failed to clear cache for '$cacheKey'.</p>";
    }
}
?>


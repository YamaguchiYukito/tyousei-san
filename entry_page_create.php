<?php
// MYSQLに接続
try {
    $pdo = new PDO('mysql:dbname=tyouseisan;host=localhost', 'tyouseisan', 'P@ssw0rd');
} catch (PDOException $e) {
    print('Error:'.$e->getMessage());
    die();
}

// イベントのurlを取得
$sql = "SELECT url FROM event_t WHERE id = " .$argv[1] .";";
$stmt = $pdo->query($sql);
foreach($stmt as $s) {
    $url = $s['url'];
}

// URL発行
$file_directory = "events/";
$file_name = $url .".php";

// phpページ作成
$original_file = file_get_contents('entry_event.php');
$original_file = str_replace("<%PAGEURL>", $url, $original_file);
$original_file = mb_convert_encoding($original_file, "UTF-8", "AUTO");
file_put_contents($file_directory .$file_name, $original_file);
?>

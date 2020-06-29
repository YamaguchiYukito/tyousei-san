<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>調整さん</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <h1>調整さん</h1>
    <form method="post" action="">
      <div class="element_wrap">
	<h2><label>作成完了</label></h2>
	<p>
	  <?php
	  // ユーザ入力内容の処理
	  $event_name = $_POST['event_name'];
	  $sponsor_name = $_POST['event_name'];
	  $event_detail = $_POST['event_detail'];
	  $date_array = array();
	  foreach($_POST['event_days'] as $day) {
	      if(!empty($day)) {
		  array_push($date_array, $day);
	      }
	  }
	  
	  // ランダムなURLの発行
	  $url_size = 32;
	  $url = strtolower(substr(str_replace(['/', '+'], ['_', '-'], base64_encode(random_bytes($url_size))), 0, $url_size));

	  // 日程をDBに格納する文字列に変換
	  $date_string = "";
	  for ($i = 0; $i < 7; $i++) {
	      if ($i < count($date_array)) {
		  $date_string = $date_string .", '" .$date_array[$i] ."'";
	      } else {
		  $date_string = $date_string .", NULL";
	      }
	  }

	  // MYSQLに接続
	  try {
	      $pdo = new PDO('mysql:dbname=tyouseisan;host=localhost', 'tyouseisan', 'P@ssw0rd');
	  } catch (PDOException $e) {
	      print('Error:'.$e->getMessage());
	      die();
	  }

	  // イベントのIDを決める処理
	  $id = 0;
	  $sql = "SELECT id FROM event_t ORDER BY id DESC LIMIT 1;";
	  $stmt = $pdo->query($sql);
	  foreach($stmt as $s) {
	      $id = $s['id'] + 1;
	  }
	  
	  // イベントをデータベースに登録
	  $values = $id .", '" .$_POST['event_name'] ."', '" .$_POST['sponsor_name'] ."', '" .date("Y/m/d") ."', '" .$event_detail ."', '" .$url ."'" .$date_string;
	  $sql = "INSERT INTO event_t VALUES (" .$values .");";
	  $stmt = $pdo->query($sql);

	  // URL発行
	  echo "<h3>こちらのURLを共有してください。</h3>";
	  $protocol = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://');
	  $file_directory = "/events/";
	  $file_name = $url .".php";
	  $event_page_url = $protocol .$_SERVER['HTTP_HOST'] .$file_directory .$file_name;
	  print('<a href="' .$event_page_url .'">' .$event_page_url ."</a>");
	  
	  // phpページ作成
	  // -----------------------------------------------
	  // 保留
	  // -----------------------------------------------
	  ?>
	</p>
      </div>
    </form>
    <p><a href="tyouseisan.php">トップへ</a></p>
  </body>
</html>

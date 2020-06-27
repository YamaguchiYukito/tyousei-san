<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>調整さん</title>
  </head>
  <body>
    <h1>調整さん</h1>
    <h2><a href="create_event.php">イベントを作成する</a></h2>
    <h2>イベント一覧</h2>
    <table border="1" width="90%">
      <tr>
	<th>イベント名</th>
	<th>主催者</th>
	<th>作成日</th>
	<th>詳細</th>
	<th>イベントページ</th>
      </tr>
      <?php
      // MYSQLに接続
      try {
	  $pdo = new PDO('mysql:dbname=tyouseisan;host=localhost', 'tyouseisan', 'P@ssw0rd');
      } catch (PDOException $e) {
	  print('Error:'.$e->getMessage());
	  die();
      }

      // イベントテーブルから情報を取り出す
      $sql = 'SELECT * FROM event_t';
      $stmt = $pdo->query($sql);
      $events = $stmt->fetchAll();

      // イベント一覧を表示
      $protocol = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://');
      $host = $_SERVER['HTTP_HOST'];
      foreach($events as $event) {
	  echo "<tr>";
	  print("<td>" .$event['name'] ."</td>");
	  print("<td>" .$event['sponsor'] ."</td>");
	  print("<td>" .$event['create_date'] ."</td>");
	  print("<td>" .$event['detail'] ."</td>");
	  $event_page = $protocol .$host ."/events/" .$event['url'] .".php";
	  print("<td>" .'<a href="' .$event_page .'">こちら</a>' ."</td>");
	  echo "</tr>";
      }
      ?>
    </table>
    <p><a href="index.html">戻る</a></p>
  </body>
</html>

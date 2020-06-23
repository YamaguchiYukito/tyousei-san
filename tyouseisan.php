<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>調整さん</title>
  </head>
  <body>
    <h1>調整さん</h1>
    <p>今日は<?php echo date("Y/m/d"); ?>です。</p>
    <p><a href="create_event.php">イベントを作成する</a></p>    
    <p>
      <?php
      try {
	  $pdo = new PDO('mysql:dbname=tyouseisan;host=localhost', 'tyouseisan', 'P@ssw0rd');
      } catch (PDOException $e) {
	  print('Error:'.$e->getMessage());
	  die();
      }
      
      $sql = 'SELECT * FROM event_t';
      $stmt = $pdo->query($sql);
      $events = $stmt->fetchAll();
      $protocol = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://');
      $host = $_SERVER['HTTP_HOST'];
      print("イベント名, 主催者, 作成日、詳細、URL<br>");
      foreach($events as $event) {
	  $event_page = $protocol .$host ."/events/" .$event['url'];
	  print($event['name'] .", " .$event['sponsor'] .", " .$event['create_date'] .", " .$event['detail']);
	  print(', <a href="' .$event_page .'">' .$event_page .'</a><br>');
      }
      ?>
    </p>
    <p><a href="index.html">戻る</a></p>
  </body>
</html>

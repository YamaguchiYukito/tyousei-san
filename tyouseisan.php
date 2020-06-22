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
      
      $sql = 'SELECT * FROM member_t';
      $stmt = $pdo->query($sql);
      $result = $stmt->fetchAll();
      // var_dump($result);
      foreach($result as $member) {
	  print($member[0]. " : ". $member[1]. "<br>");
      }
      ?>
    </p>
    <p><a href="index.html">戻る</a></p>
  </body>
</html>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>調整さん</title>
  </head>
  <body>
    <h1>イベント参加ページ</h1>
    <h2>イベント情報</h2>
    <p>
      <?php
      // ページのURLを設定
      // $page_url = '-bxjgcwoj6jrxwjyzv3yphd70lw5xqt0';
      $page_url = "akip9wiebssqfmpstcc6nrujafsb11wa";
      
      // MYSQLに接続
      try {
	  $pdo = new PDO('mysql:dbname=tyouseisan;host=localhost', 'tyouseisan', 'P@ssw0rd');
      } catch (PDOException $e) {
	  print('Error:'.$e->getMessage());
	  die();
      }

      // イベントの情報を表示
      $sql = "SELECT * FROM event_t WHERE url = '" .$page_url ."';";
      $stmt = $pdo->query($sql);
      foreach($stmt as $event) {
	  $event_id = $event['id'];
	  print("イベント名 : " .$event['name'] ."<br>"
	       ."主催者     : " .$event['sponsor'] ."<br>"
	       ."詳細       : " .$event['detail'] ."<br>");
      }

      // イベントの開催候補日を配列に格納
      $sql = "SELECT date1, date2, date3, date4, date5, date6, date7 FROM event_t WHERE url = '" .$page_url ."';";
      $stmt = $pdo->query($sql);
      foreach($stmt as $dates) {
	  $date_array = array();
	  for($i = 0; $i < 7; $i++) {
	      if (!empty($dates[$i])) {
		  array_push($date_array, $dates[$i]);
	      }
	  }
      }
      ?>
    </p>
    <h2>イベント参加者一覧</h2>
    <p>
      <?php
      // 表示する情報のテンプレート
      echo "名前: ";
      for ($i = 0; $i < count($date_array); $i++) {
	  if ($i != 0) {
	      print(", ");
	  }
	  print("日程" .($i + 1));
      }
      echo "<br>";
      
      // 参加者の情報をデータベースから取り出す
      $sql = "SELECT name, date1, date2, date3, date4, date5, date6, date7 FROM member_t WHERE event_id = " .$event_id .";";
      $stmt = $pdo->query($sql);
      foreach($stmt as $member) {
	  print($member[0] .": ");
	  for ($i = 0; $i < count($date_array); $i++) {
	      if ($i != 0) {
		  echo ", ";
	      }
	      print($member[$i + 1]);
	  }
	  echo "<br>";
      }
      if (isset($_POST['entry_button'])) {
	  // 参加可否をDBに格納する文字列に変換
	  $part_date_array = array();
	  foreach($_POST['part_date'] as $date) {
	      array_push($part_date_array, $date);
	  }

	  $part_name = $_POST['part_name'];
	  
	  print($part_name .": ");
	  for ($i = 0; $i < count($part_date_array); $i++) {
	      if ($i != 0) {
		  echo ", ";
	      }
	      print($part_date_array[$i]);
	  }
      }

      ?>
    </p>
    <h2>イベントに参加する</h2>
    <form method="post" action="">
      <div class="element_wrap">
	<label>名前</label>
	<input type="text"
	       name="part_name"
	       value="<?php 
		      if (!empty($_POST['part_name'])) {
			  echo $_POST['part_name'];
		      }
		      ?>">
      </div>
      <?php
      // それぞれの開催日程について、参加可否のラジオボタンをつける
      $i = 0;
      foreach($date_array as $date) {
	  print('<div class="element_wrap">');
	  print('<label>日程' .($i + 1) .' : </label>');
	  print($date ."<br>");
	  print('<label for="date_0">');
	  print('<input id="date_0" type="radio" name="part_date[' .$i .']" value="0">maru');
	  print('</label>');
	  print('<label for="date_1">');
	  print('<input id="date_1" type="radio" name="part_date[' .$i .']" value="1">sankaku');
	  print('</label>');
	  print('<label for="date_2">');
	  print('<input id="date_2" type="radio" name="part_date[' .$i .']" value="2">batsu');
	  print('</label>');
	  print('</div>');
	  $i++;
      }
      ?>
      <div class="element_wrap">
	<input type="submit" name="entry_button" value="参加">
      </div>
      <?php
      if (isset($_POST['entry_button'])) {
	  // 日程のSQL文を作る処理
	  $part_date_string = "";
	  for ($i = 0; $i < 7; $i++) {
	      if ($i < count($part_date_array)) {
		  $part_date_string = $part_date_string .", " .$part_date_array[$i];
	      } else {
		  $part_date_string = $part_date_string .", NULL";
	      }
	  }
	  
	  // 参加者のIDを決める処理
	  $part_id = 0;
	  $sql = "SELECT id FROM member_t ORDER BY id DESC LIMIT 1;";
	  $stmt = $pdo->query($sql);
	  foreach($stmt as $s) {
	      $part_id = $s['id'] + 1;
	  }
	  
	  // 参加者をデータベースに登録
	  $values = $part_id .", '" .$part_name ."'" .$part_date_string .", " .$event_id;
	  $sql = "INSERT INTO member_t VALUES(" .$values .");";
	  $stmt = $pdo->query($sql);
      }
      ?>
    </form>
  </body>
</html>

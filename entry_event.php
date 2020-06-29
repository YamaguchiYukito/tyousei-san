<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>調整さん</title>
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <h1>調整さん</h1>
    <h2>イベント情報</h2>
    <table>
      <?php
      // ページのURLを設定
      $page_url = "<%PAGEURL>";
      
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
	  echo "<tr>";
	  print('<th width="20%">イベント名</th>');
	  print('<td width="80%">' .$event['name'] ."</td>");
	  echo "</tr>";
	  echo "<tr>";
	  print('<th width="20%">主催者</th>');
	  print('<td width="80%">' .$event['sponsor'] ."</td>");
	  echo "</tr>";
	  echo "<tr>";
	  print('<th width="20%">詳細</th>');
	  print('<td width="80%">' .$event['detail'] ."</td>");
	  echo "</tr>";
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
    </table>
    <h2>イベント参加者一覧</h2>
    <table border="1">
      <?php
      // 表示する情報のテンプレート
      echo "<tr>";
      echo "<th>名前</th>";
      for ($i = 0; $i < count($date_array); $i++) {
	  print("<th>日程" .($i + 1) ."</th>");
      }
      echo "</tr>";
      
      // 参加者の情報をデータベースから取り出す
      $sql = "SELECT name, date1, date2, date3, date4, date5, date6, date7 FROM member_t WHERE event_id = " .$event_id .";";
      $stmt = $pdo->query($sql);
      foreach($stmt as $member) {
	  echo "<tr>";
	  print("<td>" .$member[0] ."</td>");
	  for ($i = 0; $i < count($date_array); $i++) {
	      print("<td>" .$member[$i + 1] ."</td>");
	  }
	  echo "</tr>";
      }
      if (isset($_POST['entry_button'])) {
	  // 参加可否をDBに格納する文字列に変換
	  $part_date_array = array();
	  foreach($_POST['part_date'] as $date) {
	      array_push($part_date_array, $date);
	  }

	  echo "<tr>";
	  $part_name = $_POST['part_name'];
	  print("<td>" .$part_name ."</td>");
	  for ($i = 0; $i < count($part_date_array); $i++) {
	      print("<td>" .$part_date_array[$i] ."</td>");
	  }
	  echo "</th>";
      }

      ?>
    </table>
    <h2>イベントに参加する</h2>
    <form method="post" action="" onsubmit="return check_submit(this)">
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
      <div id="part_name_alert_empty">
	名前を入力してください。
      </div>
      <div id="part_name_alert_over">
	名前は20文字以内で入力してください。
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

      // 候補日の数を保存
      $event_date_num = $i;
      ?>
      <div id="part_date_alert">
	全ての候補日にチェックを入れてください。
      </div>
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
	  $sql = "SELECT id FROM member_t WHERE event_id = " .$event_id ." ORDER BY id DESC LIMIT 1;";
	  $stmt = $pdo->query($sql);
	  foreach($stmt as $s) {
	      $part_id = $s['id'] + 1;
	  }
	  
	  // 参加者をデータベースに登録
	  $values = $event_id .", " .$part_id .", '" .$part_name ."'" .$part_date_string;
	  $sql = "INSERT INTO member_t VALUES(" .$values .");";
	  $stmt = $pdo->query($sql);
      }
      ?>
    </form>
    <script type="text/javascript">
     document.getElementById("part_name_alert_empty").style.display = "none";
     document.getElementById("part_name_alert_over").style.display = "none";
     document.getElementById("part_date_alert").style.display = "none";
     function check_submit(form) {
	 document.getElementById("part_name_alert_empty").style.display = "none";
	 document.getElementById("part_name_alert_over").style.display = "none";
	 document.getElementById("part_date_alert").style.display = "none";

	 var is_ok = true;
	 if (form.elements["part_name"].value == "") {
	     document.getElementById("part_name_alert_empty").style.display = "";
	     is_ok = false;
	 } else if (20 < form.elements["part_name"].value.length) {
	     document.getElementById("part_name_alert_over").style.display = "";
	     is_ok = false;
	 }
	 for (var i = 0; i < <?php echo $event_date_num; ?>; i++) {
	     var part_date = "part_date[" + i + "]";
	     radio = document.getElementsByName(part_date);
	     if (!radio[0].checked && !radio[1].checked && !radio[2].checked) {
		 document.getElementById("part_date_alert").style.display = "";
		 is_ok = false;
	     }
	 }
	 return is_ok;
     }
    </script>
    <p><a href="../tyouseisan.php">戻る</a></p>
  </body>
</html>

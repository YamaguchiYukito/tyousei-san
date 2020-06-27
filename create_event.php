<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>調整さん</title>
  </head>
  <body>
    <h1>調整さん</h1>
    <h2>イベント作成ページ</h2>
    <form method="post" action="confirm_event.php" onsubmit="return check_submit(this)">
      <div class="element_wrap">
	<h3><label>イベント名</label></h3>
	<input type="text"
	       name="event_name"
	       value="<?php 
		      if (!empty($_POST['event_name'])) {
			  echo $_POST['event_name'];
		      }
		      ?>">
	<div id="event_name_alert">
	  イベント名を入力してください。
	</div>
      </div>
      <div class="element_wrap">
	<h3><label>主催者</label></h3>
	<input type="text"
	       name="sponsor_name"
	       value="<?php 
		      if (!empty($_POST['sponsor_name'])) {
			  echo $_POST['sponsor_name'];
		      }
		      ?>">
	<div id="sponsor_name_alert">
	  主催者を入力してください。
	</div>
      </div>
      <div class="element_wrap">
	<h3><label>詳細</label></h3>
	<textarea name="event_detail"
		  cols="50"
		  rows="5"></textarea>
      </div>
      <h3>開催日候補</h3>
      <div class="element_wrap" id="day0">
	<label>日程1</label>
	<input type="date" name="event_days[0]"></input>
      </div>
      <div class="element_wrap" id="day1">
	<label>日程2</label>
	<input type="date" name="event_days[1]"></input>
      </div>
      <div class="element_wrap" id="day2">
	<label>日程3</label>
	<input type="date" name="event_days[2]"></input>
      </div>
      <div class="element_wrap" id="day3">
	<label>日程4</label>
	<input type="date" name="event_days[3]"></input>
      </div>
      <div class="element_wrap" id="day4">
	<label>日程5</label>
	<input type="date" name="event_days[4]"></input>
      </div>
      <div class="element_wrap" id="day5">
	<label>日程6</label>
	<input type="date" name="event_days[5]"></input>
      </div>
      <div class="element_wrap" id="day6">
	<label>日程7</label>
	<input type="date" name="event_days[6]"></input>
      </div>
      <div id="event_days_alert">
	開催日候補を1つ以上入力してください。
      </div>
      <script type="text/javascript">
       // 本当は day0 〜 day6 の表示非表示を行いたいけど
       // jQuery使わないとリアルタイム切り替えは面倒そうなので
       // またの機会に
      </script>
      <div class="element_wrap">
	<input type="submit" name="create_button" value="確認">
      </div>
    </form>
    <script type="text/javascript">
     document.getElementById("event_name_alert").style.display = "none";
     document.getElementById("sponsor_name_alert").style.display = "none";
     document.getElementById("event_days_alert").style.display = "none";
     function check_submit(form) {
	 document.getElementById("event_name_alert").style.display = "none";
	 document.getElementById("sponsor_name_alert").style.display = "none";
	 document.getElementById("event_days_alert").style.display = "none";
     
	 var is_ok = true;
	 if (form.elements["event_name"].value == "") {
	     document.getElementById("event_name_alert").style.display = "";
	     is_ok = false;
	 }
	 if (form.elements["sponsor_name"].value == "") {
	     document.getElementById("sponsor_name_alert").style.display = "";
	     is_ok = false;
	 }
	 var event_days_is_ok = false;
	 for (var i = 0; i < 7; i++) {
	     var event_day = "event_days[" + i + "]";
	     if (form.elements[event_day].value != "") {
		 event_days_is_ok = true;
	     }
	 }
	 if (!event_days_is_ok) {
	     document.getElementById("event_days_alert").style.display = "";
	     is_ok = false;
	 }
	 return is_ok;
     }
    </script>
    <p><a href="tyouseisan.php">戻る</a></p>
  </body>
</html>

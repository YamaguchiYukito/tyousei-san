<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>調整さん</title>
  </head>
  <body>
    <form method="post" action="">
      <div class="element_wrap">
	<label>イベント名</label>
	<input type="text" name="event_name" value="<?php 
						    if (!empty($_POST['event_name'])) {
							echo $_POST['event_name'];
						    }
						    ?>">
      </div>
      <div class="element_wrap">
	<label>主催者</label>
	<input type="text" name="sponsor_name" value="<?php 
						      if (!empty($_POST['sponsor_name'])) {
							  echo $_POST['sponsor_name'];
						      }
						      ?>">
      </div>
      <div class="element_wrap">
	<label>日程1</label>
	<input type="date" name="day1"></input>
      </div>
      <div class="element_wrap">
	<label>日程2</label>
	<input type="date" name="day2"></input>
      </div>
      <div class="element_wrap">
	<label>日程3</label>
	<input type="date" name="day3"></input>
      </div>
      <div class="element_wrap">
	<label>日程4</label>
	<input type="date" name="day4"></input>
      </div>
      <div class="element_wrap">
	<label>日程5</label>
	<input type="date" name="day5"></input>
      </div>
      <div class="element_wrap">
	<label>日程6</label>
	<input type="date" name="day6"></input>
      </div>
      <div class="element_wrap">
	<label>日程7</label>
	<input type="date" name="day7"></input>
      </div>
      <div class="element_wrap">
	<input type="submit" name="create_button" value="作成">
      </div>
    </form>
    <p><a href="tyousesan.php">戻る</a></p>
  </body>
</html>

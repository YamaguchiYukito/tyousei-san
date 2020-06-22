<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>
      Tyousei-san
    </title>
  </head>
  <body>
    <h1>調整さん</h1>
    <p>今日は<?php echo date("Y/m/d"); ?>です。</p>
    <p>
      <form method="post">
	名前: <input type="text" name="name" />
	年齢: <input type="text" name="age" />
	<input type="submit" />
      </form>
    </p>
    <p>
      こんにちは、
      <?php echo (int)$_POST['age']; ?>
      歳の
      <?php echo htmlspecialchars($_POST['name']); ?>
      さん。
    </p>
  </body>
</html>

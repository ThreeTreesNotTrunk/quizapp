<?php
$csv  = array();
$file = 'test.csv';
$fp = fopen($file, "r");
 
while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
  $csv[] = $data;
}
fclose($fp);
 
//--------------------クイズを管理する変数----------------------//
//配列の宣言
$questions = array();
$titles = array();
$answers = array();
 
for ($i = 0; $i < count($csv); $i++) {
  $titles[$i] = array_shift($csv[$i]);
  $answers[$i] = $csv[$i][0];
  $questions[$i] = $csv[$i];
  shuffle($questions[$i]);
}
 
//-------------------答えのカウントをする変数-----------------------//
$correct_count = 0;
$result = "正解数：";
 
//正解だったら正解としてカウンタに１ずつ足す
for ($i = 0; $i < count($csv); $i++) {
  $q_num = "question" . ($i + 1);
  if (isset($_POST[$q_num])) {
    if ($_POST[$q_num] == $answers[$i]) {
      $correct_count += 1;
    }
  }
}
//-------------------html-----------------------//
?>
<!doctype html>
<html>
 
<head>
  <meta charset="utf-8">
  <title>簡易クイズプログラム</title>
</head>
 
<body>
  <form method="POST" action="">
    <?php for ($i = 0; $i < count($csv); $i++) { ?>
      <h3><?php echo $titles[$i] ?></h3>
      <?php
        foreach ($questions[$i] as $value1) { ?>
        <input type="radio" name="<?php echo 'question' . ($i + 1); ?>" value="<?php echo $value1; ?>" /> <?php echo $value1; ?><br>
      <?php } ?>
    <?php } ?>
    <input type="submit" value="回答する" name="kaitou">
  </form>
 
  <?php
  if (isset($_POST['kaitou'])) {
    echo $result . $correct_count . '問';
  }
  ?>
</body>
 
</html>


<?php

// 動作確認コピペ用URL
// localhost/zzSCHEDULEzz/schedule_calender.php

// カレンダーの年月をタイムスタンプを使って指定
if(isset($_GET["date"]) && $_GET["date"] != ""){
	$date_timestamp = $_GET["date"];
}else{
	$date_timestamp = time();
}

$month = date("m", $date_timestamp);
$year  = date("Y", $date_timestamp);

$first_date = mktime(0, 0, 0, $month, 1, $year);
$last_date  = mktime(0, 0, 0, $month + 1, 0, $year);

//　最初の人最後の日の「日にち」の部分だけ数字で取り出す。
$first_day = date("j", $first_date);
$last_day  = date("j", $last_date);

//　全ての日の曜日を得る。
for($day = $first_day; $day <= $last_day; $day++){
	$day_timestamp = mktime(0, 0, 0, $month, $day, $year);
	$week[$day] = date("w", $day_timestamp);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<title>カレンダー</title>
<style type="text/css">
	a:link{color: #3366FF; background-color: transparent;
	text-decoration: none; font-weight: bold;}
	a:visited{color: #2B318F; background-color: transparent;
	text-decoration: none; font-weight: bold;}
	a:hover{color: 00BFFF; background-color: transparent;
	text-decoration: underline;}
	body{color: #333333; background_color: #FFFFFF;}
	table {border: 1px solid #CCCCCC; border-collapse: collapse;
	margin-bottom: 1em;}
	td {border: 1px solid #CCCCCC; width: 2.5em; height: 2.5em;
	text-align: right; vertical-align: bottom; padding: 2px;}
	th {border: 1px solid #CCCCCC; color: #333333;
	background-color: #F0F0F0; padding: 5px;}
</style>
</head>
<body>
<table border="1">
	<tr>
		<th colspan="2"><a href="schedule_calender.php?date=<?php print(strtotime("-1 month", $first_date)); ?>">前月</a></th>
		<th colspan="3"><?php print(date("Y", $date_timestamp) . "年" . date("n", $date_timestamp) . "月"); ?></th>
		<th colspan="2"><a href="schedule_calender.php?date=<?php print(strtotime("+1 month", $first_date)); ?>">次月</a></th>
	</tr>
	<tr>
		<th>日</th>
		<th>月</th>
		<th>火</th>
		<th>水</th>
		<th>木</th>
		<th>金</th>
		<th>土</th>
	</tr>
	<tr>
		<?php
		//スケジュールファイルがあるかチェック
		$filename = "C:\\xampp\\htdocs\\zzSCHEDULEzz\\samplefile.txt";
		if(file_exists($filename)){
			//　カレンダーの最初の空白部分
			for($i = 0; $i < $week[$first_day]; $i++){
				print("<td></td>\n");
			}

			$filename = "samplefile.txt";
			$schedule_list = file($filename);

			for($day = $first_day; $day <= $last_day; $day++){
				if($week[$day] == 0){
					print("</tr>\n<tr>\n");
				}

				//スケジュールが存在するかどうかチェックする
				$exist_schedule = false;

				foreach($schedule_list as $lineno => $line){
					list($schedule_date, $title, $body) = explode("|", $line);

					if($schedule_date == $year . $month .sprintf("%02d", $day)){
						$exist_schedule = true;
						break;
					}
				}

				// スケジュールが存在したらリンクを付ける
				if($exist_schedule){
					print("<td><a href=\"schedule_list.php?year=" .$year .
					"&month=". $month . "&day=$day\">$day</a></td>\n");
				}else{
					print("<td>$day</td>\n");
				}
			}

			//　カレンダーの最後の空白部分
			for($i = $week[$last_day] + 1; $i < 7; $i++){
				print("<td></td>\n");
			}
		}else{
			printf("スケジュールを保存するファイルがありません。「" . $filename . "」が存在するか確認してください。");
		}
		?>
	</tr>
</table>
<p><a href="schedule_edit.php">スケジュールの新規作成</a></p>
<p><a href="schedule_sort.php">全スケジュールを表示</a></p>
</body>
</html>

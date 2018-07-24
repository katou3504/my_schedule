<?php

// 動作確認コピペ用URL
// localhost/zzSCHEDULEzz/schedule_list.php

$filename = "C:\\xampp\\htdocs\\zzSCHEDULEzz\\samplefile.txt";
$schedule_list = file($filename);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<title>スケジュール一覧</title>
<style type="text/css">
	a:link {color: #3366FF; background-color: transparent;
	text-decoration: none; font-weight: bold;}
	a:visited {color: #2B318F; background-color: transparent;
	text-decoration: none; font-weight: bold;}
	a:hover {color: #00BFFF; background-color: transparent;
	text-decoration: underline;}
	body {color: #333333; background-color: #FFFFFF;}
	table {border: 1px solid #CCCCCC; border-collapse: collapse;
	margin-bottom: 1em;}
	td {border: 1px solid #CCCCCC; height: 2.5em;
		vertical-align: middle; padding-left: 1em; padding-top: 2px;
		padding-right: 1em; padding-bottom: 2px;}
	th {border: 1px solid #CCCCCC; color: #333333;
		background-color: #F0F0F0; padding: 5px;}
</style>
</head>
<body>
<table border="1">
	<tr>
		<th>日付</th>
		<th>タイトル</th>
		<th>内容</th>
		<th>編集</th>
		<th>削除</th>
	</tr>
<?php

//表示処理
function print_list($schedule_date, $title, $body, $lineno){
	print("<tr>\n");
	print("<td>$schedule_date</td>\n");
	print("<td>$title</td>\n");
	print("<td>$body</td>\n");
	print("<td><a href=\" schedule_edit.php?lineno=$lineno&mode=edit\">編集する</a></td>\n");
	print("<td><a href=\" schedule_edit.php?lineno=$lineno&mode=delete\">削除する</a></td>\n");
	print("</tr>\n");
}

//ファイルチェック
if(file_exists($filename)){
	//表示ループ
	foreach($schedule_list as $lineno => $line){
		list($schedule_date, $title, $body) = explode("|", $line);
		if(isset($_GET["all"]) && $_GET["all"] == 1){
			print_list($schedule_date, $title, $body, $lineno);
//		}elseif(isset($_GET["month"]) && isset($_GET["day"]) && isset($_GET["year"])){
//			if($schedule_date == date("Ymd", mktime(0, 0, 0, $_GET["month"], $_GET["day"], $_GET["year"]))){
		}elseif($schedule_date == date("Ymd", mktime(0, 0, 0, $_GET["month"], $_GET["day"], $_GET["year"]))){
				print_list($schedule_date, $title, $body, $lineno);
		}
	}
}else{
	//ファイルがない場合
	printf("スケジュールを保存するファイルがありません。「" . $filename . "」が存在するか確認してください。");
}
?>
<p><a href="schedule_calender.php">カレンダーに戻る</a></p>
</table>
</body>
</html>

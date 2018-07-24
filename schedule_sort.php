<?php

// 動作確認コピペ用URL
// localhost/zzSCHEDULEzz/schedule_sort.php

$filename = "C:\\xampp\\htdocs\\zzSCHEDULEzz\\samplefile.txt";

if(file_exists($filename)){
	$schedule_list = file($filename);
		//$fp = fopen($filename, "w");
	$ar = 0;
	foreach($schedule_list as $key => $value){
		//print($key ."|". $value . "<br>");
		// UTF-8 BOM に注意
		//print($value . "<br>" . mb_substr($value, 0, 8) . "<br>");
		$schedule_sort[$key] = $value;
		//print_r($schedule_sort[$key] . "<br>");
		//print(mb_substr($value, 0, 8) . "<br>");
		$ar++;
		//print($ar . "<br>");
	}

	//配列が2個以上の時ソート処理にはいる
	if($ar >= 2){
		do{
			$sort_flag = 0;
			//$file_flag = 0;
			for($i=0; $i < $ar-1; $i++){
				//print_r($schedule_sort[$i] . "<br>");
				//var_dump(mb_substr($schedule_sort[$i], 0, 8));
				//var_dump(intval(mb_substr($schedule_sort[$i], 0, 8)));
				$comp1 = intval(mb_substr($schedule_sort[$i], 0, 8));
				$comp2 = intval(mb_substr($schedule_sort[$i+1], 0, 8));

				if($comp1 < $comp2){
					//print_r("i =".$i."ar =".$ar.":".$comp1."<".$comp2."<br>");
					$temp = $schedule_sort[$i];
					$schedule_sort[$i] = $schedule_sort[$i+1];
					$schedule_sort[$i+1] = $temp;
					$sort_flag++;
				}
			//動作確認表示部
			//print_r($schedule_sort[$i] . "<br>");
			}
			//動作確認表示部
			//print("<br><br>");
			//print($sort_flag);
			//配列をファイルに出力　ソート後の1回だけ出力したい
			//if($sort_flag == 1){
			//	file_put_contents($filename, print_r($schedule_sort));
			//}
		}while($sort_flag > 0);
		//Whileをぬけたときファイルに書き出し
		$fp = fopen($filename, "w");
		flock($filename,LOCK_EX);
		foreach ($schedule_sort as $sd){
			fputs($fp, $sd);
		}
		flock($filename,LOCK_UN);
		fclose($fp);
	}
	header("Location: http://localhost/zzSCHEDULEzz/schedule_list.php?all=1");
	exit;
}else{
	printf("スケジュールを保存するファイルがありません。「" . $filename . "」が存在するか確認してください。");
}

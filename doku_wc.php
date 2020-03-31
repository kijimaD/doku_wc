<!-- <script src="js/jquery-3.3.1.min.js"></script> -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
 google.charts.load("current", {packages:["calendar"]});
 google.charts.setOnLoadCallback(drawChart);

 function drawChart() {
	 var dataTable = new google.visualization.DataTable();
	 dataTable.addColumn({ type: 'date', id: 'Date' });
	 dataTable.addColumn({ type: 'number', id: 'Won/Loss' });
	 dataTable.addRows([
		 <?php
		 $file = '/home/kijima9791/a9ne.com/public_html/wiki/data/doku_wc/wc.csv';
		 if (($fp = fopen($file, 'r')) !== FALSE){
			 $row = 0;

			 while (($line = fgetcsv($fp)) !== FALSE){
				 if ($row == 0){
					 $row++;
					 continue;
				 }
				 if(empty($prev_wc)){
					 $diff_wc = 0;
				 }else{
					 $cur_wc = (int)$line[3];
					 $diff_wc = $cur_wc - $prev_wc;
				 }
				 $fix_month = $line[1] - 1;
				 echo '[new Date('.$line[0].','.$fix_month.','.$line[2].'),'.$diff_wc.'],';
				 /* echo '[new Date('.$line[0].','.$line[1].','.$line[2].'),'.$diff_wc.'],'; */
				 $row++;
				 $prev_wc = (int)$line[3];
			 }
		 }else{
			 echo $file.'load failed.';
		 }
		 fclose($fp);
		 ?>
	 ]);

	 var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

	 var options = {
		 title: "WORD COUNTER<?php echo '(ALL:' . $cur_wc . ')';?>",
		 calendar: { cellSize: 8 },
	 };

	 chart.draw(dataTable, options);
 }
</script>

<div id="calendar_basic" style="width: 1000px; height: 100px;"></div>
<small>
</small>

<!-- <p>
	 <?php
	 $file = '/home/kijima9791/a9ne.com/public_html/wiki/data/wc.csv';
	 if (($fp = fopen($file, 'r')) !== FALSE){
	 $row = 0;

	 while (($line = fgetcsv($fp)) !== FALSE){
	 if ($row == 0){
	 echo 'タイトル:'.$line[0].'<br>';
	 $row++;
	 continue;
	 }
	 if(empty($prev_wc)){
	 $prev_wc = (int)$line[3];
	 }
	 echo $line[0].$line[1].$line[2].'文字数:'.$line[3].'<br>';
	 $cur_wc = (int)$line[3];
	 echo 'cur_wc:'.$cur_wc;
	 $diff_wc = $cur_wc - $prev_wc;
	 echo '<bold style="color:red;">'.$diff_wc.'</bold><br>';
	 $row++;

	 /* save previous word count */
	 $prev_wc = (int)$line[3];
	 }
	 }else{
	 echo $file.'の読み込みに失敗しました。';
	 }
	 fclose($fp);
	 ?>
	 </p> -->

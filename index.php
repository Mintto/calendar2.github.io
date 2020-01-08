<?php 
//  settings
$today = date("Y-n-j"); // Today Date 
$year = isset($_GET["year"]) ? $_GET["year"] : date("Y"); 
$month = isset($_GET["month"]) ? $_GET["month"] : date("m");
$date = "$year-$month"; // Date
$cnt = 0;
// list 
$month_list = ["January","February","March","April","May","June","July","August","September","October","November","December"]; // Month list
$week_list  = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"]; // week list 
$list = [];
// input 
$prev_year = date("Y-m",strtotime("$date -1 years"));
$next_year = date("Y-m",strtotime("$date +1 years"));
$prev_month = date("Y-m",strtotime("$date -1 months"));
$next_month = date("Y-m",strtotime("$date +1 months"));
// basic 
$first_date = date("$date-01");
$last_date = date("$date-").date("t",strtotime($first_date));
$prev_date = date("$prev_month-").date("t",strtotime("$prev_month"));

$first_w = date("w",strtotime($first_date));
$last_w = date("w",strtotime($last_date));
// prev
for($num = $first_w; $num > 0; $num--){
	$item = $list[floor($cnt/7)][] = (object)[];
	$item->day = date("t",strtotime($prev_date))-$num+1;
	$item->check = true;
	$item->date = $prev_month."-".$item->day;
	$cnt++;
}
// list
for($num = 1; $num < date("d",strtotime($last_date))+1; $num++){
	$item = $list[floor($cnt/7)][] = (object)[];
	$item->day = $num;
	$item->check = false;
	$item->date = $date."-".$item->day;
	$cnt++;
}
// next 
for($num = $cnt,$i = 1; $num < 42; $num++,$i++){
	$item = $list[floor($cnt/7)][] = (object)[];
	$item->day = $i;
	$item->check = true;
	$item->date = $next_month."-".$item->day;
	$cnt++;
}
$arr = (object)["test1" => "asd"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		*{ margin:0; padding:0; list-style: none; text-decoration: none; font-family: "나눔고딕"; user-select: none;}
		html,body{ width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; }
		input[type="submit"]{ background: transparent; border:0; }
		#calendar{ width: 1200px; height: 650px; display: flex; box-shadow: 3px 3px 25px #e64848;}
		#calendar #menu{ position: relative; z-index: 10; display: flex; flex-direction: column; background: #e64848; width: 250px; height: 100%; color:#fff; box-shadow: 3px 3px 25px #e64848;}
		#calendar #menu .year{ display: flex; justify-content: center; align-items: center; width: 100%; height: 70px;}
		#calendar #menu .year h2{ margin:0 35px; }
		#calendar #menu .year form input[type="submit"]{ color:#fff;  font-size: 22px; cursor: pointer;}
		#calendar #menu .month{ flex:1; }
		#calendar #menu .month ul{ display: flex; flex-direction: column; padding:0 50px; height: 100%; }
		#calendar #menu .month ul li{ flex:1; }
		#calendar #menu .month ul li a{ color:#fff; display: flex; justify-content: space-between; align-items: center; font-size: 15px;}
		#calendar #menu .month ul li.active a{ font-weight: bold; color:#fff; font-size:17px; }
		#calendar #date{ position: relative; flex:1; background: #fff; padding:70px 120px 100px 40px;}
		#calendar #date table{ width: 100%; height: 100%; text-align: center; table-layout: fixed;}
		#calendar #date table *{ table-layout: fixed; }
		#calendar #date table caption{ font-size:22px; line-height: 60px; font-weight: bold; color:#e64848; letter-spacing: 3.25px;}
		#calendar #date table thead td{ font-weight: bold; }
		#calendar #date table tbody tr{ height: 40px; }
		#calendar #date table tbody tr td:first-child{ color:red; }
		#calendar #date table tbody tr td:last-child{ color:blue; }
		#calendar #date table tbody td{ width: 40px; height: 40px; font-size: 25px; font-weight: 400; color:gray; }
		#calendar #date table tbody td.check{ opacity: 0.5; }
		#calendar #date table tbody td.today{ font-weight: bold; color:#e64848; }
		#calendar #date .arrow{ position: absolute; right: 0; top:0; width: 120px; height: 60px; display: flex;  }
		#calendar #date .arrow form{ flex:1; }
		#calendar #date .arrow form input[type="submit"]{ width: 100%; height: 100%; background:#e64848; box-shadow: 2px 2px 10px #e64848; color:#fff; font-weight: bold; font-size:25px;}
		#calendar #date .arrow form:not(:first-child){ border-left:1px solid #ff6c6c; }
	</style>
</head>
<body>
	<main id="calendar">	
		<section id="menu">
			<article class="year">
				<form action="index.php" method="GET" name="prev_year">
					<input type="hidden" name="year" value="<?= date("Y",strtotime($prev_year)) ?>">
					<input type="hidden" name="month" value="<?= date("n",strtotime($prev_year)) ?>">
					<input type="submit" value="<">
				</form>
				<h2><?= $year ?></h1>
				<form action="index.php" method="GET" name="next_year">
					<input type="hidden" name="year" value="<?= date("Y",strtotime($next_year)) ?>">
					<input type="hidden" name="month" value="<?= date("n",strtotime($next_year)) ?>">
					<input type="submit" value=">">
				</form>
			</article>
			<article class="month">
				<ul>
					<?php foreach ($month_list as $idx => $v): ?>
						<li <?php if( $idx == date("n",strtotime($date))-1 ){
							echo "class='active' ";
						}  ?>>
						<a href="index.php?year=<?= $year ?>&month=<?= $idx+1 ?>">
							
							<span><?= $v ?></span>
							<span><?= $idx+1 ?></span>
						</a>
						</li>
					<?php endforeach ?>
				</ul>
			</article>
		</section>
		<section id="date">
			<table>	
				<caption><?= $month_list[date("n",strtotime($date))-1]; ?></caption>
				<thead>	
					<tr>
						<?php foreach ($week_list as $v): ?>
							<td><?= $v ?></td>
						<?php endforeach ?>
					</tr>
				</thead>
				<tbody>	
					<?php foreach ($list as $v) : ?>
						<tr>
							<?php 	foreach ($v as $j) : ?>
								<td <?php if( $j->check && $j->date == $today ){
									echo "class='check today'";
								}else if( $j->check ){
									echo "class='check'";
								}else if( $j->date == $today){
									echo "class='today'";
								} ?> ><?= $j->day ?></td>
							<?php 	endforeach ?>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<div class="arrow">
				<form action="index.php" method="GET" name="prev_month">
					<input type="hidden" name="year" value="<?= date("Y",strtotime($prev_month)) ?>">
					<input type="hidden" name="month" value="<?= date("n",strtotime($prev_month)) ?>">
					<input type="submit" value="<">
				</form>
				<form action="index.php" method="GET" name="next_month">
					<input type="hidden" name="year" value="<?= date("Y",strtotime($next_month)) ?>">
					<input type="hidden" name="month" value="<?= date("n",strtotime($next_month)) ?>">
					<input type="submit" value=">">
				</form>
			</div>
		</section>
	</main>
	<script>
		document.addEventListener("keydown",function(e){
			switch(e.keyCode){
				case 38:
				document.forms.prev_month.submit();
				break;
				case 39:
				document.forms.next_year.submit();
				break;
				case 40:
				document.forms.next_month.submit();
				break;
				case 37:
				document.forms.prev_year.submit();
				break;
			}
		})
	</script>
</body>
</html>
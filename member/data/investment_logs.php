<?php
include('../security_web_validation.php');
?>
<?php
session_start();
include("condition.php");
include("function/setting.php");
include("function/logs_messages.php");
?>
<!--<h1 align="left">Investment History</h1>-->
<?php

$newp = $_GET['p'];
$plimit = "15";

$user_id = $_SESSION['mlmproject_user_id'];
if($newp == '')
{
	$title = 'Display';
	$message = 'Display Investment Logs';
	data_logs($user_id,$title,$message,0);
}


$query = query_execute_sqli("select * from logs where user_id = '$user_id' and type = '$log_type[5]' ");
$totalrows = mysqli_num_rows($query);
if($totalrows != 0)
{
	print "<table id=\"data-table\" class=\"display\" align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 width=96%>
			<tr><td class=\"message tip\" height=30px style=\"text-align:center;\"><strong>Date</strong></td>
				<td class=\"message tip\" style=\"text-align:center;\"><strong>Title</strong></td>
				<td class=\"message tip\" style=\"text-align:center;\"><strong>Massage</strong></td></tr>";
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }  
				
	$query = query_execute_sqli("select * from logs where user_id = '$user_id' and type = '$log_type[5]' LIMIT $start,$plimit ");			
	while($row = mysqli_fetch_array($query))
	{
		$title = $row['title'];
		$message = $row['message'];
		$date = $row['date'];
		print  "<tr class=\"odd\"><td style=\"text-align:center;\"><small>$date</small></td>
					<td style=\"text-align:center;\"><small>$title</small></td>
					<td width=200 style=\"padding-left:30px\"><small>$message</small></td></tr>";
	}
	print "<tr><td colspan=4>&nbsp;</td></tr><tr class=\"odd\"><td colspan=4 height=30px width=400><strong>";
		if ($newp>1)
		{ ?>
			<a href="<?php echo "index.php?page=investment_logs&p=".($newp-1);?>">&laquo;</a>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<a href="<?php echo "index.php?page=investment_logs&p=$i";?>"><?php print_r("$i");?></a>
				<?php 
			}
			else
			{
				 print_r("$i");
			}
		} 
		if ($newp<$pnums) 
		{ ?>
		   <a href="<?php echo "index.php?page=investment_logs&p=".($newp+1);?>">&raquo;</a>
		<?php 
		} 
		print"</strong></td></tr></table>";

}
else { print "<tr><td colspan=\"3\" width=200>There is no logs !</td></tr></table>"; }


?>

<?php
include('../security_web_validation.php');
?>
<?php
session_start();
include("config.php");
include("condition.php");
include("function/setting.php");
include("function/all_month.php");	
include("function/logs_messages.php");
?>
<h1 align="left">Financial Logs</h1>
<?php

$user_id = $_SESSION['mlmproject_user_id'];
$query = query_execute_sqli("select * from logs where user_id = '$user_id' and type = '$type_data[1]' ");
$num = mysqli_num_rows($query);
if($num != 0)
{
	print "<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 width=600>
			<tr><td width=200 class=\"td_title\"><strong>Date</strong></td>
				<td width=200 class=\"td_title\"><strong>Title</strong></td>
				<td width=200 class=\"td_title\"><strong>Massage</strong></td></tr>";
	while($row = mysqli_fetch_array($query))
	{
		$title = $row['title'];
		$message = $row['message'];
		$date = $row['date'];
		print  "<tr><td width=200><small>$date</small></td>
					<td width=200><small>$title</small></td>
					<td width=200><small>$message</small></td></tr>";
	}
	print"</table>";	
}
else { print "<tr><td colspan=\"3\" width=200 class=\"td_title\">There is no logs !</td></tr></table>"; }


?>

<?php
$connection = mysql_connect ("us-cdbr-east-05.cleardb.net", "ba5548025ab0cf", "77629da0"); // Establishing Connection with Server
$db = mysql_select_db("heroku_31b4d4c9a218988", $connection); // Selecting Database
//MySQL Query to read data
$query = mysql_query("select * from etablissements", $connection);
while ($row = mysql_fetch_array($query)) {
	echo "{$row['name']}";
}
?>
			<?php
if (isset($_GET['id'])) {
$id = $_GET['id'];
$query1 = mysql_query("select * from etablissements where etaid=$id", $connection);
while ($row1 = mysql_fetch_array($query1)) {
?>
				<div class="form">
					<h2>---Details---</h2>
					<!-- Displaying Data Read From Database -->
					<span>Name:</span>
					<?php echo $row1['name']; ?>
				</div>
			<?php
}
}
?>
<?php
mysql_close($connection); // Closing Connection with Server
?>
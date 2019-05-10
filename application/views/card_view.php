<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		h1 { text-align: center; 	font-family: Calibri; }
	</style>

<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

</head>
<body>

<h1>ID Cards</h1>
    <div>
	<center>
<!--		<form action="<?php echo site_url('main/expireTeam')?>" method="post">
			Select team: <?php
			mysql_select_db('wecan');
			$result = mysql_query("SELECT teamname FROM team");
			echo "<select name='expireTeam' required>";
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='". $row['teamname']."'>". $row['teamname']."</option>";
			}
			echo "</select>";
			?> 
<button type="submit">Expire whole team</button>
</form>
<br>
<br>

		<form action="<?php echo site_url('main/expireMember')?>" method="post">
			<input type="text" name="expireMember" autocomplete="on" list="expireMember" placeholder="Enter card number" required>
			<?php
			mysql_select_db('wecan');
			$result = mysql_query("SELECT idcard FROM card");
			echo "<datalist id='expireMember'>";
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='". $row['idcard']."'>". $row['idcard']."</option>";
			}
			echo "</datalist>";
			?>
		<button type="submit">Expire single member</button>
		<br>
		</form>//-->

</center>
		<?php echo $output; ?>
    </div>
</body>
</html>

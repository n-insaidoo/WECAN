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

<h1>Expire entire team</h1><br><br>
    <div>
	<center>
		<form action="<?php echo site_url('main/expireTeam')?>" method="post">
			Select team: <?php
			mysql_select_db('wecan');
			$result = mysql_query("SELECT teamname FROM team");
			echo "<select name='expireTeam' required>";
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='". $row['teamname']."'>". $row['teamname']."</option>";
			}
			echo "</select>";
			?> <br>
<button type="submit">Expire whole team</button>
</form>
<br>
<br>

</center>
		<?php echo $output; ?>
    </div>
</body>
</html>

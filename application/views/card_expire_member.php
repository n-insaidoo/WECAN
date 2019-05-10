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

<h1>Expire single member</h1><br><br>
    <div>
	<center>
		<form action="<?php echo site_url('main/expireMember')?>" method="post">
			<input type="text" name="expireMember" autocomplete="on" list="expireMember" placeholder="Enter card number" required>
			<?php
			mysql_select_db('wecan');
			$result = mysql_query("SELECT i.idcard , c.competitorname FROM CARD i, competitor c WHERE i.competitor_idcompetitor = c.idcompetitor");
			//$result = mysql_query("SELECT idcard FROM card");
			echo "<datalist id='expireMember'>";
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='". $row['idcard']."'>". $row['idcard']."  (". $row['competitorname'].")</option>";
			}
			echo "</datalist>";
			?><br>
		<button type="submit">Expire single member</button>
		<br>
		</form>
<br>
<br>

</center>
		<?php echo $output; ?>
    </div>
</body>
</html>

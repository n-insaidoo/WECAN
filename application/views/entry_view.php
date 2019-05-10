<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		h1 { text-align: center; 	font-family: Calibri; }
	</style>

   <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>  
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>  
   <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script> 

   <script type="text/javascript">
       $(function() {
               $("#date").datepicker({ dateFormat: "dd/mm/yy" }).val()
       });
   </script>
      <style>
.ui-datepicker {font-size:75%; }
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
<br><br>
<center><h2>Attempt entry</h2></center>



<div align='center'>
	
			<form action="<?php echo site_url('main/entry_query1')?>" method="post" ">
			Enter card number: <input type="text" name="idcard" autocomplete="on" list="idcard" placeholder="Enter card number" required>
			<?php
			mysql_select_db('wecan');
			$result = mysql_query("SELECT i.idcard , c.competitorname FROM CARD i, competitor c WHERE i.competitor_idcompetitor = c.idcompetitor");
			//$result = mysql_query("SELECT idcard FROM card");
			echo "<datalist id='idcard'>";
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='". $row['idcard']."'>". $row['idcard']."  (". $row['competitorname'].")</option>";
			}
			echo "</datalist>";
			?><br>
			
			Select venue:<?php
			mysql_select_db('wecan');
			$result = mysql_query("SELECT * FROM venue");
			echo "<select name='venue' required>";
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='". $row['stadiumname']."'>". $row['stadiumname']." (". $row['stadiumloc'].")</option>";
			}
			echo "</select>";
			?><br>
			Enter match date: <input type="text" id="date" name="date" placeholder="Enter date" required > <br> <br>
			<button type="submit">Check Authorisation</button>
			</form>
<br>
</div>
<h1>Entry Log</h1>
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>

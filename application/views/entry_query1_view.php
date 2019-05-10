<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	   <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>  
   <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>  
   <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script> -->
     <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<div style="text-align:center;">
<div class="container">
<div class="ae_loading">
<img src="/wecan/assets/images/blob.gif" />
<div class="ae_status"></div>
</div>
<div style="padding: 45px;padding-top: 0;">
<h1>Attempt entry</h1>

			<form action="<?php echo site_url('main/entry_query1')?>"  onsubmit="event.preventDefault(); ajax_call();">
			<input type="text" name="idcard" autocomplete="on" list="idcard" placeholder="Enter card number" required>
			<?php
			mysql_select_db('wecan');
			$result = mysql_query("SELECT i.idcard , c.competitorname FROM CARD i, competitor c WHERE i.competitor_idcompetitor = c.idcompetitor");
			echo "<datalist id='idcard'>";
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='". $row['idcard']."'>". $row['idcard']."  (". $row['competitorname'].")</option>";
			}
			echo "</datalist>";
			?><br>
			
			<?php
			mysql_select_db('wecan');
			$result = mysql_query("SELECT * FROM venue");
			echo "<select name='venue' placeholder='Select venue' required>";
			while ($row = mysql_fetch_array($result)) {
				echo "<option value='". $row['stadiumname']."'>". $row['stadiumname']." (". $row['stadiumloc'].")</option>";
			}
			echo "</select>";
			?><br>
			<input type="text" id="date" name="date" placeholder="Enter date" required >
            </div>
			</div>
 <div style="text-align:center;margin-top:15px;">           
<button id="check_auth" type="submit"></button>
<p class="txt_msg">Fill in your credentials and press the above button</p>
</div>
			</form>


</div>
</body>
</html>

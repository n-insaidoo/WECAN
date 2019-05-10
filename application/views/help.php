<!DOCTYPE HTML>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<html>
<head><center>
<h1><u> FAQ Section</u> </h1>
<style type="text/css">
 .FAQ { cursor:pointer; }
 .FAA { display:none; border-bottom:medium solid red; }
 .MoreLess { font-size:2em; font-weight:bold; color:red; }
</style>

</head>
<body>
<br><br><br>
<h3>

<dl id="FAQlist" style="width:50%">

 <dt class="FAQ" onclick="toggle('faq1')" onkeypress="checkEnter(event,'faq1')" tabindex="1">
   <span id="faq1Char" class='MoreLess'>+</span> How to add a new competitor?
 </dt>
 <dd id="faq1" class="FAA">Navigate to the competitors page first, then on that page you will see a button on the top left called "Add competitor." Once that is pressed you should see an entry form with all the specified entries needed for the addition of a new competitor</dd>

 <dt class="FAQ" onclick="toggle('faq2')" onkeypress="checkEnter(event,'faq2')" tabindex="2">
   <span id="faq2Char" class='MoreLess'>+</span> How do I add a new team?
 </dt>
 <dd id="faq2" class="FAA">To add a new team, navigate to the Team page, and press the Add team button on the top left. Now enter the fields require to add a new team to the competition.</dd>
    <dt class="FAQ" onclick="toggle('faq9')" onkeypress="checkEnter(event,'faq9')" tabindex="9">
   <span id="faq9Char" class='MoreLess'>+</span> How to add a venue?
 </dt>
 <dd id="faq9" class="FAA"> Navigate to the venues page and press the add venue button on the top left. Enter the details required and you will have a new venue in your WECAN system.</dd>

 <dt class="FAQ" onclick="toggle('faq3')" onkeypress="checkEnter(event,'faq3')" tabindex="3">
   <span id="faq3Char" class='MoreLess'>+</span> How to add a new card?
 </dt>
 <dd id="faq3" class="FAA">* Card management for the main part is done automatically. Once a new competitor is created a new card is automatically created for them without any user input. See the ID cards page for more.

If you want to replace a lost/stolen/damage ID card there is a specific page to do this under ID cards. This will cancel the old card and reissue another one with the same authorisations.</dd>

 <dt class="FAQ" onclick="toggle('faq4')" onkeypress="checkEnter(event,'faq4')" tabindex="4">
   <span id="faq4Char" class='MoreLess'>+</span> How to deny access to a competitor?
 </dt>
 <dd id="faq4" class="FAA">Authorisation is dealt with automatic and displayed on the authorization page. The system checks if the card ID is valid, and whether that person has a match in the venue. With this information, it will display whether they have access or not (Allowed/denied.)

To deny access you must set their card to expired.</dd>

 <dt class="FAQ" onclick="toggle('faq5')" onkeypress="checkEnter(event,'faq5')" tabindex="5">
   <span id="faq5Char" class='MoreLess'>+</span> How do I deny/ authorize access to a whole team?
 </dt>
 <dd id="faq5" class="FAA"> To do this under the ID cards navigation menu, there is a subpage called expire entire team. On this page, there will be an entry drop down with a list of teams, select the team you want to expire and press submit. Now all members of that teams ID cards will be set to expired.</dd>

 <dt class="FAQ" onclick="toggle('faq6')" onkeypress="checkEnter(event,'faq6')" tabindex="6">
   <span id="faq6Char" class='MoreLess'>+</span> How do I add a match?
 </dt>
 <dd id="faq6" class="FAA"> To add a match, simply click on the ‘matches’ tab in the navigation menu. Then, click the ‘Add matches’ button at the top of the page and then fill in the details about the match. Finally, hit the ‘save’ button at the bottom to save.</dd>

  <dt class="FAQ" onclick="toggle('faq7')" onkeypress="checkEnter(event,'faq7')" tabindex="7">
   <span id="faq7Char" class='MoreLess'>+</span> How to check authorisation of every competitor?
 </dt>
 <dd id="faq7" class="FAA"> In the navigation menu, click on the ‘authorisations’ tab. This shows all the competitors and gives some details. Additionally, you can press the ‘view’ button to preview a single entity in more detail.</dd>

   <dt class="FAQ" onclick="toggle('faq8')" onkeypress="checkEnter(event,'faq8')" tabindex="8">
   <span id="faq8Char" class='MoreLess'>+</span> What does the ‘search’ function do? 
 </dt>
 <dd id="faq8" class="FAA"> There are 2 search features in our system. The first is a global search which searches the entire table for a specific element. For example, if you search ‘27’ in competitors, it will find every field that includes the number 27.The other search is similar to the global search however instead of searching the entire table, it searches a specific column in the table.</dd>

    <dt class="FAQ" onclick="toggle('faq10')" onkeypress="checkEnter(event,'faq10')" tabindex="10">
   <span id="faq10Char" class='MoreLess'>+</span> How do you mimic entry on the system?
 </dt>
 <dd id="faq10" class="FAA"> Navigate to the entry options button on the navigation bar, and then on the drop down which shows a drop down menu including attempt entry. Navigate to the attempt entry page and enter the card ID, venue and entry date into the form. Press the arrow which will then either show access denied or access allowed.</dd>

     <dt class="FAQ" onclick="toggle('faq10')" onkeypress="checkEnter(event,'faq10')" tabindex="10">
   <span id="faq10Char" class='MoreLess'>+</span> How to view attempted entries?
 </dt>
 <dd id="faq10" class="FAA"> Navigate to the entry options button on the navigation bar, and then on the drop down which shows a drop down menu including entry logs. Navigate to the entry logs page, which will show all atempted entries on a table. From here you can narrow down your search by searching for card IDs etc.</dd>

 </dl>
</h3>

<script type="text/javascript">
// Modified from: http://codingforums.com/javascript-programming/236311-faq-drop-down-when-q-clicked-2.html
// Modified again for ability to link somewhere in answer section of FAQ
// and added TAB and ENTER to show/hide FAA sections

function toggle(Info) {
  var CState = document.getElementById(Info);
  CState.style.display = (CState.style.display != 'block') ? 'block' : 'none';
  if (CState.style.display == 'none') { document.getElementById(Info+'Char').innerHTML = '+'; }
  else { document.getElementById(Info+'Char').innerHTML = '-'; }
}

// Following from: http://stackoverflow.com/questions/12788554/onkeypress-enter-event-not-firing
function checkEnter(evt,IDS) {  if (evt.keyCode === 13) {  toggle(IDS); } } // Handle key press event here

</script>
</body>
</html>  
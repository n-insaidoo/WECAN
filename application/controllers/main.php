<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$header = "
<script src='/wecan/assets/scripts/jquery-3.1.1.min.js' type='text/javascript'></script>
<script src='/wecan/assets/scripts/scripts.js' type='text/javascript'></script>
   <link href='/wecan/assets/stylesheets/style.css' type='text/css' rel='stylesheet' />
   ";

class Main extends CI_Controller {
	 
	 function __construct()
	{
		parent::__construct();	 
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
		$this->load->library('table');
	}
	
	public function index()
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$this->load->view('home');
	}
	

	
	//WECAN STARTS HERE*********************************
	
		public function competitor()
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		
		//table name exact from database
		$crud->set_table('competitor');
		
		//give focus on name used for operations e.g. Add Order, Delete Order
		$crud->set_subject('Competitor');
		$crud->columns('idcompetitor', 'competitortitle_title', 'competitorname','team_teamname','role');
		$crud->fields('competitortitle_title', 'competitorname','team_teamname','role');
		
		//set the foreign keys to appear as drop-down menus
		// ('this fk column','referencing table', 'column in referencing table')
		$crud->set_relation('competitortitle_title','competitortitle','title');
		$crud->set_relation('team_teamname','team','teamname');
		
		//form validation (could match database columns set to "not null")
		$crud->required_fields('idcompetitor','competitortitle_title', 'team_teamname', 'competitorname','role');
		$crud->set_rules('competitorname','Competitor name','trim|alpha_numeric_spaces');
		$crud->set_rules('role','Role','trim|alpha_numeric_spaces');
		$crud->unique_fields(array('competitorname'));
		//change column heading name for readability ('columm name', 'name to display in frontend column header')
		$crud->display_as('idcompetitor', 'Competitor ID');
		$crud->display_as('competitortitle_title', 'Competitor Title');
		$crud->display_as('competitorname', 'Competitor Name');
		$crud->display_as('team_teamname', 'Team name');
		
		$crud->callback_after_insert(array($this, 'card_after_insert'));
		$crud->callback_after_update(array($this, 'card_after_update'));
		$crud->callback_after_delete(array($this,'card_after_delete'));
		
		$output = $crud->render();
		$this->competitor_output($output);
	}
	//ADD ID CARDS AUTOMATICALLY**************************************************
	function card_after_insert($post_array,$primary_key)
	{
		$card_insert = array("competitor_idcompetitor" => $primary_key,"cardstate_state" => 'Valid');
 
		$this->db->insert('card',$card_insert);
 
		return true;
	}

	function card_after_update($post_array,$primary_key)
	{
		$card_insert = array("competitor_idcompetitor" => $primary_key,"cardstate_state" => 'Valid');
 
		$this->db->update('card',$card_insert,array('competitor_idcompetitor' => $primary_key));
 
		return true;
	}

	
	public function card_after_delete($primary_key)
	{
		return $this->db->delete('card',array('competitor_idcompetitor' => $primary_key));
	}
	//ENDS HERE*********************************
	
	
	
	function competitor_output($output = null)
	{
		//this function links up to corresponding page in the views folder to display content for this table
		$this->load->view('competitor_view.php', $output);
	}
	
	
		public function venue()
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('venue');
		$crud->set_subject('Venues');
		$crud->columns('idvenue','stadiumname', 'stadiumloc');
		$crud->fields('stadiumname', 'stadiumloc');
		$crud->required_fields('idvenue', 'stadiumname', 'stadiumloc');
		$crud->display_as('idvenue', 'Venue');
		$crud->display_as('stadiumname', 'Stadium name');
		$crud->display_as('stadiumloc', 'Stadium location');
		
		$crud->set_rules('stadiumname','Stadium name','trim|alpha_numeric_spaces');
		$crud->set_rules('stadiumloc','Stadium location','trim|alpha_numeric_spaces');
		
		$output = $crud->render();
		$this->venue_output($output);
	}
	
	function venue_output($output = null)
	{
		$this->load->view('venue_view.php', $output);
	}
	
	public function match()
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		
		//table name exact from database
		$crud->set_table('match');
		
		//give focus on name used for operations e.g. Add Order, Delete Order
		$crud->set_subject('Matches');
		$crud->columns('matchno', 'venue_idvenue', 'matchdate','team1','team2');
		$crud->fields('matchno','venue_idvenue', 'matchdate','team1','team2'); //taken auth out for now
		
		//set the foreign keys to appear as drop-down menus
		// ('this fk column','referencing table', 'column in referencing table')
		//$crud->set_relation('venue_idvenue','venue','{idvenue} - {stadiumname}');
		$crud->set_relation('team1','team','teamname');
		$crud->set_relation('team2','team','teamname');
		$crud->set_relation('venue_idvenue','venue','{stadiumname} in {stadiumloc}');
		//$crud->set_relation('team_teamid','team','{teamid} - {teamname}');
		//many-to-many relationship with link table see grocery crud website: www.grocerycrud.com/examples/set_a_relation_n_n
		//('give a new name to related column for list in fields here', 'join table', 'other parent table', 'this fk in join table', 'other fk in join table', 'other parent table's viewable column to see in field')
		//$crud->set_relation_n_n('items', 'order_items', 'items', 'invoice_no', 'item_id', 'itemDesc');
		$crud->set_relation_n_n('auth', 'authorisation', 'card', 'match_matchno', 'card_idcard', 'competitor_idcompetitor');

		//form validation (could match database columns set to "not null")
		$crud->required_fields('matchno', 'venue_idvenue', 'matchdate','team1','team2');
		
		//change column heading name for readability ('columm name', 'name to display in frontend column header')
		$crud->display_as('matchno', 'Match Number');
		$crud->display_as('venue_idvenue', 'Stadium');
		$crud->display_as('matchdate', 'Match Date');
		$crud->display_as('team1', 'Team 1 name');
		$crud->display_as('team2', 'Team 2 name');
				
		$crud->unique_fields(array('matchno'));
		$crud->set_rules('matchno','match number','numeric');
		$crud->set_rules('team1','team 1','alpha');
		$crud->set_rules('team2','team 2','alpha');
		
		$output = $crud->render();
		$this->match_output($output);
	}
	
	function match_output($output = null)
	{
		//this function links up to corresponding page in the views folder to display content for this table
		$this->load->view('match_view.php', $output);
	}
	
			public function team()
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('team');
		$crud->set_subject('Team');
		$crud->columns('teamname', 'nfa', 'acronym', 'nickname');
		$crud->fields('teamname', 'nfa', 'acronym', 'nickname');
		$crud->required_fields('teamname', 'nfa', 'acronym');
		$crud->display_as('teamname', 'Team Name');
		$crud->display_as('nfa', 'National Football association');
		$crud->display_as('acronym', 'Team acronym');
		
		$crud->set_rules('teamname','team name','alpha');
		$crud->set_rules('nfa','NFA','trim|alpha_numeric_spaces');
		$crud->set_rules('acronym','acronym','trim|alpha_numeric_spaces');
		$crud->set_rules('nickname','nickname','trim|alpha_numeric_spaces');
		$crud->unique_fields(array('teamname'));
		$output = $crud->render();
		$this->team_output($output);
	}
	
	function team_output($output = null)
	{
		$this->load->view('team_view.php', $output);
	}

	
	public function card()
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('card');
		$crud->set_subject('ID Cards');
		$crud->columns('idcard','competitor_idcompetitor','team_name', 'startdate', 'enddate', 'cardstate_state');
		$crud->fields('competitor_idcompetitor', 'cardstate_state');
		$crud->required_fields('idcard','competitor_idcompetitor', 'startdate', 'enddate', 'cardstate_state');
		$crud->display_as('idcard', 'Card ID');
		$crud->display_as('competitor_idcompetitor', 'Competitor');
		$crud->display_as('startdate', 'Start date');
		$crud->display_as('enddate', 'End date');
		$crud->display_as('cardstate_state', 'Card state');
		$crud->edit_fields('cardstate_state');
		$crud->set_relation('competitor_idcompetitor','competitor','{idcompetitor} - {competitorname}');
		$crud->set_relation('cardstate_state','cardstate','state');
		$crud->callback_column('team_name',array($this,'getcardTeam'));
		$crud->add_action('Toggle Card State', '', 'main/toggle','ui-icon-transfer-e-w','');
		$crud->unset_edit();
		$crud->unset_delete();
		$output = $crud->render();
		$this->card_output($output);
	}
		function getcardTeam($value, $row) {
        //$sql = "select co.competitorname from authorisation as a, competitor as co, card as c where c.idcard = a.card_idcard and c.competitor_idcompetitor = co.idcompetitor";
		$sql = 'SELECT c.team_teamname FROM competitor c, card e WHERE c.idcompetitor = "'.$row->competitor_idcompetitor.'"';
		$result = $this->db->query($sql)->row()->team_teamname;
        return $result;
		}
		
		function toggle($primary_key) {
		$sql = 'UPDATE card SET cardstate_state = CASE WHEN cardstate_state = "Valid" THEN "Expired" WHEN cardstate_state = "Expired" THEN "Valid" ELSE "Valid" END WHERE idcard = '.$primary_key;
		$result = $this->db->query($sql);
		redirect('main/card','refresh'); 
		}
	
	function card_output($output = null)
	{
		$this->load->view('card_view.php', $output);
	}
	
/*		public function authorisation()
	{	
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		
		//table name exact from database
		$crud->set_table('authorisation');
		
		//give focus on name used for operations e.g. Add Order, Delete Order
		$crud->set_subject('Authorisations');
		$crud->columns('match_matchno','team1vsteam2','card_idcard','competitorname');
		$crud->fields('card_idcard','match_matchno');
		//('give a new name to related column for list in fields here', 'join table', 'other parent table', 'this fk in join table', 'other fk in join table', 'other parent table's viewable column to see in field')
		//form validation (could match database columns set to "not null")
		$crud->required_fields('card_idcard', 'match_matchno');

		//change column heading name for readability ('columm name', 'name to display in frontend column header')
		$crud->display_as('card_idcard', 'Card ID');
		$crud->display_as('match_matchno', 'Match number');
		$crud->display_as('competitorname', 'Competitor name');
		$crud->display_as('team1vsteam2', 'Match');
		
		$crud->callback_column('competitorname',array($this,'getName'));
		$crud->callback_column('team1vsteam2',array($this,'getTeam'));
		
		
		$output = $crud->render();
		$this->authorisation_output($output);
	}
	function getName($value, $row) {
        //$sql = "select co.competitorname from authorisation as a, competitor as co, card as c where c.idcard = a.card_idcard and c.competitor_idcompetitor = co.idcompetitor";
		$sql = 'SELECT competitorname FROM competitor WHERE idcompetitor = (SELECT competitor_idcompetitor FROM card WHERE idcard ="'.$row->card_idcard.'")';
		$result = $this->db->query($sql)->row()->competitorname;
		//var_dump($row);
        return $result;
		}
		
		
	function getTeam($value, $row) {
        //$sql = "select co.competitorname from authorisation as a, competitor as co, card as c where c.idcard = a.card_idcard and c.competitor_idcompetitor = co.idcompetitor";
		$sql = 'SELECT team1,team2 FROM `match` as ma WHERE ma.matchno ="'.$row->match_matchno.'"';
		$result = $this->db->query($sql)->row()->team1 ." vs ". $this->db->query($sql)->row()->team2;
		//var_dump($row);
        return $result;
		}*/
	public function authorisation()
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		
		//table name exact from database
		$crud->set_table('authtest2');
		
		//give focus on name used for operations e.g. Add Order, Delete Order
		$crud->set_subject('Authorisations');
		$crud->columns('competitorname','idcard','team_teamname','matchno','stadiumname','stadiumloc','matchdate','Access');
		$crud->set_primary_key('idcard');
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();

		$crud->display_as('idcard', 'Card ID');
		$crud->display_as('team_teamname', 'Team name');
		$crud->display_as('competitorname', 'Competitor name');
		$crud->display_as('matchno', 'Match no.');
		$crud->display_as('stadiumname', 'Stadium name');
		$crud->display_as('stadiumloc', 'Stadium location');
		$crud->display_as('matchdate', 'Match date');
		$crud->display_as('Access', 'Access to venue');
		
		$output = $crud->render();
		$this->authorisation_output($output);
		$this->db->order_by("team_teamname", "asc");
	}
	function authorisation_output($output = null)
	{
		//this function links up to corresponding page in the views folder to display content for this table
		$this->load->view('auth_view.php', $output);
	}
	public function expireTeam() { 
		$item = $this->input->post('expireTeam');
		//$this->db->query('UPDATE items SET typeID = "1" where itemID ="'.$item.'"');
		$this->db->query('UPDATE card SET cardstate_state = "Expired" WHERE competitor_idcompetitor IN (SELECT idcompetitor FROM competitor WHERE team_teamname ="'.$item.'")');
		redirect('main/card_expireteam','refresh'); 
	}
	public function cancelMember() { 
		$item = $this->input->post('cancelMember');
		$this->db->query('INSERT into card(cardstate_state, competitor_idcompetitor) SELECT cardstate_state, competitor_idcompetitor FROM card WHERE idcard = "'.$item.'"');
		$this->db->query('UPDATE card SET cardstate_state = "Cancelled" WHERE idcard = "'.$item.'"');
		redirect('main/card_cancelmember','refresh'); 
	}
	
		public function expireMember() { 
		$item = $this->input->post('expireMember');
		$this->db->query('UPDATE card SET cardstate_state = "Expired" WHERE idcard = "'.$item.'"');
		redirect('main/card_expiremember','refresh'); 
	}

	
	
		public function entry()
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		
		//table name exact from database
		$crud->set_table('entry');
		
		//give focus on name used for operations e.g. Add Order, Delete Order
		$crud->set_subject('Entry Log');
		$crud->columns('card_idcard','compname','venue','date','access');
		$crud->unset_add();
		$crud->unset_edit();
		$crud->unset_delete();

		$crud->display_as('card_idcard', 'Card ID');
		$crud->display_as('venue', 'Stadium name');
		$crud->display_as('stadiumname', 'Stadium name');
		$crud->display_as('date', 'Entry attempt date');
		$crud->display_as('access', 'Access to venue');
		$crud->display_as('compname', 'Competitor name');
		$crud->callback_column('compname',array($this,'getCname'));
		
		$crud->order_by('entryno','asc');
		$output = $crud->render();
		$this->entry_output($output);
	}
	
		function getCname($value, $row) {

		$sql = 'SELECT competitorname FROM competitor WHERE idcompetitor = (SELECT competitor_idcompetitor FROM card WHERE idcard ="'.$row->card_idcard.'")';
		$result = $this->db->query($sql)->row()->competitorname;
		
        return $result;
		}
	
		function entry_output($output = null)
	{
		//this function links up to corresponding page in the views folder to display content for this table
		$this->load->view('entry_view.php', $output);
	}
	
	function attempt_entry($output = null)
	{
		//this function links up to corresponding page in the views folder to display content for this table
		echo $GLOBALS['header'];
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$this->load->view('entry_query1_view.php');
	}

	
		public function entry_query1()
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$idcard = $this->input->post('idcard');
		$venue = $this->input->post('venue');
		$date = $this->input->post('date');
		$date2 = $date;
		$date2 = str_replace('/', '-', $date2);
		$date3 = date('Y-m-d', strtotime($date2));
		$sql = 'SELECT IFNULL ((SELECT Access FROM authtest2 WHERE idcard = "'.$idcard.'" AND stadiumname = "'.$venue.'" AND matchdate = "'.$date3.'" ), "'.'Denied'.'") AS access';
		$access = $this->db->query($sql)->row()->access;
		$data = array('card_idcard'=>$idcard,'venue'=>$venue,'date'=>$date3, 'access'=>$access);
		$this->db->insert('entry',$data);
		redirect('main/entry','refresh'); 
		
		
	}
		public function card_expireteam($output = null)
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('card');
		$crud->set_subject('ID Cards');
		$crud->columns('idcard','competitor_idcompetitor','team_name', 'startdate', 'enddate', 'cardstate_state');
		$crud->fields('competitor_idcompetitor', 'cardstate_state');
		$crud->required_fields('idcard','competitor_idcompetitor', 'startdate', 'enddate', 'cardstate_state');
		$crud->display_as('idcard', 'Card ID');
		$crud->display_as('competitor_idcompetitor', 'Competitor');
		$crud->display_as('startdate', 'Start date');
		$crud->display_as('enddate', 'End date');
		$crud->display_as('cardstate_state', 'Card state');
		$crud->edit_fields('cardstate_state');
		$crud->set_relation('competitor_idcompetitor','competitor','{idcompetitor} - {competitorname}');
		$crud->set_relation('cardstate_state','cardstate','state');
		$crud->callback_column('team_name',array($this,'getcardTeam'));
		$crud->add_action('Toggle Card State', '', 'main/toggle','ui-icon-transfer-e-w','');
		$crud->unset_edit();
		$crud->unset_delete();
		$output = $crud->render();
		$this->load->view('card_expire_team.php', $output);
	}
	
			public function card_expiremember($output = null)
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('card');
		$crud->set_subject('ID Cards');
		$crud->columns('idcard','competitor_idcompetitor','team_name', 'startdate', 'enddate', 'cardstate_state');
		$crud->fields('competitor_idcompetitor', 'cardstate_state');
		$crud->required_fields('idcard','competitor_idcompetitor', 'startdate', 'enddate', 'cardstate_state');
		$crud->display_as('idcard', 'Card ID');
		$crud->display_as('competitor_idcompetitor', 'Competitor');
		$crud->display_as('startdate', 'Start date');
		$crud->display_as('enddate', 'End date');
		$crud->display_as('cardstate_state', 'Card state');
		$crud->edit_fields('cardstate_state');
		$crud->set_relation('competitor_idcompetitor','competitor','{idcompetitor} - {competitorname}');
		$crud->set_relation('cardstate_state','cardstate','state');
		$crud->callback_column('team_name',array($this,'getcardTeam'));
		$crud->add_action('Toggle Card State', '', 'main/toggle','ui-icon-transfer-e-w','');
		$crud->unset_edit();
		$crud->unset_delete();
		$output = $crud->render();
		$this->load->view('card_expire_member.php', $output);
	}
	public function card_cancelmember($output = null)
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('card');
		$crud->set_subject('ID Cards');
		$crud->columns('idcard','competitor_idcompetitor','team_name', 'startdate', 'enddate', 'cardstate_state');
		$crud->fields('competitor_idcompetitor', 'cardstate_state');
		$crud->required_fields('idcard','competitor_idcompetitor', 'startdate', 'enddate', 'cardstate_state');
		$crud->display_as('idcard', 'Card ID');
		$crud->display_as('competitor_idcompetitor', 'Competitor');
		$crud->display_as('startdate', 'Start date');
		$crud->display_as('enddate', 'End date');
		$crud->display_as('cardstate_state', 'Card state');
		$crud->edit_fields('cardstate_state');
		$crud->set_relation('competitor_idcompetitor','competitor','{idcompetitor} - {competitorname}');
		$crud->set_relation('cardstate_state','cardstate','state');
		$crud->callback_column('team_name',array($this,'getcardTeam'));
		$crud->add_action('Toggle Card State', '', 'main/toggle','ui-icon-transfer-e-w','');
		$crud->unset_edit();
		$crud->unset_delete();
		$output = $crud->render();
		$this->load->view('card_cancel_member.php', $output);
	}
	
	public function entry_query2()
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$this->load->view('entry_query2_view');
	}
	
		public function help()
	{	
		echo $GLOBALS['header'];
		$this->load->view('header');
		$this->load->view('help');
	}

	
}

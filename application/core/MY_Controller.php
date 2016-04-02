<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

	protected $data = array();   // parameters for view components
	protected $id; // identifier for our content

	/**
	 * Constructor.
	 * Establish view parameters & load common helpers
	 */

	function __construct()
	{
		parent::__construct();
		$this->data = array();
		$this->data['title'] = "Top Secret Government Site"; // our default title
		$this->errors = array();
		$this->data['pageTitle'] = 'welcome';   // our default page
	}

	/**
	 * Render this page
	 */
	function render()
	{
		$mychoices = array('menudata' => $this->makemenu());
		$this->data['menubar'] = $this->parser->parse('_menubar', $mychoices, true);
		$this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

		// finally, build the browser page!
		$this->data['data'] = &$this->data;
		$this->data['sessionid'] = session_id();
		$this->parser->parse('_template', $this->data);
	}

	// build menu choices depending on the user role
	function makemenu()
	{
		$role = $this->session->userdata('userRole');
		$name = $this->session->userdata('userName');
		$choice = array();

		if($role == null){
			$choice[] = array('name' => "Alpha", 'link' => '/alpha');
			$choice[] = array('name' => "Login", 'link' => '/auth');
		}
		if($role == "user" || $role == "admin"){
			$choice[] = array('name' => "Beta", 'link' => '/beta');
			$choice[] = array('name' => "Logout", 'link' => '/auth/logout');
		}
		if($role == "admin"){
			$choice[] = array('name' => "Gamma", 'link' => '/gamma');
		}
		if($role != null){
			$choice[] = array('name' => 'Currently logged in: ' . $name, 'link' => '');
		}
		return $choice;
	}

	function restrict($roleNeeded = null) {
		$userRole =
			$this->session->userdata('userRole');
		if ($roleNeeded != null) {
			if (is_array($roleNeeded)) {
				if (!in_array($userRole, $roleNeeded))
				{
					redirect("/");
					return;
				}
			} else if ($userRole != $roleNeeded) {
				redirect("/");
				return;
			}
		}
	}

}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */
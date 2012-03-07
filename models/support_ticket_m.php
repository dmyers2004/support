<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * A simple and purpose built ticket system
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Support Module
 */
class Support_ticket_m extends MY_Model {

	public $validate = array(
		array('field' => 'name',
			  'label' => 'Name',
			  'rules' => 'required|max_length[50]|strip_tags'
			  ),
		array('field' => 'title',
			  'label' => 'Ticket title',
			  'rules' => 'required|max_length[255]|strip_tags'
			  ),
		array('field' => 'description',
			  'label' => 'Description',
			  'rules' => 'required'
			  )
		);

	public function __construct()
	{		
		parent::__construct();
	}
}

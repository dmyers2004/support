<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Support extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Support'
			),
			'description' => array(
				'en' => 'A simple and specific support ticket module'
			),
			'frontend' => TRUE,
			'backend' => FALSE
		);
	}

	public function install()
	{
		$this->load->driver('streams');

		$fields = array(
		    array(
		        'name'          => 'Ticket Number',
		        'slug'          => 'number',
		        'namespace'     => 'support',
		        'type'          => 'integer',
		        'extra'         => array('max_length' => 10),
		        'assign'        => 'support_tickets',
		        'required'      => TRUE
		    ),
		    array(
		        'name'          => 'Name',
		        'slug'          => 'name',
		        'namespace'     => 'support',
		        'type'          => 'text',
		        'extra'         => array('max_length' => 50),
		        'assign'        => 'support_tickets',
		        'required'      => TRUE
		    ),
		    array(
		        'name'          => 'Title',
		        'slug'          => 'title',
		        'namespace'     => 'support',
		        'type'          => 'text',
		        'extra'			=> array('max_length' => 255),
		        'assign'        => 'support_tickets',
		        'title_column'  => TRUE,
		        'required'      => TRUE
		    ),
		    array(
		        'name'   		=> 'Description',
		        'slug'          => 'description',
		        'namespace'     => 'support',
		        'type'          => 'textarea',
		        'assign'        => 'support_tickets',
		        'required'      => TRUE
		    ),
		    array(
		        'name'   		=> 'Status',
		        'slug'          => 'status',
		        'namespace'     => 'support',
		        'type'          => 'text',
		        'extra'			=> array('max_length' => 10),
		        'assign'        => 'support_tickets',
		        'extra'			=> array('new' => 'New', 'in-progress' => 'In Progress', 'resolved' => 'Resolved')
		    )
		);

		if ($this->streams->streams->add_stream('Support Tickets', 'support_tickets', 'support', $prefix = NULL, $about = NULL))
		{
			$this->streams->fields->add_fields($fields);

			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->load->driver('streams');

		$this->streams->fields->delete_field('number', 'support');
		$this->streams->fields->delete_field('name', 'support');
		$this->streams->fields->delete_field('title', 'support');
		$this->streams->fields->delete_field('description', 'support');
		$this->streams->fields->delete_field('status', 'support');

		return $this->streams->streams->delete_stream('support_tickets', 'support');
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */

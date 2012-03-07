<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * A simple and purpose built ticket system
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Support Module
 */
class Support extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->driver('streams');
		$this->load->model('support_ticket_m');
	}

	/**
	 * Show tickets
	 */
	public function index()
	{
		$params = array(
			'stream' => 'support_tickets', 
			'namespace' => 'support', 
			'limit' => 20, 
			'order_by' => 'id', 
			'sort' => 'desc'
		);

		$tickets = $this->streams->entries->get_entries($params);

		$params['limit'] = 1;
		$params['sort'] = 'desc';
		$last_ticket = $this->streams->entries->get_entries($params);

		$data = array(
			'number' 		=> $last_ticket['entries'] ? ++$last_ticket['entries'][0]['number'] : 1000,
			'name' 			=> $this->input->post('name'),
			'title' 		=> $this->input->post('title'),
			'description' 	=> $this->input->post('description'),
			'status'		=> 'open',
			'created'		=> date('Y-m-d H:i:s'),
			'updated'		=> date('Y-m-d H:i:s'),
			'created_by'	=> $this->current_user ? $this->current_user->id : 0,
			'ordering_count'=> 0
			);

		if ($this->input->post())
		{
			if ($this->support_ticket_m->insert($data))
			{
				$this->session->set_flashdata('success', 'Thank you, your ticket has been created.');
				redirect('support');
			}
		}

		$this->template->title($this->module_details['name'], 'Support Tickets')
						->append_css('module::support.css')
						->append_js('module::support.js')
						->append_metadata('<script>var SITE_URL = "'.site_url().'"</script>')
						->build('index', $tickets);
	}

	public function get_last()
	{
		$id = $this->input->post('id');
		$admin = $this->current_user AND $this->current_user->group == 'admin' ? TRUE : FALSE;

		if ($id > 0)
		{
			$result = $this->support_ticket_m->where('id >', $id)->get_all();

			echo json_encode(array('status' => $result ? TRUE : FALSE, 
								   'message' => 'Success',
								   'data' => array('tickets' => $result, 'admin' => $admin)
								   )
							);
			return;
		}


		echo json_encode(array('status' => FALSE, 
							   'message' => 'Nothing found',
							   'data' => ''
							   )
						);
	}

	public function details()
	{
		$id = $this->input->post('id');

		if ( ! $id OR ! $this->current_user OR $this->current_user->group !== 'admin')
		{
			echo json_encode(array('status' => FALSE, 
								   'message' => 'You do not have permission to view this ticket'
								   )
							);
			return;
		}

		$result = $this->streams->entries->get_entry($id, 'support_tickets', 'support');

		if ($result) $result->created = format_date($result->created);

		echo json_encode(array('status' => TRUE, 
							   'message' => 'Success', 
							   'data' => $result
							   )
						);
	}

	public function status()
	{
		$id 	= $this->input->post('id');
		$status = $this->input->post('status');

		if ( ! $id OR ! $this->current_user OR $this->current_user->group !== 'admin')
		{
			echo json_encode(array('status' => FALSE, 
								   'message' => 'You do not have permission to view this ticket'
								   )
							);
			return;
		}

		$result = $this->support_ticket_m->update($id, array('status' => $status), TRUE);

		echo json_encode(array('status' => $result, 
							   'message' => $result ? 'Success' : 'Update Failed', 
							   'data' => ''
							   )
						);
	}
}
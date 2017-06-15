<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends SC_Controller {

	# This is the index page: http://localhost/ci/index.php?profile
	public function user($username = NULL)
	{

		if ($username == NULL) {
			show_404 ();
			return;
		}

		# Set up the page variables
		$data = array (
			'username'	=> $username
		);

		$this->load->view ('struct/start');

		# This command loads a view from the application/views folder
		$this->load->view('profile/profile', $data);

		$this->load->view ('struct/end');
	}

}

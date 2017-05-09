<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends TW_Controller {

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
		$this->load->view('profile/view', $data);

		$this->load->view ('struct/end');
	}


	# The send message page: http://localhost/ci/index.php?/profile/message
	public function message () {

		$this->load->view ('struct/start');
		$this->load->view ('profile/message');
		$this->load->view ('struct/end');

	}
}

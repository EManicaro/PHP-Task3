<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends SC_Controller {

	# The registration form
	public function register () {

		# first: load the form helper
		$this->load->helper ('form');

		# the page info goes into an array
		$data = array (
			'form'		=> array (
				'name'		=> array (
					'type'			=> 'text',
					'name'			=> 'input-name',
					'placeholder'	=> 'Name',
					'required'		=> TRUE
				),

				'surname'		=> array (
					'type'			=> 'text',
					'name'			=> 'input-surname',
					'placeholder'	=> 'Surname',
					'required'		=> TRUE
				),

				'role'		=> array (
					'type'			=> 'text',
					'name'			=> 'input-role',
					'placeholder'	=> 'Role',
					'required'		=> TRUE
				),

				'date_of_birth'		=> array (
					'type'			=> 'date',
					'name'			=> 'input-date_of_birth',
					'required'		=> TRUE
				),

				'username'		=> array (
					'type'			=> 'text',
					'name'			=> 'input-username',
					'placeholder'	=> 'Username',
					'required'		=> TRUE
				),

				'password'		=> array (
					'type'			=> 'password',
					'name'			=> 'input-password',
					'placeholder'	=> 'Password',
					'required'		=> TRUE
				),

				'email'			=> array (
					'type'			=> 'email',
					'name'			=> 'input-email',
					'placeholder'	=> 'me@example.com',
					'required'		=> TRUE
				)
			)
		);

		# load the registration page
		$this->load->view ('register', $data);

	}

	# The registration process
	public function do_register () {

		# load the form validator
		$this->load->library ('form_validation');

		# set the form rules
		$rules = array (
			array (
				'field'	=> 'input-name',
				'label' => 'Name',
				'rules' => 'required|alpha'
			),
			array (
				'field'	=> 'input-surname',
				'label' => 'Surname',
				'rules' => 'required|alpha'
			),
			array (
				'field'	=> 'input-role',
				'label' => 'Role',
				'rules' => 'required|alpha'
			),
			array (
				'field'	=> 'input-date_of_birth',
				'label' => 'Date of Birth',
				'rules' => 'required|date'
			),
			array (
				'field'	=> 'input-username',
				'label' => 'Username',
				'rules' => 'required|alpha'
			),
			array (
				'field'	=> 'input-email',
				'label' => 'Email',
				'rules' => 'required|valid_email'
			),
			array (
				'field'	=> 'input-password',
				'label' => 'Password',
				'rules' => 'required|min_length[8]|max_length[20]'
			)
		);

		# set the rules in the library
		$this->form_validation->set_rules ($rules);

		# check for validation errors on the page, if there are any, stop here
		if ($this->form_validation->run () === FALSE) {
			echo validation_errors ();
			return;
		}

		$full_name 	= $this->input->post ('input-name');
		$full_surname 	= $this->input->post ('input-surname');
		$role 	= $this->input->post ('input-role');
		$dob 	= $this->input->post ('input-date_of_birth');
		$username 	= $this->input->post ('input-username');
		$password 	= $this->input->post ('input-password');
		$email 		= $this->input->post ('input-email');

		if ($this->users_model->register ($full_name, $full_surname, $role, $dob, $username, $password, $email)) {
			echo "The user was registered.";
		} else {
			echo "The user could not be registered.";
		}

		$this->load->view ('login');

	}

	# The login form
	public function login () {

		# first: load the form helper
		$this->load->helper ('form');

		# the page info goes into an array
		$data = array (
			'form'		=> array (
				'username'			=> array (
					'type'			=> 'text',
					'name'			=> 'input-username',
					'placeholder'	=> 'Username',
					'required'		=> TRUE
				),
				'password'		=> array (
					'type'			=> 'password',
					'name'			=> 'input-password',
					'placeholder'	=> 'password',
					'required'		=> TRUE
				)
			)
		);

		# load the login page
		$this->load->view ('login', $data);

	}

	# The login process
	public function do_login () {

		# load the form validator
		$this->load->library ('form_validation');

		# set the form rules
		$rules = array (
			array (
				'field'	=> 'input-username',
				'label' => 'Username',
				'rules' => 'required'
			),
			array (
				'field'	=> 'input-password',
				'label' => 'Password',
				'rules' => 'required'
			)
		);

		# set the rules in the library
		$this->form_validation->set_rules ($rules);

		# check for validation errors on the page, if there are any, stop here
		if ($this->form_validation->run () === FALSE) {
			echo validation_errors ();
			return;
		}

		$username	= $this->input->post ('input-username');
		$password 	= $this->input->post ('input-password');

		# Set the result of this query in a variable
		$login_id = $this->users_model->username_id ($username);

		# If the username doesn't exist, stop here
		if (!$login_id) {
			echo "The username does not exist.";
			return;
		}

		# The username is OK, so now we should check the password
		if (!$this->users_model->check_password ($login_id, $password)) {
			echo "The password is incorrect";
			return;
		}

		# Get the user information and set it in a session
		$userdata = $this->users_model->get_userdata ($login_id);

		# We set the userdata, however we need to set an encryption key
		$this->session->set_userdata ($userdata);

		$this->load->view ('struct/start');
		$this->load->view ('news-feed');
		$this->load->view ('struct/end');

	}

	# The logout function
	public function logout () {

		unset($_SESSION['user_id']);
		unset($_SESSION['user_name']);

		redirect ('login');

	}
}

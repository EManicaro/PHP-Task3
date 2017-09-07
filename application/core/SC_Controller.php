<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SC_Controller extends CI_Controller {

    # This is the class constructor used to get the data from its parent
    function __construct () {

        # Inherit the parent class' properties
        parent::__construct ();

        $this->check_login ();

    }

    # Builds a standard page
    # This function should only be available to this class and its children
    protected function build ($page, $param = NULL) {

    $this->load->view ('struct/start');

    $this->load->view ($page, $param);

    $this->load->view ('struct/end');

    }

    # Check if the user is logged in
    protected function check_login () {

        # if the user is logged in, return them to the website
		if ($this->session->userdata ('user_id') != NULL) {

            # if the user is on the login/register pages
            if ($this->router->fetch_class () == 'users') {
                # only redirect if the user is not on the logout page
                if ($this->router->fetch_method () != 'logout') {
                    redirect ("home");
                }
            }

        # if the user is logged out
        } else {

            # if the user is not on the login/register pages
            if ($this->router->fetch_class () != 'users') {
                redirect ("users/login");
            }
    }

    }
}

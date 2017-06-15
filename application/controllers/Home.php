<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends SC_Controller {

	# This is the class constructor used to get the data from its parent
    function __construct () {

        # Inherit the parent class' properties
        parent::__construct ();

    }

	# This is the index page: http://localhost/ci/index.php?home
	public function index ()
	{

		# This command loads a view from the application/views folder
		$this->build ('news-feed');

	}
}

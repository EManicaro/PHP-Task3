<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes extends SC_Controller {

    # This is the class constructor used to get the data from its parent
    function __construct () {

        # Inherit the parent class' properties
        parent::__construct ();

        $this->load->model ('notes_model');

    }

    # Create Note
    public function create_note ()
    {

        $this->load->view ('struct/start');

		# This command loads a view from the application/views folder
		$this->load->view('notes');

		$this->load->view ('struct/end');

    }

    # Load Note
    public function view ($id)
    {

        $notes = $this->notes_model->get ($id);
        $this->load->helper ('form');

        $hidden = array ('note_id' => $id);

        echo form_open ('add', NULL, $hidden);

    }

    # Update Note
    public function update_note () {

        #check data (form_validation)
        $data = array (
			'form'		=> array (
				'title'		=> array (
					'type'			=> 'text',
					'name'			=> 'input-title',
					'placeholder'	=> 'Title',
					'required'		=> TRUE
				)
                )
            );
        #retrive data ($this->input->post())
        $id = $this->input->post('note_id');
        $title = $this->input->post('title');

        #update via model ($this->model->update())
        $this->notes_model->update_note($id, $title);

    }

    # Save Note to Disk
    public function save_note_to_disk () {

        if (!file_exists ('notes')) {
            # MAKE DIRECTORY
            mkdir ('notes');
        }

        $id = $this->input->post('note_id');
        $content = $this->input->post('content');

        $filename = "notes/{$id}.txt";

        if (!$handler = fopen ($filename, 'w+')) {
            return FALSE;
        }

        fwrite ($handler, $content);

        fclose ($handler);

        return TRUE;

    }

    # Load Note from Disk
    public function load_note_from_disk ($note_id) {

        if (!file_exists ('notes')) {
            # MAKE DIRECTORY
            mkdir ('notes');

            return FALSE;
        }

        $filename = "notes/{$note_id}.txt";

        if (!$handler = fopen ($filename, 'r+')) {
            return FALSE;
        }

        $contents = fread ($handler, filesize ($filename));

        fclose ($handler);

        return $contents;

    }

    }
?>

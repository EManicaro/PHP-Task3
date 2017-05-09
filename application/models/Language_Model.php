<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language_Model extends CI_Model {

    # gets a language from the database
    public function get_language ($id = 1) {

        $this->db->select ('lang_name')
                 ->where ('lang_id', $id);

        return $this->db->get ('tbl_language')->row_array ();

        /*
            SELECT lang_name ->select
            FROM tbl_language ->get
            WHERE lang_id = 1 ->where

            return the first row ->row_array
        */

    }

}

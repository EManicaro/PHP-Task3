<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes_Model extends CI_Model {

    # Create Note
    public function create_note ()
    {

        $data = array (
            'note_title' => 'Title',
            'tbl_users_user_id' => 'User ID'
        );

        # Prepare the query
        $query = "
            INSERT INTO notes
                (note_title, note_date, user_id)
            VALUES
                ('{$title}', {$date}, {$user_id})
        ";

        # Save the query results in a variable
        $result = mysqli_query ($conn, $query);

        $id = mysqli_insert_id ($conn);

    }

    # Load Note
    public function get ($id)
    {
        $data = array (
            'tbl_users_user_id'   => $this->session->userdata('user_id'),
            'note_id'   => $id
        );

        # Save the query results in a variable
        $result = $this->db->select ('*')
                            ->where ($data)
                            ->get ('tbl_notes');

        # The page will have an associative array available
        return $result;

    }

    # Update Note
    public function update_note ($id, $title) {

        $where = array (
            'tbl_users_user_id'   => $this->session->userdata('user_id'),
            'note_id'   => $id
        );

        $update = array (
            'note_title' => $title
        );

        $this->db->where($where)
                  ->update('tbl_notes', $update);

        return ($this->db->affected_rows() == 1);

    }

    }
?>

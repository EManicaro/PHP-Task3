<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Model extends CI_Model {

    # Register the user
    public function register ($full_name, $email, $password) {

        $data = array (
            'user_full_name'    => $full_name,
            'user_email'        => $email,
            'user_password'     => password_hash ($password, CRYPT_BLOWFISH)
        );

        $this->db->insert ('tbl_users', $data);

        $id = $this->db->insert_id ();

        return ($id > 0) ? $id : FALSE;

    }


    # Check if the user email exists
    public function email_id ($email) {

        # The query will get the id from the email address
        $this->db->select ('user_id')
            ->where ('user_email', $email);

        # Put the results in a variable
        $result = $this->db->get ('tbl_users');

        # If there is not just ONE row, the login can't happen
        if ($result->num_rows () != 1)
            return FALSE;

        # Get the record as an array, and return the user id
        return $result->row_array ()['user_id'];

    }

    # Check that the password is correct
    public function check_password ($id, $password) {

        # The query is set
        $this->db->select ('user_password')
            ->where ('user_id', $id);

        # Put the results in a variable
        $result = $this->db->get ('tbl_users');

        # If there is not just ONE row, the login can't happen
        if ($result->num_rows () != 1)
            return FALSE;

        # Get the password since the criteria matches
        $db_pass = $result->row_array ()['user_password'];

        # Tell the user if the password is ok
        return password_verify ($password, $db_pass);

    }

    # Retrieve the user's data
    public function get_userdata ($id) {

        # Set the query
        $this->db->select ('user_id, user_full_name')
            ->where ('user_id', $id);

        # Put the results in a variable
        $result = $this->db->get ('tbl_users');

        # If there is not just ONE row, the login can't happen
        if ($result->num_rows () != 1)
            return FALSE;

        # Give the controller all the data as an array
        return $result->row_array ();

    }

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Model extends CI_Model {

    # Register the user
    public function register ($full_name, $full_surname, $role, $dob, $username, $password, $email) {

        $data = array (
            'user_name'     => $full_name,
            'user_surname'  => $full_surname,
            'user_role'     => $role,
            'user_dob'      => $dob,
            'user_username' => $username,
            'user_password' => password_hash ($password, CRYPT_BLOWFISH),
            'user_email'    => $email

        );

        $this->db->insert ('tbl_users', $data);

        $id = $this->db->insert_id ();

        return ($id > 0) ? $id : FALSE;

    }


    # Check if the user username exists
    public function username_id ($username) {

        # The query will get the id from the username
        $this->db->select ('user_id')
            ->where ('user_username', $username);

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
        $this->db->select ('user_id, user_name')
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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notes extends SC_Controller {

    # Create Note
    public function create_note ($user_id, $title)
    {

        # Open a connection to the database
        $conn = connect_to_database ();

        # Filter all the inputs
        $user_id = mysqli_escape_string ($conn, $user_id);
        $title = mysqli_escape_string ($conn, $title);
        $date = time ();

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

        # Disconnect from the database
        disconnect_from_database ($conn);

        return $id;

    }

    # Load Note
    public function load_note ($user_id, $note_id)
    {

        # Open a connection to the database
        $conn = connect_to_database ();

        # Filter all the inputs
        $user_id = mysqli_escape_string ($conn, $user_id);
        $note_id = mysqli_escape_string ($conn, $note_id);

        # Prepare the query
        $query = "
            SELECT *
            FROM notes
            WHERE note_id={$note_id} AND user_id={$user_id}
        ";

        # Save the query results in a variable
        $result = mysqli_query ($conn, $query);

        # Disconnect from the database
        disconnect_from_database ($conn);

        # If there are no results from the query, stop here
        if (mysqli_num_rows ($result) != 1)
            return FALSE;

        # The page will have an associative array available
        return mysqli_fetch_assoc ($result);

    }

    # Update Note
    public function update_note ($user_id, $note_id, $title) {

        # Open a connection to the database
        $conn = connect_to_database ();

        # Filter all the inputs
        $user_id = mysqli_escape_string ($conn, $user_id);
        $note_id = mysqli_escape_string ($conn, $note_id);
        $title = mysqli_escape_string ($conn, $title);

        # Prepare the query
        $query = "
            UPDATE notes
            SET
                note_title = '{$title}'
            WHERE
                user_id = '{$user_id}' AND
                note_id = '{$note_id}'
        ";

        # Save the query results in a variable
        $result = mysqli_query ($conn, $query);
        $affected = mysqli_affected_rows ($conn);

        # Disconnect from the database
        disconnect_from_database ($conn);

        return ($affected == 1);

    }

    # Save Note to Disk
    public function save_note_to_disk ($note_id, $content) {

        if (!file_exists ('notes')) {
            # MAKE DIRECTORY
            mkdir ('notes');
        }

        $filename = "notes/{$note_id}.txt";

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

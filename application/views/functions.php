<?php
    session_start ();

    if (!isset ($_COOKIE['user_id']) and !isset ($login))
        redirect ('login.php');

    # Redirect the user to a specific page
    function redirect ($page) {
        header ("Location:" . site_url ($page));
    }

    # Prepare a link to redirect the site
    function site_url ($page) {
        return "/assignment/Student Companion/pages/" . $page;
    }

    # Connect to a database
    function connect_to_database () {
        $conn = mysqli_connect ("localhost", "root", "", "db_enrico_manicaro")
            or die ("Unable to connect to the database.");
        
        return $conn;
    }

    # Disconnect from a database
    function disconnect_from_database ($conn) {
        mysqli_close ($conn);
    }

    # Check the login details
    function login ($username, $password) {
        
        # Open a connection to the database
        $conn = connect_to_database ();
        
        # Filter the inputs
        $username = mysqli_escape_string ($conn, $username);
        
        # Prepare the query
        $query = "
            SELECT *
            FROM users
            WHERE
                user_username = '{$username}'
        ";
        
        $result = mysqli_query ($conn, $query);
        if (!$result) return FALSE;
        
        if (mysqli_num_rows ($result) == 0)
            return FALSE;
        
        # Disconnect from the database
        disconnect_from_database ($conn);
        
        # Associative array
        $result = mysqli_fetch_assoc ($result);
        
        if (!password_verify ($password, $result['user_password']))
            return FALSE;
        
        return $result;
        
    }

    # Register a user
    function register_user ($name, $surname, $role, $dob, $username, $password, $email) {
        
        # Open a connection to the database
        $conn = connect_to_database ();
        
        # Filter all the inputs
        $name = mysqli_escape_string ($conn, $name);
        $surname = mysqli_escape_string ($conn, $surname);
        $role = mysqli_escape_string ($conn, $role);
        $dob = mysqli_escape_string ($conn, $dob);
        $username = mysqli_escape_string ($conn, $username);
        $password = password_hash ($password, CRYPT_BLOWFISH);
        $password = mysqli_escape_string ($conn, $password);
        $email = mysqli_escape_string ($conn, $email);
        
        # Prepare the query
        $query = "
            INSERT INTO users
                (user_name, user_surname, user_role, user_dob, user_username, user_password, user_email)
            VALUES
                ('{$name}', '{$surname}', '{$role}', '{$dob}', '{$username}', '{$password}', '{$email}')
        ";
        
        # Save the query results in a variable
        $result = mysqli_query ($conn, $query);
        
        # Check that the query was successful
        if (mysqli_affected_rows ($conn) != 1){
            return "The user could not be registered: " . mysqli_error ($conn);
        }
        
        # Disconnect from the database
        disconnect_from_database ($conn);
        
        # There were no errors!
        return TRUE;
    }

    # Create Note
    function create_note ($user_id, $title) {
        
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
    function load_note ($user_id, $note_id) {
        
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
    function update_note ($user_id, $note_id, $title) {
        
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
    function save_note_to_disk ($note_id, $content) {
        
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
    function load_note_from_disk ($note_id) {
        
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
?>
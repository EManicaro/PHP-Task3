<?php
    include 'functions.php';

    $note_id = null;
    if (isset ($_GET['n'])) {
        $note_id = $_GET['n'];
        $note = null;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $note_id = $_POST['note_id'];

        if ($note_id == NULL) {
            $note_id = create_note ($_COOKIE['user_id'], $title);
        } else {
            update_note ($_COOKIE['user_id'], $note_id, $title);
        }

        save_note_to_disk ($note_id, $content);

        redirect ("notes.php?n={$note_id}");

    } else {
        if ($note_id != null) {
            $note = load_note ($_COOKIE['user_id'], $note_id);
            $note['content'] = load_note_from_disk ($note_id);
        }
    }
?>

          <h2 id="sub-title">Notes</h2>

            <hr id="sub-title-line">

            <form action="notes.php" method="post">

                <input type="text" name="title" placeholder="Title" id="notes-title-box" value="<?php if (isset ($note)) echo $note['note_title']?>">

                <br>

                <textarea rows="10" cols="50" name="content" placeholder="Text here..." id="notes-text-box"><?php if (isset ($note)) echo $note['content']?></textarea>

                <br>

                <button type="submit" id="save-button">Save</button>

        <?php if (isset ($note)): ?>
                <input type="hidden" name="note_id" value="<?=$note_id?>">
        <?php endif; ?>

            </form>

            <hr id="line">

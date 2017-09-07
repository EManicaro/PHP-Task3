
          <h2 id="sub-title">Notes</h2>

            <hr id="sub-title-line">

            <form action="notes.php" method="post">

                <input type="text" name="title" placeholder="Title" id="notes-title-box" value="<?php if (isset ($note)) echo $note['note_title']?>">

                <br>

                <textarea rows="10" cols="50" name="content" placeholder="Text here..." id="notes-text-box"><?php if (isset ($note)) echo $note['content']?></textarea>

                <br>

                <button type="submit" id="save-button">Save</button>

            </form>

            <hr id="line">

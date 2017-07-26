<!DOCTYPE html>

<html>
    <head>
        <title>Student Companion</title>

        <link type="text/css" rel="stylesheet" href="../css/style.css">
    </head>

    <body>

        <naV id="menu">
            <ul>
                <li>
                    <a href="<?site_url('news-feed')?>" <?php if ($this->router->fetch_class () == 'Home') echo 'class="active"' ?>>News Feed</a>
                </li>

                <li>
                    <a href="<?site_url('profile')?>" <?php if ($this->router->fetch_class () == 'Home') echo 'class="active"' ?>>Profile Page</a>
                </li>

                <li>
                    <a href="<?site_url('notes')?>" <?php if ($this->router->fetch_class () == 'Home') echo 'class="active"' ?>>Notes</a>
                </li>

                <li>
                    <a href="<?site_url('contact-form')?>" <?php if ($this->router->fetch_class () == 'Home') echo 'class="active"' ?>>Contact Form</a>
                </li>

                <hr>

                <li>
                    <a href="<?site_url('login')?>" <?php if ($this->router->fetch_class () == 'Home') echo 'class="active"' ?>>Log Out</a>
                </li>

            </ul>
        </naV>

        <header id="title">
            <h1>Student Companion</h1>
        </header>

        <main>

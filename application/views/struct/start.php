<!DOCTYPE html>

<html>
    <head>
        <title>Student Companion</title>

        <link type="text/css" rel="stylesheet" href="<?=base_url('css/style.css')?>">
    </head>

    <body>

        <naV id="menu">
            <ul>
                <li>
                    <a href="<?php echo base_url('home/index'); ?>">News Feed</a>
                </li>

                <li>
                    <a href="<?php echo base_url('home/profile'); ?>">Profile Page</a>
                </li>

                <li>
                    <a href="<?php echo base_url('notes/create_note'); ?>">Notes</a>
                </li>

                <li>
                    <a href="<?php echo base_url('contact_form/index'); ?>">Contact Form</a>
                </li>

                <hr>

                <li>
                    <a href="<?php echo base_url('users/logout'); ?>">Log Out</a>
                </li>

            </ul>
        </naV>

        <header id="title">
            <h1>Student Companion</h1>
        </header>

        <main>

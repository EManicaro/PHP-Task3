<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>

        <link rel="stylesheet" type="text/css" href="<?=base_url ('css/style.css')?>">
    </head>
    <body>
        <?=form_open ('users/do_login'); ?>

        <?=form_input ($form['username']); ?>
        <?=form_input ($form['password']); ?>

        <?=form_submit (null, 'Login');?>
        <a href="<?=site_url('register')?>">Sign Up</a>

        <?=form_close (); ?>

    </body>
</html>

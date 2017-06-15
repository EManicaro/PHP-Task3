<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Register</title>

        <link rel="stylesheet" type="text/css" href="<?=base_url ('css/style.css')?>">
    </head>
    <body>
        <?=form_open ('users/do_login'); ?>

        <?=form_input ($form['username']); ?>
        <?=form_input ($form['password']); ?>

        <?=form_submit (null, 'Login');?>
        <input type="button" value="Sign Up" class="registerbutton" id="btnRegister" onclick="document.location.href='register.php'" />

        <?=form_close (); ?>

        <li><a href="<?=base_url('register')?>">Register</a></li>
    </body>
</html>

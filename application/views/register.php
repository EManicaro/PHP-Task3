<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Register</title>
    </head>
    <body>
        <?=form_open ('users/do_register'); ?>

        <?=form_input ($form['full_name']); ?>
        <?=form_input ($form['email']); ?>
        <?=form_input ($form['password']); ?>

        <?=form_submit (null, 'Register');?>

        <?=form_close (); ?>
    </body>
</html>

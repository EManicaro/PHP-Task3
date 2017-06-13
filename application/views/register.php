<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Register</title>
    </head>
    <body>
        <?=form_open ('users/do_register'); ?>

        <?=form_input ($form['name']); ?>
        <?=form_input ($form['surname']); ?>
        <?=form_input ($form['role']); ?>
        <?=form_input ($form['date_of_birth']); ?>
        <?=form_input ($form['username']); ?>
        <?=form_input ($form['password']); ?>
        <?=form_input ($form['email']); ?>

        <?=form_submit (null, 'Register');?>

        <?=form_close (); ?>
    </body>
</html>

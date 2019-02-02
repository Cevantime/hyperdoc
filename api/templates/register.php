<?php
/* @var \League\Plates\Template\Template $this */
$this->layout('layout'); ?>

<?php $this->start('body'); ?>
    <form method="post" action="<?php echo $this->url("register"); ?>">
        <p>
            <label for="username">Username</label>
            <input type="text" name="username" value="<?php echo $this->entry('username', $data); ?>">
            <?php echo empty($errors['username']) ? '' : $this->listing($errors['username']) ?>
        </p>
        <p>
            <label for="email">Email</label>
            <input type="text" name="email" value="<?php echo $this->entry('email', $data); ?>">
            <?php echo empty($errors['email']) ? '' : $this->listing($errors['email']) ?>
        </p>
        <p>
            <label for="password">Password</label>
            <input type="password" name="password">
            <?php echo empty($errors['password']) ? '' : $this->listing($errors['password']) ?>
        </p>
        <input type="submit" value="Register">
        <p>
            Already registered ? Please <a href="<?php echo $this->url('login'); ?>">log in</a>.
        </p>
    </form>
<?php $this->stop(); ?>
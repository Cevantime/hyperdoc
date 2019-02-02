<?php
/* @var \League\Plates\Template\Template $this */
$this->layout('layout'); ?>

<?php $this->start('body'); ?>
<form method="post" action="<?php echo $this->url("login"); ?>">
    <p>
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo $lastUsername; ?>">
    </p>
    <p>
        <label for="password">Password</label>
        <input type="password" name="password">
    </p>
    <p><?php echo $this->e($error) ?></p>
    <input type="submit" value="Login">
    <p>
        Not registered yet ? you can <a href="<?php echo $this->url('register'); ?>">do it</a> right now.
    </p>
</form>
<?php $this->stop(); ?>

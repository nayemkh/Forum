<?php

require_once '../src/registration.php';

$controller = new Registration\Controller();
$controller->run();

$messages = $controller->messages;
?>

<?php if (isset($messages) && is_array($messages) && !empty($messages)) {
    foreach ($messages as $type => $messageArray) {
        $role = $type === 'error' ? 'alert' : 'status'; ?>
        <ul class="form-info <?=$type?>" role="<?=$role?>">
            <?php foreach ($messageArray as $message) { ?>
                <li><?=$message?></li>
            <?php } ?>
        </ul>
    <?php } ?>
<?php } ?>

<form method="POST">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="form-action">
        <button type="submit" name="submit" value="1">Submit</button>
    </div>
</form>

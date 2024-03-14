<!DOCTYPE HTML>
<html>
<head>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
</head>
<body>

<?php
/** @var $params */
$model = $params['model'] ?? new \Users\Models\User();
?>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars('/user/create'); ?>">
    First Name: <input type="text" name="firstname" value="<?php echo $model->firstname; ?>">
    <br><br>
    Last Name: <input type="text" name="lastname" value="<?php echo $model->lastname; ?>">
    <br><br>
    E-mail: <input type="text" name="email" value="<?php echo $model->email; ?>">
    <br><br>
    Password: <input type="text" name="password" value="<?php echo $model->password; ?>">
    <br><br>
    Repeat Password: <input type="text" name="password1" value="<?php echo $model->password1; ?>">
    <br><br>
    Role: <select name="role" id="role">
        <option <?php echo ($model->role == 'admin' ? 'selected' : ''); ?> value="admin" >Admin</option>
        <option <?php echo ($model->role == 'operator' ? 'selected' : ''); ?> value="operator" >Operator</option>
        <option <?php echo ($model->role == 'user' ? 'selected' : ''); ?> value="user">User</option>
    </select>
    <br><br>
    State: <select name="state" id="state">
        <option <?php echo ($model->state == 0 ? 'selected' : ''); ?> value="0">New</option>
        <option <?php echo ($model->state ==1 ? 'selected' : ''); ?> value="1">Active</option>
        <option <?php echo ($model->state == 2 ? 'selected' : ''); ?> value="2">Blocked</option>
        <option <?php echo ($model->state == 3 ? 'selected' : ''); ?> value="3">Deleted</option>
    </select>
    <br><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>

<?php

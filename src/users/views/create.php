<!DOCTYPE HTML>
<html lang="en">
<head>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
    <title>Create</title>
</head>
<body>

<?php
/** @var $params */
$model = $params['model'] ?? new \Users\Models\User();
?>

<p><span class="error">* Required field</span></p>
<form method="post" action="<?php echo htmlspecialchars('/user/create' .
    ($_SESSION['user'] instanceof \Users\Models\User ? '?auth_role=' .($_SESSION['user'])->role : '')); ?>">
    <label>First Name:
        <input type="text" name="firstname" value="<?php echo $model->firstname; ?>">
    </label>
    <span class="error">* <?php echo $model->getError('firstname'); ?></span>
    <br><br>
    <label>Last Name:
        <input type="text" name="lastname" value="<?php echo $model->lastname; ?>">
    </label>
    <span class="error">* <?php echo $model->getError('lastname'); ?></span>
    <br><br>
    <label>E-mail:
        <input type="text" name="email" value="<?php echo $model->email; ?>">
    </label>
    <span class="error">* <?php echo $model->getError('email'); ?></span>
    <br><br>
    <label> Password:
        <input type="text" name="password" value="<?php echo $model->password; ?>">
    </label>
    <span class="error">* <?php echo $model->getError('password'); ?></span>
    <br><br>
    <label>Repeat Password:
        <input type="text" name="password1" value="<?php echo $model->password1; ?>">
    </label>
    <span class="error">* <?php echo $model->getError('password1'); ?></span>
    <br><br>
    <label for="role">Role: </label><select name="role" id="role">
        <option value="user">User</option>
        <option value="admin">Admin</option>
        <option value="operator">Operator</option>
    </select>
    <br><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>


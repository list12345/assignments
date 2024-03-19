<!DOCTYPE HTML>
<html lang="en">
<head>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
    <title>
        Update
    </title>
</head>
<body>

<?php
/** @var $params */
$model = $params['model'] ?? new \Users\Models\User();
?>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars('/user/update?id=' . $model->id .
    ($_SESSION['user'] instanceof \Users\Models\User ? '&auth_role=' .($_SESSION['user'])->role : '')); ?>">
    <label>First Name:
        <input type="text" name="firstname" value="<?php echo $model->firstname; ?>">
    </label>
    <span class="error">* <?php echo $model->getError('firstname'); ?></span>
    <br><br>
    <label> Last Name:
        <input type="text" name="lastname" value="<?php echo $model->lastname; ?>">
    </label>
    <span class="error">* <?php echo $model->getError('lastname'); ?></span>
    <br><br>
    <label>E-mail:
        <input type="text" name="email" value="<?php echo $model->email; ?>">
    </label>
    <span class="error">* <?php echo $model->getError('email'); ?></span>
    <br><br>
    <label for="role">Role: </label><select name="role" id="role">
        <option <?php echo($model->role == 'admin' ? 'selected' : ''); ?> value="admin">Admin</option>
        <option <?php echo($model->role == 'operator' ? 'selected' : ''); ?> value="operator">Operator</option>
        <option <?php echo($model->role == 'user' ? 'selected' : ''); ?> value="user">User</option>
    </select>
    <br><br>
    <label for="state"> State: </label><select name="state" id="state">
        <option <?php echo($model->state == 0 ? 'selected' : ''); ?> value="0">New</option>
        <option <?php echo($model->state == 1 ? 'selected' : ''); ?> value="1">Active</option>
        <option <?php echo($model->state == 2 ? 'selected' : ''); ?> value="2">Blocked</option>
        <option <?php echo($model->state == 3 ? 'selected' : ''); ?> value="3">Deleted</option>
    </select>
    <br><br>
    <input type="submit" value="Update">
    <?php if ($model->state != 3) { ?>
        <button onclick="location.href='/user/delete?id=<?php echo $model->id; ?><?php echo ($_SESSION['user'] instanceof \Users\Models\User ?
            '&auth_role=' .($_SESSION['user'])->role : ''); ?>'" type="button">
            Delete
        </button>
    <?php } ?>
</form>

</body>
</html>

<?php

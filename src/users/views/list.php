<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
    <title>List</title>
</head>
<body>

<?php if ($_SESSION['user'] instanceof \Users\Models\User && ($_SESSION['user'])->role == 'admin') { ?>
    <button onclick="location.href='create?auth_role=admin'" type="button">
        Create New User
    </button>
<?php } ?>

<br><br>

<?php
/** @var $params */
$attributes = ['id', 'email', 'firstname', 'lastname', 'state', 'role'];
echo '<table><tr>';
foreach ($attributes as $attribute) {
    echo '<th>' . ucfirst($attribute) . '</th>';
}
echo '</tr>';

if (isset($params['rows']) && is_array($params['rows'])) {
    foreach ($params['rows'] as $model) {
        if (is_array($model)) {
            echo '<tr>';
            foreach ($attributes as $attribute) {
                if ($attribute == 'state') {
                    echo '<td>' . \Users\Models\User::getStateLabel($model[$attribute]) . '</td>';
                } else {
                    echo '<td>' . $model[$attribute] . '</td>';
                }
            } ?>
            <td>
                <button onclick="location.href='/user/update?id=<?php echo $model['id']; ?><?php echo ($_SESSION['user'] instanceof \Users\Models\User ?
                    '&auth_role=' .($_SESSION['user'])->role : ''); ?>'" type="button">
                    Update
                </button>
            </td>
            <?php echo '</tr>';
        }
    }
}
echo '</table>'; ?>

</body>
</html>
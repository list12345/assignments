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
// define variables and set to empty values
$first_name_err = $email_err = $last_name_err = $password_err = $password1_err = "";
$firstname = $email = $lastname = $password = $password1 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstname"])) {
        $first_name_err = "First Name is required";
    } else {
        $firstname = test_input($_POST["firstname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $firstname)) {
            $first_name_err = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["lastname"])) {
        $last_name_err = "Last Name is required";
    } else {
        $lastname = test_input($_POST["lastname"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
            $first_name_err = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $email_err = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $password_err = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z0-9!@#$%^&*()_+]*$/", $password)) {
            $password_err = "Only a-zA-Z0-9!@#$%^&*()_+ allowed";
        }
    }

    if (empty($_POST["password1"])) {
        $password1_err = "Repeat Password is required";
    } else {
        $password1 = test_input($_POST["password1"]);
        // check if password and password1 are equal
        if ($password1 != $password) {
            $password_err = "2 passwords should be equal";
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

?>

<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars('/user/create'); ?>">
    First Name: <input type="text" name="firstname" value="<?php echo $firstname; ?>">
    <span class="error">* <?php echo $first_name_err; ?></span>
    <br><br>
    Last Name: <input type="text" name="lastname" value="<?php echo $lastname; ?>">
    <span class="error">* <?php echo $last_name_err; ?></span>
    <br><br>
    E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
    <span class="error">* <?php echo $email_err; ?></span>
    <br><br>
    Password: <input type="text" name="password" value="<?php echo $password; ?>">
    <span class="error">* <?php echo $password_err; ?></span>
    <br><br>
    Repeat Password: <input type="text" name="password1" value="<?php echo $password1; ?>">
    <span class="error">* <?php echo $password1_err; ?></span>
    <br><br>
    Role: <select name="role" id="role">
        <option value="admin">Admin</option>
        <option value="operator">Operator</option>
        <option value="user">User</option>
    </select>
    <br><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>


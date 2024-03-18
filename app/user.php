<?php

$root_folder = __DIR__ . DIRECTORY_SEPARATOR;

foreach (scandir($root_folder . 'src/users') as $filename) {
    if (!in_array($filename, [basename(__FILE__), '.', '..', 'views'])) {
        $path = $root_folder . 'src/users' . DIRECTORY_SEPARATOR . $filename;
        if (is_dir($path)) {
            foreach (scandir($path) as $filename1) {
                if (!in_array($filename1, [basename(__FILE__), '.', '..',])) {
                    require_once $path . DIRECTORY_SEPARATOR . $filename1;
                }
            }
        }
    }
}

$controller = new \Users\Controllers\UsersController();
$uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

// It should be login-logout actions in another controller with authentication check (salt, oauth, saml).
// However, take shortcut here
// user could be admin, or just user, or guest by using 'auth_role' param
$logged_user = new \Users\Models\User();
$logged_user->role = $_GET['auth_role'];

$_SESSION['user'] = $logged_user;

// shortcut for routes
switch ($uri) {
    case '/user/create':
        $controller->actionCreate();
        break;
    case '/user/update':
        $controller->actionUpdate($_GET['id']);
        break;
    case '/user/delete':
        $controller->actionDelete($_GET['id']);
        break;
    case '/user/get':
        $controller->actionView($_GET['id']);
        break;
    case '/user/list':
        $controller->actionList();
        break;
    default:
        throw new Exception('Not implemented');
}
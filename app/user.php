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
// user is admin
$user = new \Users\Models\User();
$user->role = 'admin';

// user is not admin
/*$user = new \Users\Models\User();
$user->role = 'user';*/

// user is guest
/*$user = new \Users\Models\User();
$user->role = 'guest';*/

$_SESSION['user'] = $user;

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
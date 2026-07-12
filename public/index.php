<?php  

use Core\Model;
use Core\Router;
use Core\Container;

require '../vendor/autoload.php';
var_dump(
    file_exists(__DIR__.'/../app/Http/Controllers/Admin/StudentController.php')
);

var_dump(
    class_exists(\App\Http\Controllers\Admin\StudentController::class)
);

die();
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$config = require '../config/database.php';

$db = new Core\Database($config);

Model::setConnection($db->connection());

$container = new Container();

$router = new Router($container);

require '../routers/web.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $method);
<?php
require "./vendor/autoload.php";
require "./controller/processRequest.php";

use App\Controller\ProcessRequest;

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if ($uri[2] !== 'email') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

authenticate();

$body = (array) json_decode(file_get_contents('php://input'), TRUE);
$controller = new ProcessRequest($body);
$response = $controller->sendToWorker();

header($response['status_code_header']);
if ($response['body']) {
    echo $response['body'];
}

function authenticate()
{
    $api_credentials = array(
        'kevin' => 'kevin',
        'user' => 'user'
    );
    
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('HTTP/1.1 401 Unauthorized');
        exit;
    } else {
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
    
        if (!array_key_exists($username, $api_credentials)) {
            header('HTTP/1.1 403 Forbidden');
            exit;
        }
        if ($password != $api_credentials[$username]) {
            header('HTTP/1.1 403 Forbidden');
            exit;
        }
    }
}

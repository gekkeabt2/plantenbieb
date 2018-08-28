<?php
// Get composer packages //
$config_1 = '../vendor/autoload.php';
$config_2 = 'vendor/autoload.php';
if (file_exists($config_1)) {
	require_once $config_1;
} else {
	require_once $config_2;
}





// Setup the Medoo and PDO methods for databases //
// MeDoo // 
require_once  'Medoo.php';
use Medoo\Medoo;
$database = new Medoo([
	// required
	'database_type' => 'mysql',
	'database_name' => 'planten',
	'server' => 'localhost',
	'username' => 'root',
	'password' => ''
]);
// PDO //
$host = '127.0.0.1';
$db   = 'planten';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


// Random String Generator for the Image titles //
function generateRandomString($length = 100) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>
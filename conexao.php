<?php 

require __DIR__.'/vendor/autoload.php';

try {
    $dotenvCnx = Dotenv\Dotenv::createUnsafeMutable(__DIR__);
    $dotenvCnx->load();
    $dotenvCnx->required([
        'DB_HOST',
        'DB_NAME',
        'DB_USER',
        'DB_PASS',
        'LDB_HOST',
        'LDB_NAME',
        'LDB_USER',
        'LDB_PASS'
    ]);
} catch (Exception $e) {
    exit('Could not find a .env file DB.');
}

Class Conexao{

	// public $name = DB_NAME;
	// private $host = DB_HOST;
	// private $user = DB_USER;
	// private $password = DB_PASSWORD;

    private $opciones = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    protected $conexao;

	public function open(){

		try {
			// $this->conexao = new PDO ('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME').'', getenv('DB_USER'), getenv('DB_PASS'), $this->opciones);
			$this->conexao = new PDO ('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME').'', getenv('DB_USER'), getenv('DB_PASS'), $this->opciones);
			$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $this->conexao;

		} catch (PDOException $e) {
			echo '<p>' . $e->getMessage().'</p>';
		}
	}

	public function closeConection(){
		$conexao = null;
	}
}

$pdo = new Conexao();


// var_dump($pdo);

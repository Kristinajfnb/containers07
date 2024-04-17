<?php

class Database {
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $this->pdo = new PDO($dsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function execute($sql) {
        return $this->pdo->exec($sql);
    }

    public function fetch($sql) {
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($table, $data) {
        // Реализация метода создания записи в таблице
    }

    public function read($table, $id) {
        // Реализация метода чтения записи из таблицы
    }

    public function update($table, $id, $data) {
        // Реализация метода обновления записи в таблице
    }

    public function delete($table, $id) {
        // Реализация метода удаления записи из таблицы
    }

    public function count($table) {
        // Реализация метода подсчета количества записей в таблице
    }
}

// Параметры подключения к базе данных MySQL
$host = '127.0.0.1';
$dbname = 'asw';
$username = 'root';
$password = '';

// Создаем экземпляр класса Database
$database = new Database($host, $dbname, $username, $password);

// Теперь вы можете использовать объект $database для выполнения операций с базой данных
?>

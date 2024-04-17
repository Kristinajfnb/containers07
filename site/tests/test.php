<?php

require_once __DIR__ . '/testframework.php';

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../modules/database.php';
require_once __DIR__ . '/../modules/page.php';

$testFramework = new TestFramework();

// Test methods of Database class

// Test database connection
function testDbConnection() {
    global $config;
    $db = new Database($config["db"]["path"]);
    return assertExpression($db instanceof Database, 'Database connected', 'Database connection failed');
}

// Test count method
function testDbCount() {
    global $config;
    $db = new Database($config["db"]["path"]);
    $count = $db->count('page');
    return assertExpression($count == 3, 'Count method works correctly', 'Count method failed');
}

// Test create method
function testDbCreate() {
    global $config;
    $db = new Database($config["db"]["path"]);
    $data = array('title' => 'Test Title', 'content' => 'Test Content');
    $id = $db->create('page', $data);
    return assertExpression($id !== false, 'Create method works correctly', 'Create method failed');
}

// Test read method
function testDbRead() {
    global $config;
    $db = new Database($config["db"]["path"]);
    $data = $db->read('page', 1);
    return assertExpression($data !== false, 'Read method works correctly', 'Read method failed');
}

// Test update method
function testDbUpdate() {
    global $config;
    $db = new Database($config["db"]["path"]);
    $data = array('title' => 'Updated Title', 'content' => 'Updated Content');
    $result = $db->update('page', 1, $data);
    return assertExpression($result, 'Update method works correctly', 'Update method failed');
}

// Test delete method
function testDbDelete() {
    global $config;
    $db = new Database($config["db"]["path"]);
    $result = $db->delete('page', 1);
    return assertExpression($result, 'Delete method works correctly', 'Delete method failed');
}

// Test methods of Page class

// Test Page constructor
function testPageConstructor() {
    $page = new Page(__DIR__ . '/../templates/index.tpl');
    return assertExpression($page instanceof Page, 'Page constructor works correctly', 'Page constructor failed');
}

function testPageRender() {
    $data = array('title' => 'Test Title', 'content' => 'Test Content');
    $page = new Page(__DIR__ . '/../templates/index.tpl');
    ob_start();
    $result = $page->render($data);
    $output = ob_get_clean();
    return assertExpression($result !== false && !empty($output), 'Render method works correctly', 'Render method failed');
}


$testFramework->add('Database connection', 'testDbConnection');
$testFramework->add('Table count', 'testDbCount');
$testFramework->add('Data create', 'testDbCreate');
$testFramework->add('Data read', 'testDbRead');
$testFramework->add('Data update', 'testDbUpdate');
$testFramework->add('Data delete', 'testDbDelete');
$testFramework->add('Page constructor', 'testPageConstructor');
$testFramework->add('Page render', 'testPageRender');

// Run tests
$testFramework->run();

echo $testFramework->getResult();

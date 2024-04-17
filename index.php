<?php

require_once __DIR__ . '/modules/database.php';
require_once __DIR__ . '/modules/page.php';

require_once __DIR__ . '/config.php';

// Создание экземпляра класса Database для работы с базой данных
$db = new Database($config["db"]["path"]);

// Создание экземпляра класса Page для работы с страницами
$page = new Page(__DIR__ . '/templates/index.tpl');

// Получение идентификатора страницы из параметра запроса (например, "?page=1")
$pageId = isset($_GET['page']) ? $_GET['page'] : 1;

// Чтение данных о странице из базы данных
$data = $db->Read("page", $pageId);

// Вывод содержимого страницы
echo $page->Render($data);

?>

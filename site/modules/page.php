<?php
$data = array(
    'title' => 'Заголовок страницы',
    'content' => 'Содержимое страницы',
);

$page = new Page('templates/index.tpl');
$page->render($data);

class Page {
    private $template;

    public function __construct($template) {
        $this->template = $template;
    }

    public function render($data) {
        if (file_exists($this->template)) {
            extract($data);
            include $this->template;
        } else {
            echo "Template file not found.";
        }
    }
}

?>


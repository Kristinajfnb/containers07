# Лабораторная работа: Непрерывная интеграция с помощью Github Actions

## Цель работы
В рамках данной работы студенты научатся настраивать непрерывную интеграцию с помощью Github Actions.

## Задание
Создать Web приложение, написать тесты для него и настроить непрерывную интеграцию с помощью Github Actions на базе контейнеров.

## Описание выполнения работы 
1. Создаем директорию site в корневой папке проекта.
2. Внутри директории site создаем поддиректории modules, templates, styles.
3. Создаем файлы database.php, page.php, index.tpl, style.css, config.php, index.php в соответствующих поддиректориях с кодом, как указано в задании.
4. Создаем директорию sql в корневой папке проекта.
5. В директории sql создаем файл schema.sql с указанным содержимым.
CREATE TABLE IF NOT EXISTS page (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT,
    content TEXT
);
INSERT INTO page (title, content) VALUES ('Page 1', 'Content 1');
INSERT INTO page (title, content) VALUES ('Page 2', 'Content 2');
INSERT INTO page (title, content) VALUES ('Page 3', 'Content 3');

6. Создаем директорию tests в корневой папке проекта.
7. В директории tests создаем файл testframework.php с указанным содержимым.
8. Создаем файл test.php в директории tests с указанным содержимым.
9. В файле test.php мы добавляем тесты для всех методов класса Database и Page.
10. В директории .github/workflows создаем файл main.yml.
name: CI

on:
  push:
    branches:
      - main

jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - name: Checkout
        uses: actions/checkout@v4
      - name: Build the Docker image
        run: docker build -t containers07 .
      - name: Create `container`
        run: docker create --name container --volume database:/var/www/db containers07
      - name: Copy tests to the container
        run: docker cp ./tests container:/var/www/html
      - name: Up the container
        run: docker start container
      - name: Run tests
        run: docker exec container php /var/www/html/tests/tests.php
      - name: Stop the container
        run: docker stop container
      - name: Remove the container
        run: docker rm container
11. Создаем Dockerfile файл co следующим содержимым:
FROM php:7.4-fpm as base

RUN apt-get update && \
    apt-get install -y sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo_sqlite

VOLUME ["/var/www/db"]

COPY sql/schema.sql /var/www/db/schema.sql

RUN echo "prepare database" && \
    cat /var/www/db/schema.sql | sqlite3 /var/www/db/db.sqlite && \
    chmod 777 /var/www/db/db.sqlite && \
    rm -rf /var/www/db/schema.sql && \
    echo "database is ready"

COPY site /var/www/html
12. Отправляем все изменения в репозиторий на GitHub, переходим во вкладку Actions в репозитории и дожидаемся окончания выполнения.

## Выводы
Непрерывная интеграция с использованием GitHub Actions позволяет автоматизировать процесс сборки, тестирования и развертывания приложений, что улучшает качество и надежность кода, ускоряет процесс разработки и упрощает его управление.

## Ответы на вопросы
1. Что такое непрерывная интеграция?
   Непрерывная интеграция (Continuous Integration, CI) - это практика разработки программного обеспечения, которая заключается в регулярном объединении всех изменений в исходный код в общий репозиторий, а затем автоматическом запуске процесса сборки, тестирования и развертывания приложения для обеспечения надежности и целостности кода.

2. Для чего нужны юнит-тесты? Как часто их нужно запускать?
   Юнит-тесты используются для проверки отдельных компонентов программного обеспечения (юнитов) на корректность их работы. Они позволяют выявлять ошибки в коде на ранних этапах разработки и обеспечивают уверенность в его надежности. Юнит-тесты рекомендуется запускать после каждого изменения кода.

3. Что нужно изменить в файле .github/workflows/main.yml для того, чтобы тесты запускались при каждом создании запроса на слияние (Pull Request)?
   Для запуска тестов при каждом создании Pull Request в файле .github/workflows/main.yml нужно добавить триггер на событие `pull_request`:

   ```yaml
   on:
     pull_request:
       branches: [ main ]
4. Что нужно добавить в файл .github/workflows/main.yml для того, чтобы удалять созданные образы после выполнения тестов?
   Для удаления созданных Docker-образов после выполнения тестов в файле .github/workflows/main.yml нужно добавить шаг по очистке Docker-окружения. Например:
yaml
Copy code
steps:
name: Run tests
run: |
### Запуск тестов
### Добавить следующий шаг для очистки Docker-окружения
name: Clean up Docker environment
run: docker system prune -f

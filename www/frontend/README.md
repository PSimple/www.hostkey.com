# Hostkey Frontend

Здесь лежит фронтенд-код для hostkey. Разработка и сборка фронтенда происходит в этой папке

Все собранные файлы в результате работы кладутся в папку `hostkey_com_new/assets`


Структура исходников папки src:

```
src
├── hostkey.coffee    # точка входа приложения
├── api               # апи
│   └── api.coffee
├── assets            # ресурсы приложения
│   └── logo.png
├── css
│   ├── hostkey.styl  # стили приложения
│   └── ui            # стили ui
├── env               # переменные окружения
│   └── env.js
└── ui                # ui-компоненты
    ├── accordion
    ├── buttons
    ├── scrollBlock
    └── ui.coffee

```

## 1. Как развернуть проект для работы над фронтенд-частью?


```
cd frontend
npm install
```

## 2. Запуск в режиме разработки

```
npm start # запуск среды для разработки
```

В результате запускается webpack, который следит за изменениями в исходниках в папке `src`.

Собирает их в один файл и кладет в папку доступную из сети `hostkey_com_new/assets`


## 3. Сборка проекта для production-окружения

```
cd frontend
npm run build
```

## Dedicated / service

Шаблон
\hostkey_com_new\application\shop\view\Dedicated\Select.html

Иесто
<div ui-view="solutions"></div>

Меняется на
\hostkey_com_new\frontend\src\dedicated\service\solutions.jade




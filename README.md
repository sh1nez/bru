## Требования:
PHP 7.3 (и выше)
## Установка:
### В консоли с помощью Composer

1. Установите пакетный менеджер [Composer](https://getcomposer.org/) в папке вашего проекта, если до этого момента он еще не был установлен.

2. В консоли выполните команду
```
composer require business-ru/business-online-sdk-php
```

#### Либо
2. В файле composer.json своего проекта

Добавьте строку "business-ru/business-online-sdk-php": "*" в список зависимостей вашего проекта в файле composer.json

```json
    "require": {
        "php": ">=7.3",
        "business-ru/business-online-sdk-php": "*"
```

3. Обновите зависимости проекта. В консоли перейдите в каталог, где лежит composer.json, и выполните команду:
```json
   composer update
```

## Начало работы:

Создайте обьект для работы с API:

```php
	$api = new \bru\api\Client($account, $app_id, $secret, $sleep, $cache);
```

При создании обьекта ему передаются параметры:

- **$account** - Поддомен сайта business.ru. Например для работы с API https://a13344.business.ru/ это __a13344__. В качестве альтернативы допускается передача 
			IP - адреса и порта в формате https://123.456.789.000:1234. Данный параметр является обязательным. Формат - строка (string).
- **$app_id** - ID интеграции. Представляет собой набор цифр, который выдается при создании интеграции. Данный параметр является обязательным. Формат - число (int).
- **$secret** - Секретный ключ. Представляет собой набор символов, который выдается при создании интеграции. Длина - 32 символа. Данный параметр является обязательным. Формат - строка (string).
- **$sleep** - Опция, отвечающая за поведение, в случае превышения лимита запросов к API. Если задан *true* - при превышении лимита запросов скрипт будет ждать снятия ограничения, если *false* - не будет ждать.
			Данный параметр не является обязательным. По умочанию - *false*. Формат булевое (bool).
- **$cache** - Обьект кеширования токенов. Обьект должен реализовать __CacheInterface__ пакета __Psr\SimpleCache__  (PSR-16). Необязательный параметр. В случае если параметр не передан будет использоваться стандартный
			способ кеширования. Подробнее о [Подробнее о PSR-16](https://www.php-fig.org/psr/psr-/)

Запросы к API реализуются путем вызова методов у данного обьекта.

## Запросы:

Запрос к API может быть выполнен двумя способами:
- с помощью метода request()
- c помощью метода requestAll()

### Request($method, $model, $params)

##### $method - Метод запроса

Поддерживаются 4 метода запроса:

- **get** - Запрос на получение записи
- **post** - Запрос на создание записи
- **put** - Запрос на изменение записи
- **delete** - Запрос на удаление записи

Подробнее о методах запроса можно узнать на сайте [документации.](https://developers.business.ru/)

##### $model - Модель

Модель - требуется для указания типа данных для работы
Все поддерживаемые модели можно узнать на сайте [документации.](https://developers.business.ru/)

##### $params - Параметры запроса

Параметры запроса нужны для указания конкретного документа, сортировки, условий выборки и т.д.
Возможные параметры можно узнать на сайте [документации.](https://developers.business.ru/)

### RequestAll($model, $params)

В отличии от предыдущего метода, данный метод выполняет только **get** запросы, но в ответе можно получить неограниченное
количество данных (ограничение __limit__ не действует). 

##### $model - Модель

Модель - требуется для указания типа данных для работы
Все поддерживаемые модели можно узнать на сайте [документации.](https://developers.business.ru/)

##### $params - Параметры запроса

Параметры запроса нужны для указания конкретного документа, сортировки, условий выборки и т.д.
Возможные параметры можно узнать на сайте [документации.](https://developers.business.ru/)

## Работа с веб-хуками

Для работы с веб - хуками у созданного обьекта есть специальный метод - **checkNotification()**

При сравбатываниии веб - хука вы можете вызвать этот метод для проверки подлинности уведомления.

Метод возвращает __true__ если событие прошло проверку, в противном случае вернет __false__

В случае если вам нужен функционал только проверки подлинности хуков, возможно не создавать обьект,
а вызвать статичный метод __Client::check($app_id, $secret)__

Параметры:

- **$app_id** - ID интеграции. Представляет собой набор цифр, который выдается при создании интеграции. Данный параметр является обязательным. Формат - число (int).
- **$secret** - Секретный ключ. Представляет собой набор символов, который выдается при создании интеграции. Длина - 32 символа. Данный параметр является обязательным. Формат - строка (string).

Подробнее о веб - хуках можно узнать на сайте [документации.](https://developers.business.ru/)

## Уведомления

Для отправки уведомления пользователям используется метод **sendNotification()**

Метод принимает в качестве аргумента массив с параметрами уведомления, подробнее можно узнать на сайте [документации.](https://developers.business.ru/)

## Логирование

Библиотека использует стандарт **PSR-3** для логгирования. Для включения логирования нужно у созданного ранее класса вызвать метод __setLogger()__ и передать в качестве аргумента обьект, реализующий интерфейс 

__LoggerInterface__  пакета __Psr\Log__. [Подробнее о PSR-3](https://www.php-fig.org/psr/psr-3/)

### Примеры

```php

//Создаем обьект для работы с API сайта https://a13344.business.ru
$api = new Client('a13344', 2134124, 'CWZf963mlm0srCKXu8LPepSq69uEv6Hf', true);

//Удалить задачу с ID 224
$api->request('delete', 'tasks', ['id' => 224]);

//Создать задачу c описанием 'Задача создана с помощью API'
$api->request('post', 'tasks', ['task_type_id' => 2, 'description' => 'Задача создана с помощью API', 'author_employee_id' => 44224]);

//Вернет все задачи с типом 2
$api->requestAll('tasks', ['task_type_id' => 2]);

//Вернет все товары
$api->requestAll('goods');

//Отправить пользователя 12345 уведомление
$api->sendNotification(['employee_ids' => [12345], 'header' => 'Это заголовок уведомления', 'message' => 'Это текст сообщения']);

```

### Ответ

В массиве ответа 
- ключ __status__ - статус запроса
- ключ __result__ - ответ на запрос

### Примечания

- Для работы библиотеки требуется права на чтение и запись в директории библиотеки.
- При выполнении запроса __requestAll__ нужно понимать, что если например запросить все товары, а товаров бывает очень много, получение ответа может занять продолжительное время.
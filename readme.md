## Пример приложения с широковещанием socket.io на Laravel 5.6

### https://broadcast-laravel-example.local/

![Example Broadcast](https://github.com/vovancho/broadcast-laravel-example/blob/master/project/home.jpg)

Приложение демонстрирует работу широковещателей Laravel. При нажатии кнопки "Новая задача",
создается новая задача с сгенерированным именем. Задача выполняется какое-то время в очереди,
при этом оповещая пользователей по публичному каналу широковещателя о прогрессе выполнения.
Задачу можно отменить в случае ее ожидания в очереди или выполнения.

#### Схема работы

![Broadcast Schema](https://github.com/vovancho/broadcast-laravel-example/blob/master/project/broadcast_schema.png)

### Docker

#### variables.env

В файле `variables.env` находятся настройки для `docker-compose.yml`.

#### docker2boot (Docker ToolBox)

Конфигурация виртуальной машины `docker2boot`:
  - docker-machine stop
  - *Если необходимо, добавить папку **"C:\www"***:
    - vboxmanage sharedfolder add default --name "c/www" --hostpath "C:\www" --automount
  - Добавляем порт ssl  
    - VBoxManage modifyvm "default" --natpf1 "nginx_ssl,tcp,,443,,443"
  - Добавляем порт Echo socket.io  
    - VBoxManage modifyvm "default" --natpf1 "socket.io,tcp,,6001,,6001"
  - *Если необходимо перенаправлять http на https*: 
    - VBoxManage modifyvm "default" --natpf1 "nginx_http,tcp,,80,,80"
  - *Если необходимо, добавить порт для **XDebug***: 
    - VBoxManage modifyvm "default" --natpf1 "xdebug,tcp,,9001,,9001"
  - docker-machine start
  
#### Запуск

```
    docker-compose up -d
    docker-compose exec php-cli php artisan migrate
```

Для работы приложения необходимо запустить прослушивание очередей `default`, `listeners` и сервера веб сокетов Echo.

Запуск очереди `default`:

```
    docker-compose exec php-cli php artisan queue:listen --queue=default
```

Запуск очереди `listeners`:

```
    docker-compose exec php-cli php artisan queue:listen --queue=listeners
```

Запуск Echo сервера для веб сокетов:

```
    docker-compose exec node-socket-io node_modules/.bin/laravel-echo-server start
```

#### Hosts

Добавить в файл `hosts` имена серверов:
  - <IP Docker хоста> broadcast-laravel-example.local
  
#### docker-compose.yml

У сервиса `php-fpm` есть переменная окружения `XDEBUG_CONFIG`. Если нужен XDebug, необходимо вписать ip адрес `remote_host=<ip адрес удаленного xdebug клиента>`.
Если локальный сервер, заменить `remote_host` на `remote_connect_back=1`

#### Redis

В приложении используется `Resis` для кэша, сессий, очередей, широковещателей.
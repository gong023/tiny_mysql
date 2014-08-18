Tiny Mysql
=====================

very very tiny and simple mysql library to execute single query by single connection.

# Install
```javascript
"require-dev": {
    "gong023/tiny_mysql": "dev-master"
}
```

# Usage

```php
$mysqli_result = TinyMysql::execute(
    'mysql query',
    'host to connect',
    'user to connect',
    'password to connect',
    'database to connect',
    'port to connect',
    'socket to connect'
);
```
or
```php
$singleton_connection = TinyMysql::getConnection($host, $user, $password, $database, $port, $socket);
$mysqli_result = $singleton_connection->query('mysql query');
```

Mysql Connection is created before you execute query, and mysql connection is closed after query.

Implementation is very simple and tiny. It is suitable for casual use.

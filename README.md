# Assignment

## Core PHP User Management System

To run application:
```bash
docker-compose up --build
```

## MySQL script
src/dbscripts/user-sql-dump.sql

## URL Examples
Param 'auth_role' is used to imitate user who works with user management system.

Param 'auth_role' could be 'admin', 'user' or 'guest'. 

Other auth_role's values are not authorized to get access to user management system.

### Admin Role
http://localhost:9010/user/create?auth_role=admin

http://localhost:9010/user/update?id=2&auth_role=admin

http://localhost:9010/user/delete?id=2&auth_role=admin

http://localhost:9010/user/list?auth_role=admin

### User
http://localhost:9010/user/list?auth_role=user - authorized

http://localhost:9010/user/create?auth_role=user - not authorized

http://localhost:9010/user/update?id=2&auth_role=user - not authorized

http://localhost:9010/user/delete?id=2&auth_role=user - not authorized

### Guest
http://localhost:9010/user/list?auth_role=guest - authorized

http://localhost:9010/user/create?auth_role=guest - not authorized

http://localhost:9010/user/update?id=2&auth_role=guest - not authorized

http://localhost:9010/user/delete?id=2&auth_role=guest - not authorized

## Data Validation and sanitization
1. Function validate() is called during create and update requests.
 
   User object defines validation rules in validationRules() function. 
   
   According validation rules Validators are called. Validators are in folder src/validators.
2. Using PDO statements to avoid sql injections.

## Dependency injection
It could be done for example for database adapters.

Defining AdapterInterface in di-container.php as MySQLAdapter:
```php
 \Users\models\AdapterInterface::class => function (\DI\Container $container) {
        // 'connection_string', 'username', 'password' could be defined as ENV variables, then use getenv('MYSQL_PASSWORD') here
        return new Users\models\MySQLAdapter('connection_string', 'username', 'password'); 
 },
```
Then inside DBModel
```php
 
    public function __construct(\Users\models\AdapterInterface $storage_adapter)
    {
        $this->storage_adapter = $storage_adapter;
    }
```

## Inheritance Principle
User class is a child of class DBModel. DBModel provides communication with database, validation processing, error handling.
DBModel could be useful for other classes that represent database table. For example, table account - class Account extends DBModel

## Separation of concern
1. MVC is used as Model - User (src/models/User), View - all views in src/views, Controller - UsersController (src/controllers/UsersController)
2. Validators (src/validators) are responsible for validation
3. MySQLAdapter is responsible for MySQL database communication

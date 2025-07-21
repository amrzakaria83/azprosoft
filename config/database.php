<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],
            // 'sqlsrv' => [
            //     'driver'   => 'sqlsrv',
            //     'host'     => env('MSSQL_HOST', '41.33.4.126'),
            //     'port'     => env('MSSQL_PORT', '1433'),
            //     'database' => env('MSSQL_DATABASE', 'Emanger'),
            //     'username' => env('MSSQL_USERNAME', 'sa'),
            //     'password' => env('MSSQL_PASSWORD', '1'),
            // ],
        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_SQLSRV_HOST', '41.33.4.126'),
            'port' => env('DB_SQLSRV_PORT', '1433'),
            'database' => env('DB_SQLSRV_DATABASE', 'Emanger'),
            'username' => env('DB_SQLSRV_USERNAME', 'sa'),
            'password' => env('DB_SQLSRV_PASSWORD', '1'),
            'charset' => 'UTF-8', // 👈 Changed from 'utf8' to 'UTF-8'
            'prefix' => '',
            'retries' => [
                    'max' => env('DB_SQLSRV_RETRIES', 3), // Max reconnection attempts
                    'delay' => 2000, // Delay between attempts in milliseconds
                ],
            // 👇 Force TCP/IP and disable Named Pipes
            'odbc' => true,
            'odbc_datasource_name' => "Driver={ODBC Driver 17 for SQL Server};Server=41.33.4.126,1433;Database=Emanger;",
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::SQLSRV_ATTR_ENCODING => PDO::SQLSRV_ENCODING_UTF8, // 👈 Critical for UTF-8

                // PDO::SQLSRV_ATTR_FETCHES_NUMERIC_TYPE => true,
                // 👇 Disable Named Pipes explicitly
                // PDO::SQLSRV_ATTR_CONNECTION_POOLING => false,
            ],
        ],
        // 'sqlsrv' => [
        //     'driver' => 'sqlsrv',
        //     'url' => env('DATABASE_URL'),
        //     'host' => env('DB_SQLSRV_HOST', 'localhost'),
        //     'port' => env('DB_SQLSRV_PORT', '1433'),
        //     'database' => env('DB_SQLSRV_DATABASE', 'Emanger'),
        //     'username' => env('DB_SQLSRV_USERNAME', 'sa'),
        //     'password' => env('DB_SQLSRV_PASSWORD', '1'),
        //     'charset' => 'utf8',
        //     'prefix' => '',
        //     'prefix_indexes' => true,
        //     'encrypt' => false, // Add this if not using SSL
        //     'trust_server_certificate' => true, // Add this for self-signed certs
        //     'timeout' => env('DB_SQLSRV_TIMEOUT', 30), // Connection timeout in seconds
        //     'options' => [
        //         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //         PDO::SQLSRV_ATTR_FETCHES_NUMERIC_TYPE => true,
        //         PDO::ATTR_CASE => PDO::CASE_NATURAL,
        //         // PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        //         // PDO::ATTR_CASE => PDO::CASE_NATURAL,
        //         // PDO::SQLSRV_ATTR_FETCHES_NUMERIC_TYPE => true,
        //         // PDO::ATTR_TIMEOUT => 30,
        //         // PDO::ATTR_STRINGIFY_FETCHES => false,
        //         // PDO::SQLSRV_ATTR_DIRECT_QUERY => false,
        //         // PDO::ATTR_EMULATE_PREPARES => true,  // Workaround for unsupported PDO attributes
        //         // PDO::ATTR_STRINGIFY_FETCHES => true, // Prevents numeric values from being fetched as strings
        //     ],
        //         'odbc' => true,
        //         'odbc_datasource_name' => "Driver={ODBC Driver 17 for SQL Server};Server=41.33.4.126,1433;Database=Emanger;",
        //      'retries' => [
        //             'max' => env('DB_SQLSRV_RETRIES', 3), // Max reconnection attempts
        //             'delay' => 2000, // Delay between attempts in milliseconds
        //         ],
        //             // Add these for better connection handling
        //         'pooling' => true,
        //         'connection_pooling' => 1,
        //         // 'appname' => env('APP_NAME', 'Laravel') . ' v' . env('APP_VERSION', '1.0'),
        //     // 'encrypt' => env('DB_ENCRYPT', 'yes'),
        //     // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        // ],
        // 'sqlsrv' => [
        //     'driver' => 'sqlsrv',
        //     'host' => env('DB_SQLSRV_HOST', 'localhost'),
        //     'port' => env('DB_SQLSRV_PORT', '1433'),
        //     'database' => env('DB_SQLSRV_DATABASE', 'forge'),
        //     'username' => env('DB_SQLSRV_USERNAME', 'forge'),
        //     'password' => env('DB_SQLSRV_PASSWORD', ''),
        //     'charset' => 'utf8',
        //     'prefix' => '',
        //     'prefix_indexes' => true,
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];

<?php declare(strict_types=1);

namespace App;

namespace App\Provider;

use \App\Interface\Provider;
use \Nette\Database\Connection;

class DatabaseProvider implements Provider
{
    protected $key = 'database';

    protected $settings = [];

    public function __construct()
    {
        $this->settings = [
            'dsn'       => sprintf(
                '%s:dbname=%s;host=%s;port=%s',
                getenv('DB_CONNECTION'),
                getenv('DB_DATABASE'),
                getenv('DB_HOST'),
                getenv('DB_PORT')
            ),
            'user'      => getenv('DB_USERNAME'),
            'password'  => getenv('DB_PASSWORD')
        ];
    }

    public function boot()
    {
        return new Connection(
            $this->settings['dsn'],
            $this->settings['user'],
            $this->settings['password']
        );
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
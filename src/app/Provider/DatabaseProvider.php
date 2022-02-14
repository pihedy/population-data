<?php declare(strict_types=1);

namespace App\Provider;

use \Nette\Caching\Storages\FileStorage;
use \Nette\Database\Connection;
use \Nette\Database\Structure;
use \Nette\Database\Conventions\DiscoveredConventions;
use \Nette\Database\Explorer;

/** 
 * The database provider that maps the app to Nette's database.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
class DatabaseProvider
{
    /**
     * Provider key.
     * 
     * @var string
     */
    protected $key = 'database';

    /**
     * Provider settings.
     * 
     * @var array
     */
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

    /**
     * It awakens the provider's dependencies and returns with them.
     * 
     * @return mixed
     */
    public function boot()
    {
        /** 
         * @var \Nette\Caching\IStorage $FileStorage
         */
        $FileStorage            = new FileStorage(APP_TMP_DIR);

        $Connection             = new Connection(
            $this->settings['dsn'],
            $this->settings['user'],
            $this->settings['password']
        );
        $Structure              = new Structure($Connection, $FileStorage);
        $DiscoveredConventions  = new DiscoveredConventions($Structure);

        return new Explorer(
            $Connection, 
            $Structure, 
            $DiscoveredConventions, 
            $FileStorage
        );
    }

    /**
     * Returns the provider key.
     * 
     * @return string 
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
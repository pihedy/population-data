<?php declare(strict_types=1);

namespace App;

use \App\Interface\Provider;

/** 
 * The App class from which everything starts.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
final class Core
{
    /**
     * A collection container for data.
     * 
     * @var array
     */
    protected $container = [];

    /**
     * A copy of the basis of the app.
     * 
     * @var null|self
     */
    private static $instance = null;

    /**
     * Do Nothing!
     */
    private function __construct()
    {
        /* Do Nothing! */
    }

    /**
     * Do Nothing!
     */
    private function __clone()
    {
        /* Do Nothing */
    }

    /**
     * Points to the container by default.
     * 
     * @param string $key 
     * 
     * @return mixed 
     */
    public function __get(string $key)
    {
        if (!array_key_exists($key, $this->container)) {
            return null;
        }

        return $this->container[$key];
    }

    /**
     * Make a copy if you don't already have one.
     * 
     * @return self 
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Registration of a simple container system.
     * 
     * @param string $provider 
     */
    public function register(string $provider): void
    {
        $Object = new $provider;

        if (!$Object instanceof Provider) {
            throw new \Exception(
                sprintf(
                    'The class (%s) you want to register is not of Provider type!', 
                    $provider
                )
            );
        }

        $this->container[$Object->getKey()] = $Object->boot();
    }

    /**
     * Run baby, run!
     */
    public function run(): void
    {
        /* TODO: ide kell valami route system szerű! */
    }
}

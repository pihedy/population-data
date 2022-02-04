<?php declare(strict_types=1);

namespace App;

/** 
 * The App class from which everything starts.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
final class Core
{
    /**
     * A copy of the basis of the theme.
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
     * Run baby, run!
     */
    public function run(): void
    {
        /* TODO: ide kell valami provider szerű! */
    }
}

<?php declare(strict_types=1);

/** 
 * The file responsible for the basic load.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */

/** 
 * https://www.php.net/manual/en/function.set-time-limit.php
 */
set_time_limit(3600);

/** 
 * @var string App Temp Directory.
 */
define('APP_TMP_DIR', APP_ROOT_DIR . DIRECTORY_SEPARATOR . 'tmp');

/** 
 * @var string App Base Directory.
 */
define('APP_BASE_DIR', APP_SRC_DIR . DIRECTORY_SEPARATOR . 'app');

/** 
 * @var string App Vendor Directory.
 */
define('APP_VENDOR_DIR', APP_BASE_DIR . DIRECTORY_SEPARATOR . 'Vendor');

try {
    /** 
     * Verify Composer installation.
     */
    if (!file_exists(APP_VENDOR_DIR . DIRECTORY_SEPARATOR . 'autoload.php')) {
        throw new \Exception('Autoloader file not found!');
    }

    /** 
     * Invite Composer autoloader.
     */
    require_once APP_VENDOR_DIR . DIRECTORY_SEPARATOR . 'autoload.php';

    /** 
     * Loading environment variables into the global sphere.
     */
    $DotenvRepository = \Dotenv\Repository\RepositoryBuilder::createWithNoAdapters()
        ->addAdapter(\Dotenv\Repository\Adapter\EnvConstAdapter::class)
        ->addWriter(\Dotenv\Repository\Adapter\PutenvAdapter::class)
        ->immutable()
        ->make();

    /** 
     * Set env to project.
     */
    \Dotenv\Dotenv::create($DotenvRepository, APP_ROOT_DIR)->load();

    /**
     * It makes an instance of the core and returns it.
     * 
     * @return \App\Core 
     */
    function Core(): \App\Core
    {
        return \App\Core::getInstance();
    }

    /** 
     * Register a database provider for the app.
     */
    Core()->register(\App\Provider\DatabaseProvider::class);

    /** 
     * If the console part of the app is running, just don't start here.
     */
    if (defined('APP_CONSOLE')) {
        return;
    }

    /** 
     * Run app.
     */
    Core()->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}

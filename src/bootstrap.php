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
} catch (\Exception $e) {
    echo $e->getMessage();
}
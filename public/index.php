<?php declare(strict_types=1);

/** 
 * @package     Population Data.
 * @author      Pihe Edmond <pihedy@gmail.com>.
 */

/** 
 * @var string App Public Directory.
 */
define('APP_PUBLIC_DIR', __DIR__);

/** 
 * @var string App Root Directory.
 */
define('APP_ROOT_DIR', APP_PUBLIC_DIR . DIRECTORY_SEPARATOR . '..');

/** 
 * @var string App Src Directory.
 */
define('APP_SRC_DIR', APP_ROOT_DIR . DIRECTORY_SEPARATOR . 'src');

/** 
 * If it wasn't found then that was it.
 */
if (!file_exists(APP_SRC_DIR . DIRECTORY_SEPARATOR . 'bootstrap.php')) {
    throw new \Exception('Could not find boot file.');
}

/** 
 * @var string Call the bootstrap file.
 */
require_once APP_SRC_DIR . DIRECTORY_SEPARATOR . 'bootstrap.php';

<?php declare(strict_types=1);

namespace App\Interface;

/** 
 * The basic type of commands.
 * 
 * @author Pihe Edmond pihedy@gmail.com>
 */
interface Command
{
    /**
     * The final function of the commands.
     * 
     * @return mixed 
     */
    public function run();
}

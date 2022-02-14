<?php declare(strict_types=1);

namespace App\Interface;

/** 
 * The basic type of providers.
 * 
 * @author Pihe Edmond pihedy@gmail.com>
 */
interface Provider
{
    /**
     * Compile and return the required dependencies.
     * 
     * @return mixed 
     */
    public function boot();

    /**
     * The key to the provider that you can call later.
     * 
     * @return string 
     */
    public function getKey(): string;
}

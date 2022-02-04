<?php declare(strict_types=1);

namespace App\Interface;

interface Provider
{
    public function boot();

    public function getKey(): string;
}

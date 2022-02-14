<?php declare(strict_types=1);

namespace App\Repository;

use \Nette\Database\Table\Selection;

class ContinensRepository
{
    private $Continents;

    public function __construct(Selection $Continents)
    {
        $this->Continents = $Continents;
    }

    public function findById(int $continentId): array
    {
        $Continent = $this->Continents->get($continentId);

        return [
            'id'    => $Continent->continent_id,
            'name'  => $Continent->name
        ];
    }
}

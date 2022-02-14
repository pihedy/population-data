<?php declare(strict_types=1);

namespace App\Repository;

use \Nette\Database\Table\Selection;

class RegionReporitory
{
    private $Regions;

    public function __construct(Selection $Regions)
    {
        $this->Regions = $Regions;
    }

    public function findCountryById(int $id)
    {
        $ContinensRepository = new ContinensRepository(Core()->database->table('regions'));

        $valami = $this->Regions->get($id);

        return [];
    }
}

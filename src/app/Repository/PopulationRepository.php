<?php declare(strict_types=1);

namespace App\Repository;

use \App\Structure\Country;
use \Nette\Database\Table\Selection;

class PopulationRepository
{
    private $Countries;

    public function __construct(Selection $Countries)
    {
        $this->Countries = $Countries;
    }

    public function findCountriesData(): array
    {
        $data = [];

        foreach ($this->Countries as $Country) {
            $data[] = Country::fromActiveRow($Country)
                ->addCountry()
                ->addStats()
                ->getData();
        }

        return $data;
    }
}

<?php declare(strict_types=1);

namespace App\Repository;

use \App\Structure\Country;
use \Nette\Database\Table\Selection;

/** 
 * A simple repository to retrieve the required population data.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
class PopulationRepository
{
    /**
     * @var \Nette\Database\Table\Selection
     */
    private $Countries;

    /**
     * @param Nette\Database\Table\Selection $Countries 
     */
    public function __construct(Selection $Countries)
    {
        $this->Countries = $Countries;
    }

    /**
     * Finds and returns population data through the structure.
     * 
     * @return array 
     */
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

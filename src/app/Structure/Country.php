<?php declare(strict_types=1);

namespace App\Structure;

use \Nette\Database\Table\ActiveRow;

/** 
 * The structure of countries that makes it easier to reach countries.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
class Country
{
    /**
     * @var \Nette\Database\Table\ActiveRow
     */
    protected $Country;

    /**
     * Part of the return value cache.
     * 
     * @var array
     */
    protected $cache = [];

    /**
     * Easier structure of the structure.
     * 
     * @param \Nette\Database\Table\ActiveRow $Country 
     * 
     * @return self 
     */
    public static function fromActiveRow(ActiveRow $Country)
    {
        return new self($Country);
    }

    /**
     * @param mixed $Country 
     */
    private function __construct($Country)
    {
        $this->Country = $Country;
    }

    /**
     * Adds the basic data of the country to the cache.
     * 
     * @return self 
     */
    public function addCountry(): self
    {
        $this->cache = array_merge($this->cache, [
            'name'      => $this->Country->name,
            'region_id' => $this->Country->region_id
        ]);

        return $this;
    }

    /**
     * Country statistics are added to the cache.
     * 
     * @return self 
     */
    public function addStats(): self
    {
        $data = [];

        /** 
         * @var \Nette\Database\Table\ActiveRow $Stat
         */
        foreach ($this->Country->related('country_stats') as $Stat) {
            $data[] = [
                'year'          => $Stat->year,
                'population'    => $Stat->population,
                'gdp'           => $Stat->gdp
            ];
        }

        $this->cache['stats'] = $data;

        return $this;
    }

    /**
     * Return to cache.
     * 
     * @return array 
     */
    public function getData(): array
    {
        return $this->cache;
    }
}

<?php declare(strict_types=1);

namespace App\Structure;

use \Nette\Database\Table\ActiveRow;

class Country
{
    protected $Country;

    protected $cache = [];

    public static function fromActiveRow(ActiveRow $Country)
    {
        return new self($Country);
    }

    private function __construct($Country)
    {
        $this->Country = $Country;
    }

    public function addCountry(): self
    {
        $this->cache = array_merge($this->cache, [
            'name'      => $this->Country->name,
            'region_id' => $this->Country->region_id
        ]);

        return $this;
    }

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

    public function getData(): array
    {
        return $this->cache;
    }
}

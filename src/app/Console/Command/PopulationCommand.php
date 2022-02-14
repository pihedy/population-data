<?php declare(strict_types=1);

namespace App\Console\Command;

use \App\Repository\PopulationRepository;

/** 
 * Calculate and return the population.
 * 
 * @author Pihe Edmond <pihedy@gmail.com>
 */
class PopulationCommand
{
    /**
     * Arguments that it returns from the console.
     * 
     * @var array
     */
    protected $args;

    /**
     * @param array $args 
     */
    public function __construct(array $args)
    {
        $this->args = $args;
    }

    /**
     * This is where the countdown and return take place.
     * 
     * @return mixed 
     */
    public function run()
    {
        $PopulationRepository   = new PopulationRepository(Core()->database->table('countries'));
        $countiesData           = $PopulationRepository->findCountriesData();

        $regionsData            = [];

        foreach ($countiesData as $countryData) {
            if (!array_key_exists('stats', $countryData) || empty($countryData['stats'])) {
                continue;
            }

            $regionsData[$countryData['region_id']][] = $countryData;
        }

        $regionsData = array_map(function (array $regionData) {
            $region = 0;
            $data   = [];

            foreach ($regionData as $country) {
                $region = $country['region_id'];

                foreach ($country['stats'] as $countryStat) {
                    if (!array_key_exists($countryStat['year'], $data)) {
                        $data[$countryStat['year']] = [
                            'pop' => 0,
                            'gdp' => 0
                        ];
                    }


                    $data[$countryStat['year']]['pop'] += $countryStat['population'];
                    $data[$countryStat['year']]['gdp'] += $countryStat['gdp'];
                }
            }

            return [
                'region_id' => $region,
                'data'      => $data
            ];
        }, $regionsData);

        /** 
         * @var \Nette\Database\Table\Selection $Regions
         */
        $Regions    = Core()->database->table('regions');

        /** 
         * @var \Nette\Database\Table\Selection $Continents
         */
        $Continents = Core()->database->table('continents');
        $result     = [];

        foreach ($regionsData as $regionDataIndex => $regionData) {
            $Continent = $Continents->get(
                $Regions->get($regionData['region_id'])->continent_id
            );

            $ContId             = $Continent->continent_id;
            $result[$ContId]    = [
                'name' => $Continent->name
            ];

            $i      = 0;
            $c      = 0;
            $l      = count($regionData['data']);
            $sum    = [];

            foreach ($regionData['data'] as $regionKey => $regionValue) {
                if (!array_key_exists($i, $sum)) $sum[$i] = ['pop' => 0, 'gdp' => 0]; 

                if ($c == 0) {
                    $sum[$i]['from'] = $regionKey;
                }

                if ($c == 10 || $c == $l) {
                    $sum[$i]['to'] = $regionKey;
                }

                $sum[$i]['pop'] += $regionValue['pop'];
                $sum[$i]['gdp'] += $regionValue['gdp'];

                $c++;

                if ($c > 10 || $c == $l) {
                    $i++;
                    $c = 0;
                }
            }

            $result[$ContId]['data'] = $sum;
        }

        $display = '';

        foreach ($result as $continentData) {
            $display .= "{$continentData['name']}:\r\n";

            foreach ($continentData['data'] as $data) {
                $display .= "From {$data['from']} to {$data['to']} -> Population: {$data['pop']}, GDP: {$data['gdp']}\r\n";
            }

            $display .= "-----------------------------------\r\n";
        }

        return $display;
    }
}

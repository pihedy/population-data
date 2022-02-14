<?php declare(strict_types=1);

namespace App\Console\Command;

use \App\Interface\Command;
use \App\Repository\PopulationRepository;
use App\Repository\ContinensRepository;

class PopulationCommand implements Command
{
    protected $args;

    public function __construct(array $args)
    {
        $this->args = $args;
    }

    public function run()
    {
        $PopulationRepository   = new PopulationRepository(Core()->database->table('countries'));
        $ContinensRepository    = new ContinensRepository(Core()->database->table('regions'));
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

        return 'kecske';
    }
}

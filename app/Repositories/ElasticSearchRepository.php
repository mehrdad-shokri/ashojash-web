<?php
namespace app\Repository;


use App\City;
use App\Location;
use App\Street;
use App\Venue;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Collection;

class ElasticSearchRepository implements SearchRepository
{

    public function suggestVenue($name, City $city)
    {
        $client = ClientBuilder::create()->build();
        $venueIds = Location::where('city_id', $city->getKey())
            ->pluck('venue_id');
        $params = [
            'index' => 'ashojash',
            'type' => 'venues',
            'body' => [
                'query' =>
                    [
                        "match" => [
                            'name' => $name
                        ]
                    ]
            ]
        ];
        $results = $client->search($params);
        $keys = collect($results['hits']['hits'])
            ->pluck('_id')
            ->values()
            ->all();
        $models = Venue::whereIn('id', $keys)->get()->keyBy('id');
        return $models;
    }

    public function searchVenue($name, City $city)
    {
        return Venue::search($name)->get();
    }

    public function suggestStreet($name, City $city)
    {
        $client = ClientBuilder::create()->build();
        $params = [
            'index' => 'ashojash',
            'type' => 'streets',
            'body' => [
                'query' =>
                    [
                        "match" => [
                            'name_suggest' => $name
                        ]
                    ]
            ]
        ];
        $results = $client->search($params);
        return $this->mapStreetsToCollection($results);
    }

    public function searchStreet($name, City $city)
    {
        $client = ClientBuilder::create()->build();
        $params = [
            'index' => 'ashojash',
            'type' => 'streets',
            'body' => [
                'query' =>
                    [
                        "bool" => [
                            "must" => [
                                "match" => [
                                    'name' => [
                                        'query' => $name,
                                        "minimum_should_match" => "10%",
                                    ]
                                ]
                            ]
                        ]
                    ]
            ]
        ];
        $results = $client->search($params);
        return $this->mapStreetsToCollection($results);
    }

    /**
     * Map the given results to instances of the given model.
     *
     * @param  mixed $results
     * @return Collection
     */
    public function mapStreetsToCollection($results)
    {
        if (count($results['hits']) === 0) {
            return Collection::make();
        }

        $keys = collect($results['hits']['hits'])
            ->pluck('_id')
            ->values()
            ->all();
        $models = Street::whereIn(
            "OGR_FID", $keys
        )->get()->keyBy("OGR_FID");
        return Collection::make($results['hits']['hits'])->map(function ($hit) use ($models) {
            return $models[$hit['_source']['OGR_FID']];
        });
    }
}
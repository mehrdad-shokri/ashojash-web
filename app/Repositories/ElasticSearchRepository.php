<?php
namespace app\Repository;


use App\City;
use App\Location;
use App\Street;
use App\Venue;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Collection;

class ElasticSearchRepository implements SearchRepository {

	public function suggestVenue($name)
	{
		$client = ClientBuilder::create()->build();
		$params = [
			'index' => 'ashojash',
			'type' => 'venues',
			'body' => [
				'query' => [
					"match" => [
						'name_suggest' => [
							'query' => $name
						]
					]
				],
			]
		];
		$results = $client->search($params);
		return $this->mapVenuesToCollection($results);
	}

	public function searchVenue($name)
	{
		$client = ClientBuilder::create()->build();
		$params = [
			'index' => 'ashojash',
			'type' => 'venues',
			'body' => [
				'query' => [
					'dis_max' => [
						'queries' => [
							[
								"match" => [
									'name' => [
										'query' => $name,
										'boost' => 100
									]
								]
							],
							[
								'nested' => [
									'path' => 'tags',
									'query' => [
										'function_score' => [
											'functions' => [
												[
													'field_value_factor' => [
														"field" => "tags.weight"
													]
												]
											],
											'query' => [
												'match' => [
													'tags.name' => $name
												]
											],
											'boost_mode' => 'replace',
											'score_mode' => 'max'
										]
									],
									'score_mode' => 'max'
								]
							]
						]
					]
				],
			]
		];
		$results = $client->search($params);
		return $this->mapVenuesToCollection($results);
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
						"bool" => [
							"must" => [
								"match" => [
									'name_suggest' => [
										'query' => $name,
										"minimum_should_match" => "80%",
									]
								]
							],
							'filter' => [
								['term' => ['city_id' => $city->getKey()]]
							]
						]
					]
			]
		];
		$results = $client->search($params);
		return $this->mapStreetsToCollection($results, $city);
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
										"minimum_should_match" => "80%",
									]
								]
							],
							'filter' => [
								['term' => ['city_id' => $city->getKey()]]
							]
						]
					]
			]
		];
		$results = $client->search($params);
		return $this->mapStreetsToCollection($results, $city);
	}

	/**
	 * Map the given results to instances of the given model.
	 *
	 * @param  mixed $results
	 * @return Collection
	 */
	public function mapStreetsToCollection($results)
	{
		if (count($results['hits']['hits']) === 0)
		{
			return Collection::make();
		}
		$keys = collect($results['hits']['hits'])
			->pluck('_id')
			->values()
			->all();
		$idsImploded = implode(',', $keys);
		$models = Street::whereIn(
			"OGR_FID", $keys
		)->orderByRaw("field(OGR_FID,{$idsImploded})", $keys)->get()->keyBy("OGR_FID");
		return $models;
	}

	/**
	 * Map the given results to instances of the given model.
	 *
	 * @param  mixed $results
	 * @return Collection
	 */
	public function mapVenuesToCollection($results)
	{
		if (count($results['hits']['hits']) === 0)
		{
			return Collection::make();
		}
		$keys = collect($results['hits']['hits'])
			->pluck('_id')
			->values()
			->all();
		$idsImploded = implode(',', $keys);
		$models = Venue::whereIn(
			"id", $keys
		)->orderByRaw("field(id,{$idsImploded})", $keys)->get()->keyBy("id");
		return $models;
	}
}
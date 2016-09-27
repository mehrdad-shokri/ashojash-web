<?php namespace App\Api;


namespace App\Api;


use League\Fractal\Serializer\ArraySerializer;

class NoDataArraySerializer extends ArraySerializer {

	/**
	 * Serialize a collection.
	 * @param string $resourceKey
	 * @param array $data
	 * @return array
	 */
	public function collection($resourceKey, array $data)
	{
		return ($resourceKey) ? [$resourceKey => $data] : $data;
	}

	/**
	 * Serialize an item.
	 * @param string $resourceKey
	 * @param array $data
	 * @return array
	 */
	public function item($resourceKey, array $data)
	{
		return ($resourceKey) ? [$resourceKey => $data] : $data;
	}
}
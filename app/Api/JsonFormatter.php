<?php

namespace App\Api;


use Dingo\Api\Http\Response\Format\Json;

class JsonFormatter extends Json {

	/**
	 * Encode the content to its JSON representation.
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	protected function encode($content)
	{
//		if (array_key_exists(['meta']['pagination']['links'], $content))
		if (isset($content['meta']['pagination']['links']))
			$content['meta']['pagination']['links'] = (object) $content['meta']['pagination']['links'];
		return json_encode($content);
	}
}
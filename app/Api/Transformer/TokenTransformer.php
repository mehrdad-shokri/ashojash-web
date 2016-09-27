<?php

namespace App\Api\Transformer;


use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;

class TokenTransformer extends TransformerAbstract {


	public function transform(Token $token)
	{
        JWTAuth::setToken($token);
        return [
			'token' => $token->get(),
			'ttlRefresh' => config("jwt.refresh_ttl"),
			'ttl' => (int)config("jwt.ttl"),
			'exp' => JWTAuth::getPayload()['exp']
		];
	}
}
<?php

namespace App\Api\Transformer;


use App\Street;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;

class StreetTransformer extends TransformerAbstract
{


    public function transform(Street $street)
    {
        return [
            'name' => $street->name
        ];
    }
}
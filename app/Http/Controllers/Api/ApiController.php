<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller {

	protected $statusCode = 200;

	/**
	 * @return mixed
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * @return jwtToken
	 */
	public function getJwtToken()
	{

	}

	/**
	 * @param mixed $statusCode
	 * @return $this
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	public function respondNotFound($message = 'Not found')
	{
		return $this->setStatusCode(404)->respondWithError($message);
	}

	public function respondWithError($message)
	{
		return $this->response([
			'error' => [
				'message' => $message,
				'code' => $this->getStatusCode()
			]
		]);
	}

	public function response($data, $headers = [])
	{
		return response($data, $this->getStatusCode(), $headers);
//			return Response::json($data, $this->getStatusCode(), $headers);
	}

	/**
	 * @param LengthAwarePaginator $paginator
	 * @param $data
	 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
	 */
	public function respondWithPagination(LengthAwarePaginator $paginator, $data)
	{
//		dd($data);
		$data = array_merge(['items' => $data], ['paginator' => [
			'total_count' => $paginator->total(),
			'total_page' => ceil($paginator->total() / $paginator->perPage()),
			'current_page' => $paginator->currentPage(),
			'limit' => $paginator->perPage(),
		]
		]);
		return $this->response(['data' => $data]);
	}

	public function respondTokenExpired()
	{

	}

	public function respondTokenInvalid()
	{

	}
}

<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-16 15:43:16
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Exception;
use Illuminate\Http\Response;

class ApiController
{
	/**
	 * @param Exception $e 
	 * @return Response 
	 */
	public function responseException(\Exception $e)
	{
		$code = $e->getCode();
		$devMessage = $e->getMessage() . '. On file ' . $e->getFile() . ' line ' . $e->getLine();
		$userMessage = $e->getMessage();
		$errorFormat = [
			'status' => $code,
			'developer_message' => $devMessage,
			'user_message' => $userMessage,
		];
		$response = new Response(json_encode($errorFormat));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	/**
	 * @param mixed $data 
	 * @return Response 
	 */
	public function responseData($data, $code = 200)
	{
		$response = new Response(json_encode($data), $code);
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}
}

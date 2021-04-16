<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jakmall\Recruitment\Calculator\Drivers\HistoryDriverInterface;
use Jakmall\Recruitment\Calculator\Handler\AddHandler;
use Jakmall\Recruitment\Calculator\Handler\DivideHandler;
use Jakmall\Recruitment\Calculator\Handler\MultiplyHandler;
use Jakmall\Recruitment\Calculator\Handler\PowHandler;
use Jakmall\Recruitment\Calculator\Handler\SubHandler;
use Jakmall\Recruitment\Calculator\Handler\Handler;
use Jakmall\Recruitment\Calculator\Http\Controller\ApiController;

class CalculatorController extends ApiController
{
    private $driver;

    public function __construct(HistoryDriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param mixed $command 
     * @param Request $request 
     * @return Response|void 
     */
    public function calculate($command, Request $request)
    {
        try {
            /** @var Handler */
            $handler = null;
            $valid = $request->all();
            switch (strtolower($command)) {
                case 'add':
                    $handler = new AddHandler($valid['input'], $this->driver);
                    break;
                case 'pow':
                case 'power':
                    $handler = PowHandler::fromInputs($valid['input'], $this->driver);
                    break;
                case 'multiply':
                    $handler = new MultiplyHandler($valid['input'], $this->driver);
                    break;
                case 'sub':
                case 'subtract':
                    $handler = new SubHandler($valid['input'], $this->driver);
                    break;
                case 'divide':
                    $handler = new DivideHandler($valid['input'], $this->driver);
                    break;
            }
            if (is_null($handler)) {
                throw new \Exception("Invalid calculator operation", 422);
            }
            $data = $handler->handle();
            return $this->responseData($data);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

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
}

<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Http\Request;
use Jakmall\Recruitment\Calculator\Drivers\HistoryDriverInterface;
use Jakmall\Recruitment\Calculator\Handler\HistoryHandler;

class HistoryController extends ApiController
{
    private $driver;

    public function __construct(HistoryDriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function index(Request $request)
    {
        try {
            $repo = $this->driver->make($request->get('driver'));
            $handler = new HistoryHandler($repo);
            $data = $handler->handle();
            return $this->responseData($data);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function show($id, Request $request)
    {
        try {
            $repo = $this->driver->make($request->get('driver'));
            $handler = new HistoryHandler($repo);
            $data = $handler->getById($id);
            if (is_null($data)) {
                throw new \Exception("Data with ID $id not found", 422);
            }
            return $this->responseData($data);
        } catch (\Exception $e) {
            return $this->responseException($e);
        }
    }

    public function remove()
    {
        // todo: modify codes to remove history
        dd('create remove history logic here');
    }
}

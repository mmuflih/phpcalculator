<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-15 15:46:46
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Drivers;

use Illuminate\Support\Arr;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Jakmall\Recruitment\Calculator\Services\CompositeHistoryService;
use Jakmall\Recruitment\Calculator\Services\FileHistoryService;
use Jakmall\Recruitment\Calculator\Services\LatestHistoryService;

class HistoryDriver implements HistoryDriverInterface
{
    private $drivers = [];

    public function make($name): CommandHistoryManagerInterface
    {
        $repo = Arr::get($this->drivers, $name);

        if ($repo) {
            return $repo;
        }

        $createMethod = 'create' . ucfirst($name) . 'HistoryService';
        if (!method_exists($this, $createMethod)) {
            $createMethod = 'createCompositeHistoryService';
            $repo = $this->{$createMethod}();
        } else {
            $repo = $this->{$createMethod}();
        }


        $this->drivers[$name] = $repo;

        return $repo;
    }

    public function createFileHistoryService(): FileHistoryService
    {
        return new FileHistoryService();
    }

    public function createLatestHistoryService(): LatestHistoryService
    {
        return new LatestHistoryService();
    }

    public function createCompositeHistoryService(): CompositeHistoryService
    {
        return new CompositeHistoryService();
    }
}

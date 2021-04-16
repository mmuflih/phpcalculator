<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-15 15:46:46
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Drivers;

use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;

interface HistoryDriverInterface
{
    public function make($name): CommandHistoryManagerInterface;
}

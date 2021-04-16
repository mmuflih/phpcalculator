<?php

use Jakmall\Recruitment\Calculator\Commands\AddCommand;
use Jakmall\Recruitment\Calculator\Commands\DivideCommand;
use Jakmall\Recruitment\Calculator\Commands\HistoryClearCommand;
use Jakmall\Recruitment\Calculator\Commands\HistoryListCommand;
use Jakmall\Recruitment\Calculator\Commands\MultiplyCommand;
use Jakmall\Recruitment\Calculator\Commands\PowCommand;
use Jakmall\Recruitment\Calculator\Commands\SubCommand;

return [
    AddCommand::class,
    SubCommand::class,
    MultiplyCommand::class,
    DivideCommand::class,
    PowCommand::class,
    HistoryClearCommand::class,
    HistoryListCommand::class,
];

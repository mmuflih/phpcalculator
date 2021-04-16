<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-14 06:08:14
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Drivers\HistoryDriverInterface;
use Jakmall\Recruitment\Calculator\Models\CalculatorData;

class AddCommand extends Command
{
	protected $signature = "add {numbers*}";

	protected $description = "This command is used to add all given numbers, and accepts an endless number of inputs as its arguments";

	private $driver;

	public function __construct(HistoryDriverInterface $driver)
	{
		$this->driver = $driver;
		parent::__construct();
	}

	public function handle()
	{
		$args = $this->arguments();
		$results = 0;
		foreach ($args['numbers'] as $arg) {
			$results += (int)$arg;
		}

		$operation = implode(" + ", $args['numbers']);
		$data = CalculatorData::createNew("add", $operation, $results);
		$data->print();
		$this->driver->make(null)->log($data->toCsv());
	}
}

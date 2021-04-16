<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-13 14:54:14
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;
use Jakmall\Recruitment\Calculator\Drivers\HistoryDriverInterface;
use Jakmall\Recruitment\Calculator\Models\CalculatorData;

class PowCommand extends Command
{
	protected $signature = "power {base} {exp}";

	protected $description = "This command is used to calculate the exponent of the given numbers, accepts only two arguments as its input (base, exponent)";

	private $driver;

	public function __construct(HistoryDriverInterface $driver)
	{
		$this->driver = $driver;
		parent::__construct();
	}

	public function handle()
	{
		$base = $this->argument('base');
		$exp = $this->argument('exp');
		$results = $base ** $exp;

		$operation = "$base ^ $exp";
		$data = CalculatorData::createNew("power", $operation, $results);
		$data->print();
		$this->driver->make(null)->log($data->toCsv());
	}
}

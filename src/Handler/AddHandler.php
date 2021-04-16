<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-14 06:00:37
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Handler;

use Jakmall\Recruitment\Calculator\Models\CalculatorData;

class AddHandler implements Handler
{
	private $numbers;
	private $driver;

	public function __construct($numbers, $driver)
	{
		$this->numbers = $numbers;
		$this->driver = $driver;
	}

	/** @return CalculatorData  */
	public function handle()
	{
		$results = 0;
		foreach ($this->numbers as $arg) {
			$results += (int)$arg;
		}

		$operation = implode(" + ", $this->numbers);
		$data = CalculatorData::createNew("add", $operation, $results);
		$this->driver->make(null)->log($data->toCsv());
		return $data;
	}
}

<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-14 06:01:08
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Handler;

use Jakmall\Recruitment\Calculator\Models\CalculatorData;

class PowHandler
{
	private $base;
	private $exp;
	private $driver;

	public function __construct($base, $exp, $driver)
	{
		$this->base = $base;
		$this->exp = $exp;
		$this->driver = $driver;
	}

	/** @return CalculatorData  */
	public function handle()
	{
		$results = $this->base ** $this->exp;

		$operation = "$this->base ^ $this->exp";
		$data = CalculatorData::createNew("power", $operation, $results);
		$this->driver->make(null)->log($data->toCsv());
		return $data;
	}
}

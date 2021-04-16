<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-16 15:54:35
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Handler;

use Jakmall\Recruitment\Calculator\Models\CalculatorData;

class HistoryHandler implements Handler
{
	private $repo;

	public function __construct($repo)
	{
		$this->repo = $repo;
	}

	/** @return mixed  */
	public function handle()
	{
		$histories = [];
		$items = $this->repo->findAll();
		foreach ($items as $item) {
			$histories[] = CalculatorData::fromCsv($item);
		}
		return $histories;
	}
}

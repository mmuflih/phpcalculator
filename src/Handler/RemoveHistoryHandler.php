<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-16 17:03:35
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Handler;

use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;
use Jakmall\Recruitment\Calculator\Models\CalculatorData;

class RemoveHistoryHandler implements Handler
{
	private $repo;

	public function __construct(CommandHistoryManagerInterface $repo)
	{
		$this->repo = $repo;
	}

	/** @return mixed  */
	public function handle()
	{
		return $this->repo->clearAll();
	}

	public function removeById($id)
	{
		return $this->repo->clear($id);
	}
}

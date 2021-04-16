<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-16 09:13:54
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Services;

use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;

class CompositeHistoryService implements CommandHistoryManagerInterface
{
	private $fileService;
	private $latestService;

	public function __construct()
	{
		$this->fileService = new FileHistoryService();
		$this->latestService = new LatestHistoryService();
	}

	public function findAll(): array
	{
		$latests = [];
		$items = $this->fileService->findAll();
		for ($i = 0; $i < count($items); $i++) {
			$latests[] = $items[$i];
		}
		return $latests;
	}

	public function find($id)
	{
		$data = $this->latestService->find($id);
		if (is_null($data)) {
			$data = $this->fileService->find($id);
		}
		if (is_null($data)) {
			return null;
		}
		return $data;
	}

	public function log($command): bool
	{
		$return = $this->fileService->log($command);
		return $return && $this->latestService->log($command);
	}

	public function clear($id): bool
	{
		$return = $this->fileService->clear($id);
		return $return && $this->latestService->clear($id);
	}

	public function clearAll(): bool
	{
		$return = $this->fileService->clearAll();
		return $return && $this->latestService->clearAll();
	}
}

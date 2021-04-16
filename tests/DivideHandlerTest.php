<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-16 17:31:51
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Tests;

use Jakmall\Recruitment\Calculator\Drivers\HistoryDriver;
use Jakmall\Recruitment\Calculator\Handler\DivideHandler;
use PHPUnit\Framework\TestCase;

class DivideHandlerTest extends TestCase
{
	public function testCalculation()
	{
		$bils = [];
		for ($i = 0; $i < 2; $i++) {
			$bils[] = rand(1, 200);
		}

		$chmmi = $this->createMock("Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface");
		$driverMock = $this->createStub(HistoryDriver::class);
		$driverMock->method('make')
			->willReturn($chmmi);

		$handler = new DivideHandler($bils, $driverMock);
		$data = $handler->handle();

		$result = $bils[0] / $bils[1];
		$this->assertEquals("divide", $data->command);
		$this->assertEquals($result, $data->result);
		$this->assertEquals($bils, json_decode($data->input));
	}
}

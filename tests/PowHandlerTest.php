<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-16 17:31:51
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Tests;

use Jakmall\Recruitment\Calculator\Drivers\HistoryDriver;
use Jakmall\Recruitment\Calculator\Handler\PowHandler;
use PHPUnit\Framework\TestCase;

class PowHandlerTest extends TestCase
{
	public function testCalculation()
	{
		$base = rand(1, 10);
		$exp = rand(10, 100);

		$chmmi = $this->createMock("Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface");
		$driverMock = $this->createStub(HistoryDriver::class);
		$driverMock->method('make')
			->willReturn($chmmi);

		$handler = new PowHandler($base, $exp, $driverMock);
		$data = $handler->handle();

		$result = $base ** $exp;
		$this->assertEquals("power", $data->command);
		$this->assertEquals($result, $data->result);
		$this->assertEquals([$base, $exp], json_decode($data->input));
	}
}

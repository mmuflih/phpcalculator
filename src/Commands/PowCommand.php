<?php

/**
 * Created by Muhammad Muflih Kholidin
 * at 2021-04-13 14:54:14
 * https://github.com/mmuflih
 * muflic.24@gmail.com
 **/

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class PowCommand extends Command
{
	protected $signature = "power {base} {exp}";

	protected $description = "This command is used to calculate the exponent of the given numbers, accepts only two arguments as its input (base, exponent)";

	public function handle()
	{
		$base = $this->argument('base');
		$exp = $this->argument('exp');
		$results = $base ** $exp;

		echo "$base ^ $exp = " . $results . PHP_EOL;
	}
}

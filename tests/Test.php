<?php

namespace Sinergi\BrowserDetector\Tests;

use PHPUnit\Framework\TestCase;
use Sinergi\BrowserDetector\{Browser, Device, Os};
use SimpleXmlElement;

class BrowserDetectorTest extends TestCase
{
	public static function data()
	{
		$collection = array();
		$xml = new SimpleXmlElement(file_get_contents(__DIR__ . '/data.xml'));
		foreach ($xml->strings->string as $string) {
			[$browser, $browserVersion, $os, $osVersion, $device, $deviceVersion, $string] = $string->field;
			$collection[] = [(string) $browser, (string) $browserVersion, (string) $os, (string) $osVersion, (string) $device, (string) $deviceVersion, str_replace(array("\n", '  '), ' ', (string)$string)];
		}

		return $collection;
	}

	/**
	 * @dataProvider data
	 */
	public function test(string $browser, string $browserVersion, string $os, string $osVersion, string $device, string $deviceVersion, string $string)
	{
		$browserObj = new Browser($string);
		$this->assertSame($browser, $browserObj->getName());
		$this->assertSame($browserVersion, $browserObj->getVersion());
		$osObj = new Os($string);
		$this->assertSame($os, $osObj->getName());
		$this->assertSame($osVersion, $osObj->getVersion());
		$deviceObj = new Device($string);
		$this->assertSame($device, $deviceObj->getName());
	}
}

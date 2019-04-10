<?php
namespace gendiff\Tests;

use function gendiff\genDiff\genDiff;
use PHPUnit\Framework\TestCase;

class jsonDiffTest extends TestCase
{
    public function testJsonDiff()
    {
        $firstFilePath = __DIR__ . '/cases/before.json';
        $secondFilePath = __DIR__ . '/cases/after.json';
        $result = "    host: hexlet.io
  - timeout: 50
  + timeout: 20
  - proxy: 123.234.53.22
  + verbose: 1";
        $tested= genDiff(
		json_decode(file_get_contents($firstFilePath), true),
		json_decode(file_get_contents($secondFilePath), true)
		);
        $this->assertEquals($result, $tested);
    }
}

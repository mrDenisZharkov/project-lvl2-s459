<?php
namespace gendiff\Tests;

use function gendiff\genDiff\genDiff;
use function gendiff\Cli\getFileData;
use PHPUnit\Framework\TestCase;

class JsonDiffTest extends TestCase
{
    public function testJsonDiff()
    {
        $beforeFilePath = __DIR__ . '/cases/before.json';
        $afterFilePath = __DIR__ . '/cases/after.json';
        $resultFilePath = __DIR__ . '/cases/result.txt';
        $expected = file_get_contents($resultFilePath);
        $tested = genDiff($beforeFilePath, $afterFilePath);
        $this->assertEquals($tested, $expected);
    }
}

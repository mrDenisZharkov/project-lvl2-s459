<?php
namespace gendiff\Tests;

use function gendiff\genDiff\genDiff;
use PHPUnit\Framework\TestCase;

class JsonDiffTest extends TestCase
{
    public function testJsonDiff()
    {
        $beforeFilePath = __DIR__ . '/cases/json/before.json';
        $afterFilePath = __DIR__ . '/cases/json/after.json';
        $resultFilePath = __DIR__ . '/cases/json/result.txt';
        $expected = file_get_contents($resultFilePath);
        $tested = genDiff($beforeFilePath, $afterFilePath);
        $this->assertEquals($tested, $expected);
    }
    public function testYamlDiff()
    {
        $beforeFilePath = __DIR__ . '/cases/yaml/before.yaml';
        $afterFilePath = __DIR__ . '/cases/yaml/after.yaml';
        $resultFilePath = __DIR__ . '/cases/yaml/result.txt';
        $expected = file_get_contents($resultFilePath);
        $tested = genDiff($beforeFilePath, $afterFilePath);
        $this->assertEquals($tested, $expected);
    }
}

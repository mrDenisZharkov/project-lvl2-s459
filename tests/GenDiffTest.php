<?php
namespace gendiff\Tests;

use function gendiff\DiffMaker\genDiff;
use PHPUnit\Framework\TestCase;

class DiffTest extends TestCase
{
    public function testDiff()
    {
        $converFormats = ['', 'plain'];
        foreach ($converFormats as $converFormat) {
            $catalogCasesPath = __DIR__ . "/cases";
            $filetypeDirectories = array_diff(scandir($catalogCasesPath), [".", ".."]);
            foreach ($filetypeDirectories as $filetype) {
                $catalogPath = "$catalogCasesPath/{$filetype}";
                $testCases = array_diff(scandir($catalogPath), [".", ".."]);
                foreach ($testCases as $i) {
                    $beforeFilePath = "{$catalogPath}/{$i}/before.{$filetype}";
                    $afterFilePath = "{$catalogPath}/{$i}/after.{$filetype}";
                    $resultFilePath = "{$catalogPath}/{$i}/result{$converFormat}.txt";
                    print_r("check in {$catalogPath}/{$i}" . PHP_EOL);
                    $expected = file_get_contents($resultFilePath);
                    $tested = genDiff($beforeFilePath, $afterFilePath, $converFormat);
                    $this->assertEquals($tested, $expected);
                }
            }
        }
    }
}

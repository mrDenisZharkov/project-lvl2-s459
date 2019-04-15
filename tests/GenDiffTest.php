<?php
namespace gendiff\Tests;

use function gendiff\DiffMaker\genDiff;
use PHPUnit\Framework\TestCase;

class DiffTest extends TestCase
{
    public function testDiff()
    {
        $convertFormats = ['pretty', 'plain', 'json'];
        foreach ($convertFormats as $convertFormat) {
            $catalogCasesPath = __DIR__ . "/cases";
            $filetypeDirectories = array_diff(scandir($catalogCasesPath), [".", ".."]);
            foreach ($filetypeDirectories as $filetype) {
                $catalogPath = "$catalogCasesPath/{$filetype}";
                $testCases = array_diff(scandir($catalogPath), [".", ".."]);
                foreach ($testCases as $i) {
                    $beforeFilePath = "{$catalogPath}/{$i}/before.{$filetype}";
                    $afterFilePath = "{$catalogPath}/{$i}/after.{$filetype}";
                    $resultFilePath = "{$catalogPath}/{$i}/result{$convertFormat}.txt";
                    print_r("check in tests/cases/{$filetype}/{$convertFormat}/{$i} convert to '{$convertFormat}' format" . PHP_EOL);
                    $expected = file_get_contents($resultFilePath);
                    $tested = genDiff($beforeFilePath, $afterFilePath, $convertFormat);
                    $this->assertEquals($tested, $expected);
                }
            }
        }
    }
}

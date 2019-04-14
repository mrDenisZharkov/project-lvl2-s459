<?php
namespace gendiff\Tests;

use function gendiff\Cli\runGenDiff;
use PHPUnit\Framework\TestCase;

class DiffTest extends TestCase
{
    public function testDiff()
    {
        $convertFormats = ['', 'plain'];
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
                    print_r("check in {$catalogPath}/{$i}" . PHP_EOL);
                    $expected = file_get_contents($resultFilePath);
                    $tested = runGenDiff($beforeFilePath, $afterFilePath, $convertFormat);
                    $this->assertEquals($tested, $expected);
                }
            }
        }
    }
}

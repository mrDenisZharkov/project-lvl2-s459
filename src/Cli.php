<?php
namespace gendiff\Cli;
use function gendiff\DiffMaker\genDiff;

function genCli()
{
    $help = <<<DOC
Generate diff
Usage:
  gendiff (-h|--help)
  gendiff [--format <fmt>] <firstFile> <secondFile>
Options:
  -h --help                     Show this screen
  --format <fmt>                Report format [default: pretty]
DOC;

    return $help;
}

function run()
{
    $arguments = \Docopt::handle(genCli());
    $beforeFile = $arguments['<firstFile>'];
    $afterFile = $arguments['<secondFile>'];
    $outputFormat = $arguments['--format'] ?? 'pretty';
    print_r(runGenDiff($beforeFile, $afterFile, $outputFormat));
}

function runGenDiff($beforeFilePath, $afterFilePath, $outputFormat)
{
    $beforeData = file_get_contents($beforeFilePath);
    $afterData = file_get_contents($afterFilePath);
    $firstExtension = pathinfo($beforeFilePath, PATHINFO_EXTENSION);
    $secondExtension = pathinfo($afterFilePath, PATHINFO_EXTENSION);
    if ($firstExtension === $secondExtension) {
        $inputFormat = $firstExtension;
    } else {
        throw new \Exception("Error. Different files format");
    }
    return genDiff($beforeData, $afterData, $inputFormat, $outputFormat);
}

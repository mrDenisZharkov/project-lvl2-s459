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
    print_r(genDiff($beforeFile, $afterFile, $outputFormat));
}

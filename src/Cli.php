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
    $files = \Docopt::handle(genCli());
    $beforeFile = $files['<firstFile>'];
    $afterFile = $files['<secondFile>'];
    print_r(genDiff($beforeFile, $afterFile));
}

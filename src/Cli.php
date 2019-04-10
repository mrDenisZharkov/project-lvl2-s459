<?php
namespace gendiff\Cli;
use function gendiff\genDiff\genDiff;

function genHelp()
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
    $result = \Docopt::handle(genHelp());
    echo genDiff(
		json_decode(file_get_contents($result['<firstFile>']), true),
		json_decode(file_get_contents($result['<secondFile>']), true)
		);
}

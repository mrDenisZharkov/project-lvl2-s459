<?php
namespace gendiff\DiffMaker;

use function gendiff\Parser\parseFileData;
use function gendiff\Ast\parseAst;
use function gendiff\Converter\renderAst;

function genDiff($beforeDataFile, $afterDataFile, $inputFormat, $outputFormat)
{
    $beforeParsedData = parseFileData($beforeDataFile, $inputFormat);
    $afterParsedData = parseFileData($afterDataFile, $inputFormat);
    $ast = parseAst($beforeParsedData, $afterParsedData);
    return renderAst($ast, $outputFormat);
}

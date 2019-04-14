<?php
namespace gendiff\DiffMaker;

use function gendiff\Parser\parseFileData;
use function gendiff\Ast\renderAst;
use function gendiff\Converter\parseAst;

function genDiff($beforeData, $afterData, $inputFormat, $outputFormat)
{
    $beforeParsedData = parseFileData($beforeData, $inputFormat);
    $afterParsedData = parseFileData($afterData, $inputFormat);
    $ast = renderAst($beforeParsedData, $afterParsedData);
    return parseAst($ast, $outputFormat);
}

<?php
namespace gendiff\DiffMaker;

use function gendiff\Parser\parseFileData;
use function gendiff\Ast\parseAst;
use function gendiff\Converter\renderAst;

function genDiff($beforeFilePath, $afterFilePath, $outputFormat)
{
    $beforeFileData = file_get_contents($beforeFilePath);
    $afterFileData = file_get_contents($afterFilePath);
    
    $beforeFileExtension = pathinfo($beforeFilePath, PATHINFO_EXTENSION);
    $afterFileExtension = pathinfo($afterFilePath, PATHINFO_EXTENSION);
    
    if ($beforeFileExtension === $afterFileExtension) {
        $inputFormat = $beforeFileExtension;
    } else {
        throw new \Exception("Error. Different files format");
    }
    
    $beforeParsedData = parseFileData($beforeFileData, $inputFormat);
    $afterParsedData = parseFileData($afterFileData, $inputFormat);
    $ast = parseAst($beforeParsedData, $afterParsedData);
    return renderAst($ast, $outputFormat);
}

<?php
namespace gendiff\DiffMaker;

use function gendiff\Parser\parseFileData;
use function gendiff\Ast\renderAst;
use function gendiff\Ast\parseAst;

function genDiff($beforeFile, $afterFile)
{
    $beforeData = parseFileData($beforeFile);
    $afterData = parseFileData($afterFile);
    $ast = renderAst($beforeData, $afterData);
    return parseAst($ast);
}

<?php
namespace gendiff\converters\Tree;

function parseAst($ast)
{
    return '{' . PHP_EOL . parseAstBody($ast) . '}' . PHP_EOL;
    //return $ast;
}

function parseAstBody(array $ast, $spacer = '  ')
{
    $diffPrint = array_reduce($ast, function ($acc, $astNode) use ($spacer) {
        $addedInd = '+';
        $deletedInd = '-';
        $equalInd = ' ';
        
        $key = $astNode['key'];
        $beforeValue = $astNode['beforeValue'];
        $afterValue = $astNode['afterValue'];
        switch ($astNode['status']) {
            case 'node':
                $acc[] = "{$spacer}  {$key}: {" . PHP_EOL;
                $acc[] = parseAstBody($astNode['children'], "{$spacer}    ");
                $acc[] = "{$spacer}  }" . PHP_EOL;
                break;
            case 'changed':
                $firstPart = getLine($addedInd, $key, $afterValue, $spacer);
                $secondPart = getLine($deletedInd, $key, $beforeValue, $spacer);
                $acc[] = "{$firstPart}{$secondPart}";
                break;
            case 'added':
                $acc[] = getLine($addedInd, $key, $afterValue, $spacer);
                break;
            case 'removed':
                $acc[] = getLine($deletedInd, $key, $beforeValue, $spacer);
                break;
            default:
                $acc[] = getLine($equalInd, $key, $beforeValue, $spacer);
                break;
        }
        return $acc;
    }, []);
    return implode($diffPrint);
}

function getLine($indicator, $key, $value, $spacer)
{
    $valueStr = is_array($value) ? printArray($value, $spacer) : $value;
    return "{$spacer}{$indicator} {$key}: {$valueStr}" . PHP_EOL;
}

function printArray($array, $spacer) : string
{
    $convertedArray = ['{', PHP_EOL];
    $spacer = "{$spacer}  ";
    foreach ($array as $key => $value) {
        $convertedArray[] =  "{$spacer}    {$key}: {$value}" . PHP_EOL;
    }
    $convertedArray[] = "{$spacer}}";
    return implode($convertedArray);
}

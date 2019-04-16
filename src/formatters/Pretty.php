<?php
namespace gendiff\formatters\Pretty;

function renderAst($ast)
{
    return '{' . PHP_EOL . renderAstBody($ast) . '}' . PHP_EOL;
    //return $ast;
}

function renderAstBody(array $ast, $nodeLevel = 0)
{
    $diffPrint = array_reduce($ast, function ($acc, $astNode) use ($nodeLevel) {
        $addedInd = '+';
        $removedInd = '-';
        $equalInd = ' ';
        
        $key = $astNode['key'];
        $beforeValue = $astNode['beforeValue'];
        $afterValue = $astNode['afterValue'];
        $type = $astNode['type'];
        $spacer = '  ' . str_repeat('    ', $nodeLevel);
        
        switch ($type) {
            case 'node':
                $acc[] = "{$spacer}  {$key}: {" . PHP_EOL;
                $acc[] = renderAstBody($astNode['children'], $nodeLevel + 1);
                $acc[] = "{$spacer}  }" . PHP_EOL;
                break;
            case 'changed':
                $firstPart = getLine($addedInd, $key, $afterValue, $spacer);
                $secondPart = getLine($removedInd, $key, $beforeValue, $spacer);
                $acc[] = "{$firstPart}{$secondPart}";
                break;
            case 'added':
                $acc[] = getLine($addedInd, $key, $afterValue, $spacer);
                break;
            case 'removed':
                $acc[] = getLine($removedInd, $key, $beforeValue, $spacer);
                break;
            case 'equal':
                $acc[] = getLine($equalInd, $key, $beforeValue, $spacer);
                break;
            default:
                throw new \Exception('Unknown type for AST: ' . $type);
        }
        return $acc;
    }, []);
    return implode($diffPrint);
}

function getLine($indicator, $key, $value, $spacer)
{
    $valueStr = is_array($value) ? convArrayStr($value, $spacer) : $value;
    return "{$spacer}{$indicator} {$key}: {$valueStr}" . PHP_EOL;
}

function convArrayStr($array, $spacer) : string
{
    $currSpacer = "{$spacer}  ";
    $convertedArray = array_map(function ($key, $value) use ($currSpacer) {
        return "{$currSpacer}    {$key}: {$value}" . PHP_EOL;
    }, array_keys($array), $array);
    return ('{' . PHP_EOL . implode($convertedArray) . $currSpacer . '}');
}

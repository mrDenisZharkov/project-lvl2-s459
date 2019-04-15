<?php
namespace gendiff\formatters\Pretty;

function renderAst($ast)
{
    return '{' . PHP_EOL . renderAstBody($ast) . '}' . PHP_EOL;
}

function renderAstBody(array $ast, $spacer = '  ')
{
    $diffPrint = array_reduce($ast, function ($acc, $astNode) use ($spacer) {
        $addedInd = '+';
        $removedInd = '-';
        $equalInd = ' ';
        
        $key = $astNode['key'];
        $beforeValue = $astNode['beforeValue'];
        $afterValue = $astNode['afterValue'];
        $type = $astNode['type'];
        
        switch ($type) {
            case 'node':
                $acc[] = "{$spacer}  {$key}: {" . PHP_EOL;
                $acc[] = renderAstBody($astNode['children'], "{$spacer}    ");
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
    $convertedArray = ['{', PHP_EOL];
    $currSpacer = "{$spacer}  ";
    foreach ($array as $key => $value) {
        $convertedArray[] =  "{$currSpacer}    {$key}: {$value}" . PHP_EOL;
    }
    $convertedArray[] = "{$currSpacer}}";
    return implode($convertedArray);
}

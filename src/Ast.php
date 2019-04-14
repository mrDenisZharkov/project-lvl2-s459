<?php
namespace gendiff\Ast;

use function Funct\Collection\union;
use function Funct\Collection\flattenAll;

function initNode($key, $status, $beforeValue, $afterValue, $children)
{
    return [
        'key' => $key,
        'status' => $status,
        'beforeValue' => $beforeValue,
        'afterValue' => $afterValue,
        'children' => $children
    ];
}

function renderAst($beforeData, $afterData)
{
    $keys = union(array_keys($beforeData), array_keys($afterData));
    $ast = array_reduce($keys, function ($acc, $key) use ($beforeData, $afterData) {
        $beforeValue = array_key_exists($key, $beforeData) ? normalizeValue($beforeData[$key]) : [];
        $afterValue = array_key_exists($key, $afterData) ? normalizeValue($afterData[$key]) : [];
        if (array_key_exists($key, $beforeData) && array_key_exists($key, $afterData)) {
            if (is_array($beforeValue) && is_array($afterValue)) {
                $acc[] = initNode($key, 'node', null, null, renderAst($beforeValue, $afterValue));
            } elseif ($beforeValue === $afterValue) {
                $acc[] = initNode($key, 'equal', $beforeValue, $afterValue, null);
            } else {
                $acc[] = initNode($key, 'changed', $beforeValue, $afterValue, null);
            }
        } elseif (!array_key_exists($key, $beforeData)) {
            $acc[] = initNode($key, 'added', null, $afterValue, null);
        } else {
            $acc[] = initNode($key, 'deleted', $beforeValue, null, null);
        }
        return $acc;
    }, []);
    return $ast;
}

function normalizeValue($value)
{
    return is_bool($value) ? ($value = $value ? 'true' : 'false') : $value;
}

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
            case 'deleted':
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

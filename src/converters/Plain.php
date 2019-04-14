<?php
namespace gendiff\converters\Plain;

function parseAst($ast)
{
    return parseAstBody($ast);
    //return $ast;
}

function parseAstBody(array $ast, $path = '')
{
    $diffPrint = array_reduce($ast, function ($acc, $astNode) use ($path) {
        $key = $astNode['key'];
        $beforeValue = $astNode['beforeValue'];
        $afterValue = $astNode['afterValue'];
        $status = $astNode['status'];
        $children = $astNode['children'];
        switch ($status) {
            case 'node':
                $acc[] = parseAstBody($children, "{$key}.");
                break;
            case 'changed':
                $note = ". From '{$beforeValue}' to '{$afterValue}'";
                $acc[] = getLine($path, $key, $status, $note);
                break;
            case 'added':
                $noteIfComplex =  " with value: 'complex value'";
                $note = is_array($afterValue) ? $noteIfComplex : " with value: '{$afterValue}'";
                $acc[] = getLine($path, $key, $status, $note);
                break;
            case 'removed':
                $acc[] = getLine($path, $key, $status);
                break;
            default:
                break;
        }
        return $acc;
    }, []);
    return implode($diffPrint);
}

function getLine($path, $propertyName, $status, $note = '')
{
    return "Property '{$path}{$propertyName}' was {$status}{$note}" . PHP_EOL;
}

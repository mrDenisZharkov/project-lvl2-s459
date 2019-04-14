<?php
namespace gendiff\formatters\Plain;

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
        $type = $astNode['type'];
        $children = $astNode['children'];
        switch ($type) {
            case 'node':
                $acc[] = parseAstBody($children, "{$key}.");
                break;
            case 'changed':
                $note = ". From '{$beforeValue}' to '{$afterValue}'";
                $acc[] = getLine($path, $key, $type, $note);
                break;
            case 'added':
                $noteIfComplex =  " with value: 'complex value'";
                $note = is_array($afterValue) ? $noteIfComplex : " with value: '{$afterValue}'";
                $acc[] = getLine($path, $key, $type, $note);
                break;
            case 'removed':
                $acc[] = getLine($path, $key, $type);
                break;
            case 'equal':
                break;
            default:
                throw new \Exception('Unknown type for AST: ' . $type);
        }
        return $acc;
    }, []);
    return implode($diffPrint);
}

function getLine($path, $propertyName, $status, $note = '')
{
    return "Property '{$path}{$propertyName}' was {$status}{$note}" . PHP_EOL;
}

<?php
namespace gendiff\Ast;

use function Funct\Collection\union;

function initNode($key, $type, $beforeValue, $afterValue, $children)
{
    return [
        'key' => $key,
        'type' => $type,
        'beforeValue' => $beforeValue,
        'afterValue' => $afterValue,
        'children' => $children
    ];
}

function parseAst($beforeDataObj, $afterDataObj)
{
    $beforeData = get_object_vars($beforeDataObj);
    $afterData = get_object_vars($afterDataObj);
    
    $keys = union(array_keys($beforeData), array_keys($afterData));
    $ast = array_reduce($keys, function ($acc, $key) use ($beforeData, $afterData) {
        $beforeValue = $beforeData[$key] ?? '';
        $afterValue = $afterData[$key] ?? '';
        $beforeValue = normalizeBoolValue($beforeValue);
        $afterValue = normalizeBoolValue($afterValue);
        if (array_key_exists($key, $beforeData) && array_key_exists($key, $afterData)) {
            if (is_object($beforeValue) && is_object($afterValue)) {
                $acc[] = initNode($key, 'node', null, null, parseAst($beforeValue, $afterValue));
            } elseif ($beforeValue === $afterValue) {
                $acc[] = initNode($key, 'equal', $beforeValue, $afterValue, null);
            } else {
                $acc[] = initNode($key, 'changed', $beforeValue, $afterValue, null);
            }
        } elseif (!array_key_exists($key, $beforeData)) {
            $afterNotObjValue = is_object($afterValue) ? get_object_vars($afterValue) :  $afterValue;
            $acc[] = initNode($key, 'added', null, $afterNotObjValue, null);
        } else {
            $beforeNotObjValue = is_object($beforeValue) ? get_object_vars($beforeValue) :  $beforeValue;
            $acc[] = initNode($key, 'removed', $beforeNotObjValue, null, null);
        }
        return $acc;
    }, []);
    return $ast;
}

function normalizeBoolValue($value)
{
    return is_bool($value) ? ($value = $value ? 'true' : 'false') : $value;
}

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

function parseAst($beforeData, $afterData)
{
    $keys = union(array_keys($beforeData), array_keys($afterData));
    $ast = array_reduce($keys, function ($acc, $key) use ($beforeData, $afterData) {
        $beforeValue = $beforeData[$key] ?? '';
        $afterValue = $afterData[$key] ?? '';
        $beforeValue = normalizeValue($beforeValue);
        $afterValue = normalizeValue($afterValue);
        if (array_key_exists($key, $beforeData) && array_key_exists($key, $afterData)) {
            if (is_array($beforeValue) && is_array($afterValue)) {
                $acc[] = initNode($key, 'node', null, null, parseAst($beforeValue, $afterValue));
            } elseif ($beforeValue === $afterValue) {
                $acc[] = initNode($key, 'equal', $beforeValue, $afterValue, null);
            } else {
                $acc[] = initNode($key, 'changed', $beforeValue, $afterValue, null);
            }
        } elseif (!array_key_exists($key, $beforeData)) {
            $acc[] = initNode($key, 'added', null, $afterValue, null);
        } else {
            $acc[] = initNode($key, 'removed', $beforeValue, null, null);
        }
        return $acc;
    }, []);
    return $ast;
}

function normalizeValue($value)
{
    return is_bool($value) ? ($value = $value ? 'true' : 'false') : $value;
}

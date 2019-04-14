<?php
namespace gendiff\Ast;

use function Funct\Collection\union;

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

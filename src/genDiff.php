<?php
namespace gendiff\genDiff;

use function Funct\Collection\union;
use Symfony\Component\Yaml\Yaml;

function genDiff($beforeFile, $afterFile)
{
    $beforeData = getFileData($beforeFile);
    $afterData = getFileData($afterFile);
    $keys = union(array_keys($beforeData), array_keys($afterData));
    $diffResult = array_reduce($keys, function ($diffString, $key) use ($beforeData, $afterData) {
        $diffString[] = getDiffStr($key, $beforeData, $afterData);
        return $diffString;
    }, []);
    $diffBody = ['{', PHP_EOL, implode($diffResult), '}', PHP_EOL];
    return implode($diffBody);
}
  
function getFileData($path)
{
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    switch ($extension) {
        case 'json':
            return json_decode(file_get_contents($path), true);
        break;
        case 'yaml':
            return Yaml::parse(file_get_contents($path));
        break;
        default:
            return [];
        break;
    }
}

function getDiffStr($key, $beforeData, $afterData)
{
    $addedInd = '+';
    $deletedInd = '-';
    $equalInd = ' ';
    $hasKeyBefore = array_key_exists($key, $beforeData);
    $hasKeyAfter = array_key_exists($key, $afterData);
    $valueBefore = !$hasKeyBefore ?: $beforeData[$key];
    $valueAfter = !$hasKeyAfter ?: $afterData[$key];
    if (!$hasKeyBefore && $hasKeyAfter) {
        return getLine($addedInd, $key, $valueAfter);
    } elseif ($hasKeyBefore && !$hasKeyAfter) {
        return getLine($deletedInd, $key, $valueBefore);
    } elseif ($valueBefore === $valueAfter) {
        return getLine($equalInd, $key, $valueBefore);
    } else {
        return getLine($addedInd, $key, $valueAfter) . getLine($deletedInd, $key, $valueBefore);
    }
}

function getLine($indicator, $key, $value)
{
    return "  {$indicator} {$key}: " . normalizeValue($value) . PHP_EOL;
}

function normalizeValue($value)
{
    return is_bool($value) ? ($value = $value ? 'true' : 'false') : $value;
}

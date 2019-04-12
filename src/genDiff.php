<?php
namespace gendiff\genDiff;

use function Funct\Collection\union;

function genDiff($beforeFile, $afterFile)
{
    $beforeData = getFileData($beforeFile);
    $afterData = getFileData($afterFile);
    $keys = union(array_keys($beforeData), array_keys($afterData));
    $result = array_reduce($keys, function ($string, $key) use ($beforeData, $afterData) {
            return $string . getDiffStr($key, $beforeData, $afterData);
            }, '');
    return '{' . PHP_EOL . $result . '}' . PHP_EOL;
 }  
  
function getFileData($path)
{
	return json_decode(file_get_contents($path), true);
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
    } else  if ($hasKeyBefore && !$hasKeyAfter) {
        return getLine($deletedInd, $key, $valueBefore);
    } else if ($valueBefore === $valueAfter){
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

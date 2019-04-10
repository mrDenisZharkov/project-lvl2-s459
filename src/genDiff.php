<?php
namespace gendiff\genDiff;

function genDiff(array $firstData, array $secondData)
{
    $addedInd = '+';
    $deletedInd = '-';
    $equalInd = ' ';
    $result = '';
    foreach ($firstData as $key => $value) {
        if (array_key_exists($key, $secondData)) {
            if (isEqual($key, $value, $secondData)) {
                $newStr = getLine($equalInd, $key, $value);
            } else {
                $strOne = getLine($deletedInd, $key, $value);
                $strTwo = getLine($addedInd, $key, $secondData[$key]);
                $newStr = "{$strOne}{$strTwo}";
            }
            unset($secondData[$key]);
        } else {
            $newStr = getLine($deletedInd, $key, $value);
        }
        $result = "{$result}{$newStr}";
    }
    foreach ($secondData as $key => $value) {
        $newStr = getLine($addedInd, $key, $secondData[$key]);
        $result = "{$result}{$newStr}";
    }
    return $result;
}
function getLine($indicator, $key, $value)
{
    return "  {$indicator} {$key}: {$value}" . PHP_EOL;
}
function isEqual($key, $value, array $data)
{
    return $data[$key] === $value;
}

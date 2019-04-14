<?php
namespace gendiff\Parser;

use Symfony\Component\Yaml\Yaml;

function parseFileData($data, $extension)
{
    switch ($extension) {
        case 'json':
            return json_decode($data, true);
        case 'yaml':
            return Yaml::parse($data);
        default:
            throw new \Exception('Error. Unsupported file format');
    }
}

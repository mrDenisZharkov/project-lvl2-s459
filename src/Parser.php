<?php
namespace gendiff\Parser;

use Symfony\Component\Yaml\Yaml;

function parseFileData($data, $extension)
{
    switch ($extension) {
        case 'json':
            return json_decode($data);
        case 'yaml':
            return Yaml::parse($data, Yaml::PARSE_OBJECT_FOR_MAP);
        default:
            throw new \Exception('Error. Unsupported file format');
    }
}

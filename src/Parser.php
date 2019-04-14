<?php
namespace gendiff\Parser;

use Symfony\Component\Yaml\Yaml;

function parseFileData($path)
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
            return ["Error. Unsupported file format"];
        break;
    }
}

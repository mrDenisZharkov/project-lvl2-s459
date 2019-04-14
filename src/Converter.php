<?php
namespace gendiff\Converter;

use function gendiff\converters\Tree\parseAst as renderTree;
use function gendiff\converters\Plain\parseAst as renderPlain;

function parseAst($ast, $outputFormat)
{
    switch ($outputFormat) {
        case 'plain':
            return renderPlain($ast);
        break;
        default:
            return renderTree($ast);
        break;
    }
}

<?php
namespace gendiff\Converter;

use function gendiff\formatters\Tree\parseAst as renderTree;
use function gendiff\formatters\Plain\parseAst as renderPlain;

function renderAst($ast, $outputFormat)
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

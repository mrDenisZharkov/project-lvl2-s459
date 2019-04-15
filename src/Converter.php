<?php
namespace gendiff\Converter;

use function gendiff\formatters\Pretty\renderAst as renderPretty;
use function gendiff\formatters\Plain\renderAst as renderPlain;
use function gendiff\formatters\Json\renderAst as renderJson;

function renderAst($ast, $outputFormat)
{
    switch ($outputFormat) {
        case 'plain':
            return renderPlain($ast);
        case 'pretty':
            return renderPretty($ast);
        case 'json':
            return renderJson($ast);
        default:
            throw new \Exception("Error. Undefined output format");
    }
}

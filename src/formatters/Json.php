<?php
namespace gendiff\formatters\Json;

function renderAst($ast)
{
    return json_encode($ast, JSON_PRETTY_PRINT) . PHP_EOL;
}

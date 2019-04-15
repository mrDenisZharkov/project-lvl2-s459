# Generate Differencies
[![Maintainability](https://api.codeclimate.com/v1/badges/49a1d649aefedaa378c1/maintainability)](https://codeclimate.com/github/mrDenisZharkov/project-lvl2-s459/maintainability)
[![Build Status](https://travis-ci.org/mrDenisZharkov/project-lvl2-s459.svg?branch=master)](https://travis-ci.org/mrDenisZharkov/project-lvl2-s459)
## Description:
This package helps to find differences in files
## How to install gendiff:
For global installation:
```
composer global require zharkov-denis/gendiff
```
[![asciicast](https://asciinema.org/a/ByoczopCXiS1URRgVv4ZGrGu5.svg)](https://asciinema.org/a/ByoczopCXiS1URRgVv4ZGrGu5)
## Call help:
```
gendiff -h
or
gendiff -help
```
[![asciicast](https://asciinema.org/a/tcwSXSyt3AJrF6I4DKDh6VMwZ.svg)](https://asciinema.org/a/tcwSXSyt3AJrF6I4DKDh6VMwZ)
## Call json flat files to see difference:
```
gendiff *.json *.json
```
[![asciicast](https://asciinema.org/a/TwDYw5KXTd4o2pmKti32CpPUF.svg)](https://asciinema.org/a/TwDYw5KXTd4o2pmKti32CpPUF)
## Call yaml files to see difference:
```
gendiff *.yaml *.yaml
```
[![asciicast](https://asciinema.org/a/nKzNNYmdBGVyZpgu3SwalKMrx.svg)](https://asciinema.org/a/nKzNNYmdBGVyZpgu3SwalKMrx)
## Call json non-flat files to see difference:
```
gendiff *.json *.json
```
[![asciicast](https://asciinema.org/a/OPhJeiONPHxWIwlBLK3k7V6y3.svg)](https://asciinema.org/a/OPhJeiONPHxWIwlBLK3k7V6y3)
## Call files to see difference in plain format:
```
gendiff *.(json/yaml) *.(json/yaml) --format plain
```
[![asciicast](https://asciinema.org/a/yuE6f4igqf9HGhawdLYGGPgHz.svg)](https://asciinema.org/a/yuE6f4igqf9HGhawdLYGGPgHz)
## Call files to see difference in json format:
```
gendiff *.(json/yaml) *.(json/yaml) --format json
```
[![asciicast](https://asciinema.org/a/GsXockAMTryNmj1UsjZTPp6g9.svg)](https://asciinema.org/a/GsXockAMTryNmj1UsjZTPp6g9)

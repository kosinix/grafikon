# Grafikon

[![Build Status](https://travis-ci.org/kosinix/grafikon.svg?branch=master)](https://travis-ci.org/kosinix/grafikon)

A smaller subset of [Grafika](https://kosinix.github.io/grafika) that works in PHP 5.2

## Features

* Works in PHP 5.2 (yup WordPress)
* Common image ops: resize, crop, smart-crop, blend, fill, text, opacity
* Image compare: compare, equal
* Special: smart-crop
* Transforms: flip, rotate
* Supported images: JPG, PNG, GIF, Animated GIF (Works even if you only have GD installed)

## Usage

`
require_once 'src/autoloader.php';

$editor = Grafikon::createEditor(); // Will try and create Imagick editor or fallback to GD
$image = $editor->open('image.jpeg');
$editor->resize($image, 200, 100, 'fit');
$editor->save('out.png');

`

## Packagist
[https://packagist.org/packages/kosinix/grafikon](https://packagist.org/packages/kosinix/grafikon)

## License
Grafikon is dual licensed:
- MIT
- GPL-2.0+

Liberation Sans is licensed under SIL Open Font License.
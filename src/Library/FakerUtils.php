<?php

namespace Clumsy\Utils\Library;

use Faker\Generator;
use Faker\Provider\Base;

class FakerUtils extends Base
{
    protected $typographyHTML;

    public function __construct(Generator $generator)
    {
        $this->typographyHTML = file_get_contents('http://git.io/vRkhK');

        parent::__construct($generator);
    }

    public function typography()
    {
        return $this->typographyHTML;
    }

    public function richText($maxNbChars = 200, $paragraphs = 4)
    {
        $text = '';
        for ($i = 0; $i < $paragraphs; $i++) {
            $text .= '<p>'.nl2br($this->generator->text($maxNbChars, 1))."</p>\n";
        }

        return $text;
    }

    public static function randomFromArray(array $array = [])
    {
        return array_get(array_keys($array), rand(0, (count($array)-1)));
    }
}

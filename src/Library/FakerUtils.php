<?php

namespace Clumsy\Utils\Library;

use Faker\Generator;
use Faker\Provider\Base;

class FakerUtils extends Base
{
    protected $typographyHtml;
    protected $tableHtml;
    protected $embeddedHtml;

    public function __construct(Generator $generator)
    {
        $this->typographyHtml = file_get_contents('http://git.io/v0Rb0');
        $this->tableHtml = file_get_contents('http://git.io/v0RNo');
        $this->embeddedHtml = file_get_contents('http://git.io/v0RNu');

        parent::__construct($generator);
    }

    public function typography()
    {
        return $this->htmlTags(['typography']);
    }

    public function htmlTags($groups = null)
    {
        $output = '';

        if (is_null($groups)) {
            $groups = ['typography', 'table', 'embedded'];
        }

        foreach ((array)$groups as $group) {
            $property = "{$group}Html";
            $output .= $this->$property;
        }

        return $output;
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

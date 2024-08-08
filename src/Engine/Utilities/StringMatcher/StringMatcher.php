<?php

namespace Engine\Utilities\StringMatcher;

class StringMatcher
{
    //Example
    //$chr_ru = "А-Яа-яЁё0-9\s`~!@#$%^&*()_+-={}|:;<>?,.\/\"\'\\\[\]";
    //if (preg_match("/^[$chr_ru]+$/u", $string)) {
    public static function match(MatchSample $sample, string $string) : bool {
        return preg_match("/^[$sample->value]+$/u", $string) ? true : false;
    }

}
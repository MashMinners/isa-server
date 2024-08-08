<?php

declare(strict_types=1);

namespace Engine\Utilities\StringMatcher;

enum MatchSample : string
{
    case RU_Full = "а-яА-ЯЁё";
    case RU_lowercase = "а-яё";
    case RU_uppercase = "А-ЯЁ";
    case ENG_Full = "a-zA-Z";
    case ENG_lowercase = "a-z";
    case ENG_uppercase = "A-Z";

}
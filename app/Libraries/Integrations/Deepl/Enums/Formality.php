<?php

namespace App\Libraries\Integrations\Deepl\Enums;

enum Formality
{
    case default;
    case more;
    case less;
    case prefer_more;
    case prefer_less;

}

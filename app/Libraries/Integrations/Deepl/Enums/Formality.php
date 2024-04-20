<?php

namespace App\Libraries\Integrations\Deepl\Enums;

enum Formality: string
{
    case default = 'default';
    case more = 'more';
    case less = 'less';
    case prefer_more = 'prefer_more';
    case prefer_less = 'prefer_less';

}

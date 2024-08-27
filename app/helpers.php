<?php

use App\AllianceSelector;

if (! function_exists('objUse')) {
    function objUse(object $obj, string $traitName): bool
    {
        return in_array($traitName, class_uses($obj));
    }
}

if (! function_exists('allianceId')) {
    function allianceId(): int
    {
        return resolve(AllianceSelector::class)->getSelected();
    }
}

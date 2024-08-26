<?php

if (! function_exists('objUse')) {
    function objUse(object $obj, string $traitName): bool
    {
        return in_array($traitName, class_uses($obj));
    }
}

if (! function_exists('allianceId')) {
    function allianceId(): int
    {
        $allianceId = context()->get('alliance_id');
        throw_if($allianceId === null, Error::class, 'Alliance is not setup yet');

        return $allianceId;
    }
}

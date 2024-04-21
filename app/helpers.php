<?php

if (! function_exists('objUse')) {
    function objUse(object $obj, string $traitName): bool
    {
        return in_array($traitName, class_uses($obj));
    }
}

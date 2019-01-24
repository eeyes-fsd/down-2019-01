<?php

function cidr_match($ip, $range)
{
    if (is_array($range)) {
        foreach ($range as $range1) {
            if (cidr_match($ip, $range1)) {
                return true;
            }
        }
        return false;
    }
    list($subnet, $bits) = explode('/', $range);
    $ip = ip2long($ip);
    $subnet = ip2long($subnet);
    $mask = -1 << (32 - $bits);
    return ($ip & $mask) === ($subnet & $mask);
}

function readable_size($bytes)
{
    if ($bytes < 1024) {
        return $bytes . 'B';
    }
    if ($bytes < 1048576) {
        return round($bytes / 1024, 1) . 'K';
    }
    if ($bytes < 1073741824) {
        return round($bytes / 1048576, 1) . 'M';
    }
    return round($bytes / 1073741824, 1) . 'G';
}
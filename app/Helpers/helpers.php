<?php
function to_farsi_number($str){
    $en = array('0','1','2','3','4','5','6','7','8','9',',');
    $fa = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','،');
    $output  = str_replace($en, $fa, $str);
    return($output);
}

function to_english_number($str){
    $fa = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','،');
    $en = array('0','1','2','3','4','5','6','7','8','9',',');
    $output  = str_replace($fa, $en, $str);
    return($output);
}

function getContrastingTextColor(string $hexColor): string
{
    // Remove '#' if present
    $hexColor = str_replace('#', '', $hexColor);

    // Convert hex to RGB
    $r = hexdec(substr($hexColor, 0, 2));
    $g = hexdec(substr($hexColor, 2, 2));
    $b = hexdec(substr($hexColor, 4, 2));

    // Calculate the perceived brightness of the color using the standard formula
    $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

    // Return black for light backgrounds, white for dark backgrounds
    return $brightness > 128 ? '#000000' : '#FFFFFF';
}

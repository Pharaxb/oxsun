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

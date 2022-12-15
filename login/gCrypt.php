<?php
function encrypt($str) {
    $out = [];
    $alph = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");

    for($i = 0; $i < strlen($str); $i++) {
        if(in_array($str[$i], $alph)) {
            $out[$i] = chr((26 + (ord($str[$i])+$i-97)) % 26 + 97);
        }
        else if($str[$i] == '@') $out[$i] = '-';
        else if($str[$i] == '.') $out[$i] = '_';
        else $out[$i] = $str[$i];
    }

    return implode($out);
}

function decrypt($str) {
    $out = [];
    $alph = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");

    for($i = 0; $i < strlen($str); $i++) {
        if(in_array($str[$i], $alph)) {
            $out[$i] = chr((26 + (ord($str[$i])-$i-97)) % 26 + 97);
        }
        else if($str[$i] == '-') $out[$i] = '@';
        else if($str[$i] == '_') $out[$i] = '.';
        else $out[$i] = $str[$i];
    }

    return implode($out);
}
?>
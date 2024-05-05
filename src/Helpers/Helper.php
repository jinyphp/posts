<?php


function truncateString($string, $length = 100, $append = '...') {
    // 문자열의 길이가 지정된 길이보다 짧으면 원래 문자열 그대로 반환
    if (mb_strlen($string) <= $length) {
        return $string;
    }

    // 문자열을 지정된 길이만큼 자르고 "..."를 붙여 반환
    return rtrim(mb_substr($string, 0, $length)) . $append;
}

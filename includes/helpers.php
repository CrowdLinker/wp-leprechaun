<?php

class Helpers {
    //Serialize array
    public static function sanitize($options) {
        return serialize($options);
    }

    public static function checked($arr, $value) {
        return is_array($arr) && in_array($value, $arr) ? 'checked="checked"' : '';
    }

    public static function unserialize($value) {
        $arr = [];

        if($value) {
            $arr = unserialize($value);
        }

        return $arr;
    }

    public static function encodeURIComponent($str) {
        $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
        return strtr(rawurlencode($str), $revert);
    }
}
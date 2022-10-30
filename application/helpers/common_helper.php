<?php 
if (!function_exists("isImageExist")) {

    function isImageExist($img, $imgaFor) {

        switch ($imgaFor) {

            case 'sell_out_report':
                if ($img != '' && $img != NULL &&  file_exists('images/sell_out_report/' . $img)) {
                    return base_url() . 'images/sell_out_report/' . $img;
                } else {
                    return false;
                }
                break;
 
            default:
                return false;
                break;
        }
    }

}
if (!function_exists('getNumericDateFormat')) {

    function getNumericDateFormat($dateTime) {
        return isset($dateTime) ? date('d/m/Y H:i:s', strtotime($dateTime)) : '';
    }

}
if (!function_exists('getNumericDateFormat1')) {

    function getNumericDateFormat1($dateTime) {
        return isset($dateTime) ? date('d/m/Y', strtotime($dateTime)) : '';
    }

}
?>
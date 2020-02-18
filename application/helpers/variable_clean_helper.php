<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 27/11/2019
 * Time: 6:53 PM
 */

/**
 * @param array $data Parent Array
 * @param string $variable Array Key Name
 * @param string $default Default Value
 *
 * @return mixed
 */
function returnFromArray($data, $variable, $default=''  ){
    if (is_array($data) && array_key_exists($variable, $data)){
        return $data[$variable];
    } else {
        return $default;
    }
}

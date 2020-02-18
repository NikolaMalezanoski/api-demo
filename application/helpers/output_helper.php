<?php



/**
 * @param $array
 */
function print_f($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}


function responseData($status, $return_data){

	$message = [
		'status' => true,
		'data' => $return_data
	];
}

<?php
/**
 * Insert new item to a multidimensional array where sequence of keys are stored in an array.
 * @param array() $arr . Array where the value will be inserted. This array can be empty.
 * @param array() $key_chain. Array of keys where a key is the parent of the next key. Keys can be number, string or event BLANK string.
 * @param mixed $value. The value that you want to insert to the array.
 * @return bool. True for success and false for fail.
 */
function insert_into_array_by_key_chain(&$arr, $key_chain, $value )
{
    if( !is_array( $key_chain ) || count( $key_chain ) == 0 ){ return false; }
  
    $ref = &$arr;//take the reference of the array.
    foreach( $key_chain as $key )
    {
        $key = trim( $key );
        if( $key == '')
        {
            $ref[] = array();        //Just a fake value. This will be overridden on next cycle or after the loop. This fake value must be an array to avoid error for next valid non blank key.
            end($ref);               //set the internal pointer of array to the last item.
            $ref = &$ref[key($ref)]; //take the reference of the last inserted fake item. Function key() returns the key of current item of the array. In this case it is last item.
        }
        else
        {
            $ref = &$ref[$key];     //take the new reference of the item of child array based on the key from the current reference.
        }
  
    }
    $ref = $value; //Assign the value to the calculated reference.
    unset($ref);//must unset the $ref , otherwise it can produce unpredictable results. See the example here http://php.net/manual/en/language.references.php#83325
    return true;
}
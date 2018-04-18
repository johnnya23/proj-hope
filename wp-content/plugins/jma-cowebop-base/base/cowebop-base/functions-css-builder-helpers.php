<?php


/***********************************
 * return $return containing property value pairs for the fonts and colors
 * $input font and color values from options page (both contained in $jma_spec_options['typography_xxx'] array)
 * ********************************/
function font_handler($font)
{
    $return = array();
    if ($font['face']) {
        switch ($font['face']) {

            case 'google':
                $parts = explode(':', $font['google']);//strip out the font weight
                $return[] = array('font-family',$parts[0]);
                break;
            case 'baskerville':
            case 'georgia':
            case 'lucida':
                $return[] = array('font-family',$font['face'] . ', serif');
                break;
            case 'palatino':
                $return[] = array('font-family', 'Palatino Linotype, ' . $font['face'] . ', serif');
                break;
            case 'helvetica':
            case 'arial':
            case 'trebuchet':
                $return[] = array('font-family',$font['face'] . ', sans-serif');
                break;
            case 'tahoma':
            case 'verdana':
                $return[] = array('font-family',$font['face'] . ', geneva, sans-serif');
                break;
            default:
                $return[] = array('font-family','"times new roman", times, serif');
                break;
        }
    }
    if ($font['color']) {
        $return[] = array('color',$font['color']);
    }
    return $return;
}
//helper function for dynamic-styles-builder.php
if (!function_exists('generic_output')) {
    function generic_output($inputs)
    {
        $output = array();
        foreach ($inputs as $input) {
            $numArgs = count($input);
            if ($numArgs < 2) {
                return;
            }	//bounces input if no property => value pairs are present
            $pairs = array();
            for ($i = 1; $i < $numArgs; $i++) {
                $x = $input[$i];
                $pairs[] = array(
                    'property' => $x[0],
                    'value' => $x[1]
                    );
            }
            $add = array($input[0] => $pairs);
            $output = array_merge_recursive($output, $add);
        }
        return $output;
    }
}
//helper function for dynamic-styles-builder.php
// media queries in format max(or min)-$width@$selector, .....
// so we explode around @, then around - (first checking to see if @ symbol is present)
function build_css($css_values)
{
    $return = ' /* THIS FILE IS GENERATED DYMANICALLY BY JMA COWEBOP BASE BO NOT EDIT OR DELETE!! ' . date("F j, Y, g:i:s a") .'*/';
    foreach ($css_values as  $k => $css_value) {
        $has_media_query = (strpos($k, '@'));
        if ($has_media_query) {
            $exploded = explode('@', $k);
            $media_query_array = explode('-', $exploded[0]);
            $k = $exploded[1];

            $return .= '@media (' . $media_query_array[0] . '-width:' . $media_query_array[1] . "px) {";/*|n*/
        }
        $return .= $k . "{";/*|n*/
        foreach ($css_value as $value) {
            if ($value['value']) {
                $return .= $value['property'] . ': ' . $value['value'] . ";";/*|n*/
            }
        }
        $return .= "}";/*|n*/
        if ($has_media_query) {
            $return .= "}";/*|n*/
        }
    }
    return $return;
}
function get_tint($color_in, $tint_amount=0.5)
{
    $raw = str_replace('#', '', $color_in);
    // Convert string to 3 decimal values (0-255)
    $rgb = array_map('hexdec', str_split($raw, 2));
    $return['str_split'] = $rgb;
    // Modify color
    $lighten[0] = round(($rgb[0] + 255)*$tint_amount);
    $lighten[1] = round(($rgb[1] + 255)*$tint_amount);
    $lighten[2] = round(($rgb[2] + 255)*$tint_amount);
    $darken[0] = str_pad(round(($rgb[0] + 0)/1.2), 2, '0', STR_PAD_LEFT);
    $darken[1] = str_pad(round(($rgb[1] + 0)/1.2), 2, '0', STR_PAD_LEFT);
    $darken[2] = str_pad(round(($rgb[2] + 0)/1.2), 2, '0', STR_PAD_LEFT);
    $return['light_str_split'] = $lighten;
    $return['dark_str_split'] = $darken;
    // Convert back
    $return['light_hex'] = '#' . implode('', array_map('dechex', $lighten));
    $return['dark_hex'] = '#' . implode('', array_map('dechex', $darken));
    return $return;
}

function get_trans($color_in, $trans_amount=0.6)
{
    $raw = str_replace('#', '', $color_in);
    // Convert string to 3 decimal values (0-255)
    $rgb = array_map('hexdec', str_split($raw, 2));
    return ' rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $trans_amount . ')';
}

//to remove lline breaks
//replace \n "; with ";/*|n */ (remove space after n in search and replce to keep from editting this comment)

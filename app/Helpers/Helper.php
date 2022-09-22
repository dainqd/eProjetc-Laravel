<?php
function arrayToOptions($array, $label_attribute, $key_attribute = null): array
{
    $options = [];
    foreach ($array as $item) {
        if ($key_attribute) {
            $options[$item[$key_attribute]] = $item[$label_attribute];
        } else {
            if (!in_array($item[$label_attribute], $options)) {
                $options[] = $item[$label_attribute];
            }
        }
    }
    return $options;
}

<?php

    // namespace App\Helpers;

    if(!function_exists('money')){
        function money($number){
            return number_format((float)$number, 2, '.', '');
        }
    }



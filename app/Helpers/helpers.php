<?php

use App\Models\donate_schedual;

if(!function_exists("operation_fun")){
    function operation_fun($operation,$value){
        $amounts = donate_schedual::all()->sum("amount");
        if($operation=="+")
        {
            $amounts = $amounts + $value;
        }else{
            $amounts = $amounts - $value;
        }

    }

}
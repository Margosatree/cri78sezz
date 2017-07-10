<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Defined Variables
    |--------------------------------------------------------------------------
    |
    | This is a set of variables that are made specific to this application
    | that are better placed here rather than in .env file.
    | Use config('your_key') to get the values.
    |
    */

    'sms_data' => [
        //Constant Sms Details
        'method'=>'sendMessage',
        'groupName'=>env('SMS_GROUP_NAME'),
        'userid'=>env('SMS_USER_ID'),
        'password'=>env('SMS_PASSWORD'),
        'msgType'=>'TEXT',
        'version'=>'1.1',
        'intf_url'=>'http://enterprise.smsgupshup.com/community/api.php?',
    ],

    

];
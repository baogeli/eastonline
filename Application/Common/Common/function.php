<?php

    function randomkeys() {
        $time = str_replace("0.","",str_replace(" ","",microtime()));
        $sub = substr($time,0,6);
        $time = substr($time,6,12);
        $rand = rand(0,100000000000);
        list($usec, $sec) = explode(' ', microtime());
        $rand = $usec * 10000000;
        $rand = mt_rand(0,$rand);
        $card_no = str_pad($time + $sub+$rand,12,'0',STR_PAD_LEFT);
        $user = M('user');
        $user = $user->where('vip_card ='.$card_no)->find();
        if (!empty($user)) {
            randomkeys();
        } else {
            return $card_no;
        }
    }

function guid(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        //$hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }
}

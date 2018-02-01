<?php

class SimpleSignature
{

    public function sign($json, $path){

        // echo 'works';
        // die;

        $hash = hash('sha256', $json);
        $obj = json_decode($json);
        $obj->sign = $hash;
        $signedJson = json_encode($obj);

        file_put_contents($path, $signedJson);

        return array(
            'json' => $json,
            'hash' => $hash,
            'path' => $path,
        );

    }


    public function verify($obj){

        $verifyHash = $obj->sign;
        unset($obj->sign);
        $verifyJSON = json_encode($obj);

        $hash = hash('sha256', $verifyJSON);

        if($hash == $verifyHash){
            return 1;
        } else {
            return 0;
        }

    }

}
<?php

// namespace testApp\Model;

interface SignatureInterface
{

    public function sign($json, $path);

    public function verify($obj);

}
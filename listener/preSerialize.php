<?php namespace modules\hodannotations\listener;
use lib\event\BaseListener;

class PreSerialize extends  BaseListener{

    function handle($data)
    {
        $newData=$data["data"];
        if($data["type"]!="array") {
            $vars = get_class_vars($data["type"]);
            foreach($vars as $key=>$value){
                $annotations=$this->annotation->getAnnotationsForField($data["type"],$key,"serialize");
                foreach($annotations as $annotation){
                    $annotation=$this->annotation->translate($annotation);
                    if($annotation->function=="ignore"){
                        unset($newData[$key]);
                    }
                    if($annotation->function=="rename"){
                        unset($newData[$key]);
                        $newData[$annotation->parameters[0]]=$data["data"][$key];
                    }
                }
            }
            $data["data"]=$newData;
            return $data;
        }
    }
}
<?php namespace modules\hodannotations\listener;
use lib\event\BaseListener;

class PreSerialize extends  BaseListener{

    function handle($data)
    {
        $newData=$data["data"];
        if(is_array($data["type"])){
            foreach($data["data"] as $key=>$val){

                if($data["type"][$key]!="array" && $data["type"][$key]!="value") {
                    $_data=array(
                        "data"=>$data["data"][$key],
                        "type"=>$data["type"][$key],
                        "original"=>$data["original"][$key]
                    );
                    $_dataNew=$this->handle($_data);
                    $newData[$key]=$_dataNew["data"];
                }else{
                    $dataNew[$key]=$val;
                }
            }
        }
        if($data["type"]!="array" && $data["type"]!="value") {
            if(!is_array($data["type"])) {
                $vars = get_class_vars($data["type"]);
                foreach ($vars as $key => $value) {
                    $annotations = $this->annotation->getAnnotationsForField($data["type"], $key, "serialize");
                    foreach ($annotations as $annotation) {
                        $annotation = $this->annotation->translate($annotation);
                        if ($annotation->function == "ignore") {
                            unset($newData[$key]);
                        }
                        if ($annotation->function == "rename") {
                            unset($newData[$key]);
                            $newData[$annotation->parameters[0]] = $data["data"][$key];
                        }
                        if ($annotation->function == "dynamic") {
                            $newData[$key] = $this->dynamicGet($data, $key);
                        }
                    }
                }
            }
            $data["data"]=$newData;
        }
        return $data;
    }


    function dynamicGet($data,$key){
        $tempData=$data["original"]->$key;
        if(is_array($tempData)){
            foreach($tempData as $_key => $_value){
                if(is_object($_value)){
                    $_data=array(
                        "data"=>$_value->toArray(),
                        "type"=>$_value->getType(),
                        "original"=>$_value
                    );
                    $_dataNew=$this->handle($_data);
                    $tempData[$_key]=$_dataNew["data"];
                }
            }
        }elseif(is_object($tempData)){
            $_data=array(
                "data"=>$tempData->toArray(),
                "type"=>$tempData->getType(),
                "original"=>$tempData
            );
            $_dataNew=$this->handle($_data);
            $tempData=$_dataNew["data"];
        }

        return $tempData;
    }



}
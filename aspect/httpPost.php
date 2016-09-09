<?php
    namespace modules\maxannotations\aspect;
    use modules\hodaspect\lib\hodaspect\BaseAspect;

    class HttpPost extends BaseAspect{
        function onMethodPreCall($parameters, $data)
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new \Exception("This method requires POST");
            }
        }

    }

?>
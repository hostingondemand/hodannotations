<?php
    namespace modules\hodannotations\aspect;
    use modules\hodaspect\lib\hodaspect\BaseAspect;

    class HttpGet extends BaseAspect{
        function onMethodPreCall($parameters, $data)
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                throw new \Exception("This method requires GET");
            }
        }

    }

?>
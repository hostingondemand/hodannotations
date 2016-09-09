<?php
    namespace modules\maxannotations\aspect;
    use modules\hodaspect\lib\hodaspect\BaseAspect;

    class HttpPut extends BaseAspect{
        function onMethodPreCall($parameters, $data)
        {
            if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
                throw new \Exception("This method requires PUT");
            }
        }

    }

?>
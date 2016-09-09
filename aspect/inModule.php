<?php
    namespace modules\maxannotations\aspect;
    use core\Loader;
    use modules\hodaspect\lib\hodaspect\BaseAspect;

    class InModule extends BaseAspect{
        function onMethodPreCall($parameters, $data)
        {
            Loader::goModule($parameters[0]);
        }

        function onMethodPostCall($parameters, $data)
        {
            Loader::goBackModule();
        }

    }

?>
<?php
/**
 * Created by AliGhaleyan - AlirezaSajedi
 */

if (!function_exists('responder')) {
    /**
     * responder helper
     *
     * @return \Twom\Responder\lib\Responder
     */
    function responder() {
        return (new \Twom\Responder\lib\Responder);
    }
}

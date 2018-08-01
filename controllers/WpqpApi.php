<?php

class WpqpApi extends WpqpController {
    private static $inst = null;
    
    public static function &getInst() {
        if (self::$inst == null) {
            self::$inst = new WpqpApi();
        }
        
        return self::$inst;
    }
    
    public static function RegisterRoutes() {
        register_rest_route('wpqp/v1', '/test/(?P<name>[a-zA-Z0-9\ \-]+)', array(
           'methods' => 'GET',
           'callback' => function($req) {
               return self::getInst()->Test($req);
           }
        ));
    }
    
    public function __construct() {
        parent::__construct();
    }
    
    
    public function Test(&$req) {
        return 'Hello ' . $req['name'] . ' ReqType: ' . get_class($req);
    }
    
}
<?php

/**
 * 
 */
class Ajax {

    public static $_instances = array();

    public static function instance($name = "ajax") {

        return isset(static::$_instances[$name]) ? static::$_instances[$name] : (static::$_instances[$name] = new Ajax());
    }

    private function __construct() {
        
    }

    /**
     * Generate a unique token.
     */
    private function generate_unique_token() {
        
    }

    /**
     * Create an Ajax token to launch a specific request.
     */
    public function create_token(Ajax_Request $request) {
        $token = $this->generate_unique_token();
        Cache::instance("ajax")->set($token, $request);
        return $token;
    }

    /**
     * Destroy the token once the request executed.
     * @param type $token
     */
    public function delete_token($token) {
        Cache::instance("ajax")->delete($token);
    }

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

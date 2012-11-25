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
     * Create an Ajax token to launch a specific request.
     */
    public function create_token(Ajax_Request $request) {


        function generate_unique_token(Ajax_Request $request, $uniqueifier) {
            return sha1(serialize($request) . $uniqueifier);
        }

        $uniqueifier = "";
        $token = "";

        // Tant qu'il existe une Requete poss/dant le m[eme token, en generer un autre.
        do {
            $token = generate_unique_token($request, $uniqueifier);
            $uniqueifier = sha1($uniqueifier);
        } while (Cache::instance("ajax")->get($token) instanceof Request_Ajax);

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

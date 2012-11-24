<?php

/**
 * 
 */
class Ajax {

    /**
     * Generate a unique token.
     */
    private function generate_token() {
        
    }

    /**
     * Create an Ajax token to launch a specific request.
     */
    public function create_token(Ajax_Request $request) {
        $token = $this->generate_token();
        Cache::instance("ajax")->set($token, $request);
        return $token;
    }

    public function delete_token($token) {
        Cache::instance("ajax")->delete($token);
    }

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

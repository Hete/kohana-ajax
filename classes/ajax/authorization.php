<?php

class Ajax_Authorization {

    private $_token;
    private $_remaining_calls;

    public function __construct($token, $remaining_calls = 1) {
        $this->_token = $token;
        $this->_remaining_calls = $remaining_calls;
    }

    public function consume() {
        return $this->_remaining_calls-- >= 0 && Cache::instance("ajax")->set($this->_token, $this->_remaining_calls);
    }

}

?>

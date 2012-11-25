<?php

/**
 * Implementation of Ajax request. These requests are limited in number of calls.
 */
class Request_Ajax extends Request {

    public static function factory($uri = TRUE, \HTTP_Cache $cache = NULL, $injected_routes = array(), $remaining_calls = 1) {
        parent::factory($uri, $cache, $injected_routes, $remaining_calls);
    }

    private $_remaining_calls;

    public function __construct($uri, \HTTP_Cache $cache = NULL, $injected_routes = array(), $remaining_calls = 1) {
        $this->_remaining_calls = $remaining_calls;
        parent::__construct($uri, $cache, $injected_routes);
    }

    public function remaining_calls($value = NULL) {
        if ($value === NULL) {
            return $this->_remaining_calls;
        }

        if (Valid::numeric($value)) {
            $this->_remaining_calls = $value;
        }

        return $this;
    }

    public function execute() {
        if ($this->_remaining_calls < 1) {
            throw new HTTP_Exception_401("This Ajax request has expired its remaining calls.");
        }
        $this->_remaining_calls--;
        parent::execute();
    }

}

?>

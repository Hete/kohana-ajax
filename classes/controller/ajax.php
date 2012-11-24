<?php

class Controller_Ajax extends Controller {

    /**
     *
     * @var Ajax_Request 
     */
    private $ajax_request;

    public function before() {

        if (!$this->request->is_ajax()) {
            throw new HTTP_Exception_401("Only ajax request are authorized.");
        }

        $this->ajax_request = Cache::instance("ajax")->get($this->request->param("token"));

        if (!$this->ajax_request instanceof Request_Ajax) {
            throw new HTTP_Exception_401("Not a valid Ajax request for token :token", array(":token" => $this->request->param("token")));
        }
    }

    public function action_index() {

        // Reflecting an internal or external request
        $ajax_request = Cache::instance("ajax")->get($this->request->param("token"));

        // We execute the request as a response
        $this->response->body($this->ajax_request->execute());
    }

    public function after() {
        // Token is consumed in the request
        Ajax::instance()->remove($this->request->param("token"));
        parent::after();
    }

}

?>

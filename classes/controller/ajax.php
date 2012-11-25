<?php

/**
 * Controller to deal with Ajax requests.

 */
class Controller_Ajax extends Controller {

    /**
     *
     * @var Request_Ajax 
     */
    private $request_ajax;

    public function before() {

        if (!$this->request->is_ajax()) {
            throw new HTTP_Exception_401("Only ajax request are authorized.");
        }

        $this->request_ajax = Cache::instance("ajax")->get($this->request->param("token"));

        if (!$this->request_ajax instanceof Request_Ajax) {
            throw new HTTP_Exception_401("Not a valid Ajax request for token :token", array(":token" => $this->request->param("token")));
        }
    }

    public function action_index() {

        // We pass this request parameters to the Ajax request.
        $this->request_ajax->headers($this->request->headers());
        $this->request_ajax->post($this->request->post());
        $this->request_ajax->query($this->request->query());

        // We execute the request as a response
        $this->response->body($this->request_ajax->execute());
    }

    public function after() {
        // Token is consumed in the request
        if ($this->request_ajax->remaining_calls() < 0) {
            Ajax::instance()->remove($this->request->param("token"));
        }
        parent::after();
    }

}

?>

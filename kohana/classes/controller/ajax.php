<?php

/**
 * Controller to deal with Ajax requests.

 */
class Kohana_Controller_Ajax extends Controller {

    /**
     *
     * @var Ajax_Authorization 
     */
    private $ajax_authorization;

    public function before() {

        if (!$this->request->is_ajax()) {
            throw new HTTP_Exception_401("Only ajax request are authorized.");
        }

        $this->ajax_authorization = Cache::instance("ajax")->get($this->request->param("token"));

        if (!$this->ajax_authorization instanceof Ajax_Authorization) {
            throw new HTTP_Exception_401("Not a valid Ajax request for token :token", array(":token" => $this->request->param("token")));
        }

        if (!$this->ajax_authorization->consume()) {
            throw new HTTP_Exception_401("Request fully consumed!", array(":token" => $this->request->param("token")));
        }
    }

    /**
     * Fetch orm data and return them as JSON
     */
    public function action_orm() {
        $this->response->body($this->ajax_authorization->execute());
    }

}

?>

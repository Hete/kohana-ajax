<?php

class Controller_Ajax extends Controller {

    public function before() {
        // Token is consumed in the request
        Ajax::instance()->remove($this->request->param("token"));
    }

}

?>

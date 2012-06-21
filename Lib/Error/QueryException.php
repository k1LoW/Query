<?php

class QueryException extends CakeException {

    /**
     * Constructor
     *
     */
    public function __construct($message = null, $code = 404) {
        if (empty($message)) {
            $message = __d('Query', 'QueryException');
        }
        parent::__construct($message, $code);
    }

}
<?php namespace AlistairShaw\NameExploder\Exceptions;

class NameExploderException extends \Exception {

    public function __construct($message, $code = 0)
    {
        parent::__construct($message, $code);
    }

}
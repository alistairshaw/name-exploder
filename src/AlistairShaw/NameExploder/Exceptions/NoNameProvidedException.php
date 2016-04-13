<?php namespace AlistairShaw\NameExploder\Exceptions;

class NoNameProvidedException extends NameExploderException {

    public function __construct()
    {
        parent::__construct("No Name Provided");
    }

}
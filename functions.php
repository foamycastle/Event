<?php

use Foamycastle\SoftError\ErrorCollection;
use Foamycastle\SoftError\SoftErrorException;

function softError(string $id,\Throwable $error) {
    if($id==''){
        throw new Exception('soft error id cannot be empty');
    }
    $error=new SoftErrorException($error);
    ErrorCollection::$errors[$id] = $error;
}
function throwSoftError(string $id):void {
    if($id=='') return;
    if(!isset(ErrorCollection::$errors[$id])) return;
    throw ErrorCollection::$errors[$id]->getPrevious();
}

function getLastSoftError(): SoftErrorException {
    return end(ErrorCollection::$errors);
}
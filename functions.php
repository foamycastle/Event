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
function getSoftError(string $id):?\Throwable
{
    return ErrorCollection::$errors[$id] ?? null;
}

function getLastSoftError(): SoftErrorException {
    return end(ErrorCollection::$errors);
}
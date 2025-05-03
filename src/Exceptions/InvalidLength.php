<?php

namespace PasswordGen\Exceptions;

use Exception;

/**
 * The password or site name length must be a positive number.
 */
class InvalidLength extends Exception
{

    /**
     * Constructor of the InvalidLength class
     * @param $message
     * @param $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
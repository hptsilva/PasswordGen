<?php

namespace PasswordGen\Exceptions;

use Exception;

/**
 * The ID must be valid.
 */

class InvalidID extends Exception
{
    /**
     * Constructor of the InvalidID class
     * @param $message
     * @param $code
     * @param Exception|null $previous
     */
    public function __construct($message = "", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
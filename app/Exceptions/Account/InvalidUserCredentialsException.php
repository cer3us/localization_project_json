<?php

namespace App\Exceptions\Account;

use Exception;

class InvalidUserCredentialsException extends Exception
{
    //from localization folder:
    protected $message = 'InvalidUserCredentials';
}

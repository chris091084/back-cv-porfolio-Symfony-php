<?php


namespace App\Exception;


use Doctrine\DBAL\Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class ValidationObjectException extends Exception
{
    public function __construct($violations, $code = 0, Throwable $previous = null)
    {

        $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';

        foreach ($violations as $violation){
            $message     .= sprintf( "Field %s: %s ",
                $violation->getPropertyPath(),
                $violation->getMessage());
        }
        parent::__construct($message, $code, $previous);
    }
}
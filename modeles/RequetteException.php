<?php

/**
 * Cette classe ne rajoute rien à Exception mais permet une meilleur gestion et affichage des exceptions.
 *
 * Class RequetteException
 */
class RequetteException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
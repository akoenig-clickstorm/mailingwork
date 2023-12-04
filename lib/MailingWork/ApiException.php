<?php

namespace bconnect\MailingWork;

use Exception;

class ApiException extends Exception
{
    // Die Exception neu definieren, damit die Mitteilung nicht optional ist
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        // etwas Code

        // sicherstellen, dass alles korrekt zugewiesen wird
        parent::__construct($message, $code, $previous);
    }

}

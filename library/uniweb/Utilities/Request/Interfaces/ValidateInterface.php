<?php
namespace Uniweb\Library\Utilities\Request\Interfaces;

use Uniweb\Library\Utilities\Request\Exception\ValidateException;

interface ValidateInterface
{
    /**
     * Validálja a kérést.
     * 
     * @param mixed $request Kérés adatok.
     * @return boolean Valid-e a kérés.
     * @throws ValidateException
     */
    public function validate($request);
}
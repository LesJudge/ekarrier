<?php
namespace Uniweb\Library\Utilities\Request\Interfaces;

interface ValidateInterface
{
    /**
     * Validálja a kérést.
     * @param mixed $request Kérés adatok.
     * @return boolean Valid-e a kérés.
     * @throws \Uniweb\Library\Utilities\Request\Exception\ValidateException
     */
    public function validate($request);
}
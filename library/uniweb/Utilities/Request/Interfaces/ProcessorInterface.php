<?php
namespace Uniweb\Library\Utilities\Request\Interfaces;

interface ProcessorInterface
{
    /**
     * Feldolgozza a kérést.
     * @param mixed $request Kérés adatok.
     * @return mixed A feldolgozott kérés.
     * @throws \Uniweb\Library\Utilities\Request\Exception\ProcessorException
     */
    public function process($request);
}
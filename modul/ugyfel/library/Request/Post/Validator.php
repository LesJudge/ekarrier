<?php
namespace Uniweb\Module\Ugyfel\Library\Request\Post;
use Uniweb\Library\Utilities\Request\Interfaces\ValidateInterface;
use Uniweb\Library\Utilities\Request\Exception\ValidateException;
use Uniweb\Library\Validator\EmptyArray;

class Validator implements ValidateInterface
{
    public function validate($request)
    {
        $emptyArrayValidator = new EmptyArray;
        if (
            isset($request['post']['client']) 
            && 
            !$emptyArrayValidator->validate($request['post']['client']) 
            && 
            isset($request['post']['relationships']) 
            && 
            !$emptyArrayValidator->validate($request['post']['relationships'])
        ) {
            return true;
        }
        throw new ValidateException('Az ügyfél mentése nem lehetséges, mert hibás kérés érkezett a szerver felé!');
    }
}
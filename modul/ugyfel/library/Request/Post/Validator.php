<?php
namespace Uniweb\Module\Ugyfel\Library\Request\Post;

use Uniweb\Library\Utilities\Request\Exception\ValidateException;
use Uniweb\Library\Utilities\Request\Interfaces\ValidateInterface;
use Uniweb\Library\Validator\EmptyArray;

class Validator implements ValidateInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate($request)
    {
        if ($this->validatePostItem($request, 'client') && $this->validatePostItem($request, 'relationships')) {
            return true;
        }
        
        throw new ValidateException('Az ügyfél mentése nem lehetséges, mert hibás kérés érkezett a szerver felé!');
    }
    
    /**
     * Megvizsgálja, hogy létezik-e a kérés POST-ban a paraméterül adott index és nem üres tömb-e.
     * 
     * @param array $request Kérés tömb.
     * @param string $key A keresett kulcs.
     * @return bool
     */
    private function validatePostItem($request, $key)
    {
        $emptyArrayValidator = new EmptyArray;
        
        return isset($request['post'][$key]) && !$emptyArrayValidator->validate($request['post'][$key]);
    }
}
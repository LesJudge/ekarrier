<?php
namespace Tests\Uniweb\Library\Utilities\Behavior\Src;
use Uniweb\Library\Utilities\Behavior\AbstractBehavior;

class Behavior3 extends AbstractBehavior
{
    public function notRequiredCallback()
    {
        echo __METHOD__, PHP_EOL;
    }
}
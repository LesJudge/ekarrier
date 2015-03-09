<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Behavior;
use Uniweb\Library\Utilities\Behavior\AbstractBehavior as Behavior;
use Uniweb\Library\Utilities\Behavior\Exception\BehaviorException;
/**
 * @property \ActiveRecord\Model $owner Behavior tulajdonosa.
 */
abstract class AbstractBehavior extends Behavior
{
    public function setOwner($owner)
    {
        if (is_object($owner) && $owner instanceof \ActiveRecord\Model) {
            $this->owner = $owner;
        } else {
            throw new BehaviorException('A tulajdonosnak az \\ActiveRecord\\Model osztályból kell származnia!');
        }
    }
}
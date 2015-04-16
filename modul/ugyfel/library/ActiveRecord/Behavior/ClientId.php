<?php
namespace Uniweb\Module\Ugyfel\Library\ActiveRecord\Behavior;
use Uniweb\Library\Utilities\ActiveRecord\Behavior\ResourceKey;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;
/**
 * Ügyfél azonosító behavior.
 */
class ClientId extends ResourceKey
{
    /**
     * Ügyfél azonosító mező neve.
     * @var string
     */
    protected $resourceKeyAttribute = 'ugyfel_id';
    /**
     * Nem megfelelő ügyfél azonosító esetén megjelenő hibaüzenet.
     * @var string
     */
    protected $invalidKeyMessage = 'Az ügyfél azonosító nem megfelelő!';
    /**
     * Visszatér az ügyfél azonosítóval.
     * @return int
     */
    public function get_ugyfel_id()
    {
        return $this->owner->read_attribute($this->resourceKeyAttribute);
    }
    /**
     * Beállítja az ügyfél azonosítót.
     * @param int $ugyfel_id Ügyfél azonosító.
     */
    public function set_ugyfel_id($ugyfel_id)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute($this->resourceKeyAttribute, $ugyfel_id, $this->owner);
    }
}
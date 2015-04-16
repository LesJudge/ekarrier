<?php
namespace Uniweb\Library\Utilities\ActiveRecord\Observer;
use Uniweb\Library\Utilities\ActiveRecord\Observer\AbstractAdapter;
use Uniweb\Library\Resource\Observer\Interfaces\SavableInterface;
use Uniweb\Library\Utilities\ActiveRecord\Assign\WithoutCast as AssignWithoutCast;

class SaveAdapter extends AbstractAdapter implements SavableInterface
{
    /**
     * Menti a modelt.
     * @return boolean
     */
    public function save()
    {
        return $this->model->save();
    }
    /**
     * Beállítja az "erőforrás" azonosítót.
     * @param int $resourceId "Erőforrás" azonosító.
     */
    public function setResourceId($resourceId)
    {
        $assignWithoutCast = new AssignWithoutCast;
        $assignWithoutCast->assignAttribute($this->model->getResourceKey(), $resourceId, $this->model);
    }
}
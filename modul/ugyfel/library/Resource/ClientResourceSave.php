<?php
namespace Uniweb\Module\Ugyfel\Library\Resource;

use Exception;
use Uniweb\Library\Resource\Interfaces\ResourceInterface;
use Uniweb\Library\Resource\Interfaces\ResourceSaveInterface;
use Uniweb\Library\Resource\Observer\SaveObserver;
use Uniweb\Library\Resource\Observer\StatefulResourceSubject;
use Uniweb\Library\Resource\Observer\ValidateObserver;
use Uniweb\Library\Utilities\ActiveRecord\Observer\SaveAdapter;
use Uniweb\Library\Utilities\ActiveRecord\Observer\ValidateAdapter;

class ClientResourceSave implements ResourceSaveInterface
{
    public function save(
        ResourceInterface $resource, 
        array $relatedModels = array(), 
        array $deletablesByResource = array()
    ) {
        $validate = new StatefulResourceSubject($resource);
        if (!empty($relatedModels)) {
            foreach ($relatedModels as $relatedModel) {
                if (is_array($relatedModel)) {
                    foreach ($relatedModel as $collectionItem) {
                        $validate->attach(new ValidateObserver(new ValidateAdapter($collectionItem)));
                    }
                } else {
                    $validate->attach(new ValidateObserver(new ValidateAdapter($relatedModel)));
                }
            }
        }
        $validate->notify();
        if ($resource->is_valid() && $validate->isOk()) {
            $connection = $resource->connection();
            $connection->transaction();
            try {
                if (!$resource->is_new_record() && !empty($deletablesByResource)) {
                    foreach ($deletablesByResource as $deletableByResource) {
                        $deletableByResource->deleteByResource($resource);
                    }
                }
                $save = new StatefulResourceSubject($resource);
                $saved = $resource->save(false);
                if ($saved) {
                    $observers = $validate->getObservers();
                    foreach ($observers as $observer) {
                        $save->attach(new SaveObserver(new SaveAdapter($observer->getModel()->getModel())));
                    }
                }
                $save->notify();
                if ($saved && $save->isOk()) {
                    $connection->commit();
                    return true;
                } else {
                    $connection->rollback();
                    return false;
                }
            } catch (Exception $ex) {
                $connection->rollback();
            }
        }
        return false;
    }
}
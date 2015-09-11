<?php
namespace Uniweb\Module\Ugyfel\Library\Facade\Form;

use ArrayObject;
use Uniweb\Library\Form\Interfaces\AssignableInterface;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Abstracts\CommentAbstract;
use Uniweb\Module\Ugyfel\Model\ActiveRecord\Client;

/**
 * Description of CollectedCommentsFacade
 *
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
class CollectedCommentsFacade implements AssignableInterface
{
    /**
     * @var Client
     */
    private $client;
    
    private $emptyComment;
    
    public function __construct(Client $client, $emptyComment = 'Ehhez még nem írtak megjegyzést!')
    {
        $this->client = $client;
        $this->emptyComment = $emptyComment;
    }
    
    public function assign(ArrayObject $data)
    {
        $collectedComments = "";
        
        $collectedComments .= $this->collectComment('Személyes adatok', $this->client->commentpersonaldata);
        $collectedComments .= $this->collectComment('Munkaerőpiaci helyzete', $this->client->commentlabormarket);
        $collectedComments .= $this->collectComment('Projektinformációk', $this->client->commentprojectinformation);
        $collectedComments .= $this->collectComment('Munkakörök/munkarend', $this->client->commentjob);
        $collectedComments .= $this->collectComment(
            'Végzettségek/Nyelvtudás/Tanulmányok/Számítógépes ismeretek', 
            $this->client->commenteducation
        );
        $collectedComments .= $this->collectComment('Dokumentumok', $this->client->commentdocument);
        
        $data->offsetSet('collectedComments', $collectedComments);
    }
    
    private function collectComment($label, CommentAbstract $comment = null)
    {
        $comment = is_null($comment) || empty($comment->megjegyzes) ? $this->emptyComment : $comment->megjegyzes;
        return sprintf("%s:\n\n%s\n%s\n\n", $label, $comment, str_repeat('.', 300));
    }
    
    public function getClient()
    {
        return $this->client;
    }
}

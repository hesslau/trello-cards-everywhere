<?php
/**
 * Created by PhpStorm.
 * User: hesslau
 * Date: 5/23/17
 * Time: 6:35 PM
 */

class TrelloCard implements JsonSerializable
{

    private $trelloCard;
    private $trelloClient;

    public function __construct($trelloClient, $trelloCard) {
        $this->trelloCard = $trelloCard;
        $this->trelloClient = $trelloClient;

        $this->resolveChecklists();
        $this->resolveCoverLink();

        return $this;
    }

    public function resolveChecklists() {
        $checklists = [];
        foreach ($this->trelloCard->idChecklists as $idChecklist) {
            $checklists[] = $this->trelloClient->getChecklist($idChecklist);
        }
        $this->trelloCard->checklists = $checklists;
    }

    public function resolveCoverLink() {
        $cover = $this->trelloClient->getCardAttachment($this->trelloCard->id, $this->trelloCard->idAttachmentCover);
        $this->trelloCard->cover = $cover;
    }

    public function getName() {
        return $this->trelloCard->name;
    }

    public function jsonSerialize() {
        return $this->trelloCard;
    }

}
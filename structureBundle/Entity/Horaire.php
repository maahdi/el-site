<?php
namespace EuroLiterie\structureBundle\Entity;

use JsonSerializable;

class Horaire implements JsonSerializable
{
    protected $jour;
    protected $matin;
    protected $aprem;
    protected $fermer = false;

    public function getJour()
    {
        return $this->jour;
    }
    public function setJour($jour)
    {
        $this->jour = $jour;
        return $this;
    }

    public function getMatin($position)
    {
        if ($this->fermer)
        {
            return 'Fermé';
        }else{
            return $this->matin[$position]->format('G\hi');
        }
    }

    public function setFermer($jour)
    {
        $this->jour = $jour;
        $this->fermer = true;
        return $this;
    }

    public function setMatin($matin, $position)
    {
        if ($this->debutOrFin($position))
        {
            $this->matin['debut'] = $this->setIntoDate($matin);
        }else
        {
            $this->matin['fin'] = $this->setIntoDate($matin);
        }
        return $this;
    }
    public function getFermer()
    {
        return $this->fermer;
    }

    public function getAprem($position)
    {
        if (!($this->fermer))
        {

            return $this->aprem[$position]->format('G\hi');
        }
    }

    public function setAprem($aprem, $position)
    {
        if ($this->debutOrFin($position))
        {
            $this->aprem['debut'] = $this->setIntoDate($aprem);
        }else
        {
            $this->aprem['fin'] = $this->setIntoDate($aprem);
        }
        return $this;
    }

    private function debutOrFin($position)
    {
        if ($position == 'debut')
        {
            return true;
        }else if($position == 'fin')
        {
            return false;
        }
    }

    private function setIntoDate($heure)
    {
        return \Datetime::createFromFormat('G:i',$heure);
    }

    public function jsonSerialize()
    {
        return array('jour' => $this->jour,
                    'matin' => array('debut' => $this->getMatin('debut'),
                                    'fin' => $this->getMatin('fin')),
                    'aprem' => array('debut' => $this->getAprem('debut'),
                                    'fin' => $this->getAprem('fin')));
    }
}


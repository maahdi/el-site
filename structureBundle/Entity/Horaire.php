<?php
namespace EuroLiterie\structureBundle\Entity;

class Horaire
{
    protected $jour;
    protected $matin;
    protected $aprem;

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
        return $this->matin[$position]->format('G\hi');
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

    public function getAprem($position)
    {
        return $this->aprem[$position]->format('G\hi');
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
}


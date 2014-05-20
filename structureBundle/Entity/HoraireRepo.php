<?php
namespace EuroLiterie\structureBundle\Entity;

use EuroLiterie\structureBundle\Entity\Horaire;
use EuroLiterie\structureBundle\XML\MyXml;

class HoraireRepo extends MyXml
{
    public function getHoraires()
    {
        $horaires = array();
        $jours = new \SimpleXmlElement(file_get_contents($this->getXmlFilePath('horaire')));
        foreach ($jours->jour as $jour)
        {
            $horaire = new Horaire();
            $horaire->setJour((string)$jour->name);
            if ((bool) $jour->fermer)
            {
                $horaire->setFermer((string)$jour->name);
                $horaires[] = $horaire;
                
            }else
            {
                $horaire->setMatin((string)$jour->matin['debut'], 'debut');
                $horaire->setMatin((string)$jour->matin['fin'], 'fin');
                $horaire->setAprem((string)$jour->aprem['debut'], 'debut');
                $horaire->setAprem((string)$jour->aprem['fin'], 'fin');
                $horaires[] = $horaire;
            }
        }
        return $horaires;
    }

    public function findForAdmin()
    {
        return $this->getHoraires();
    }
    
    public function save ($elem)
    {
        
    }
}

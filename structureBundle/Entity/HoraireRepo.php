<?php
namespace EuroLiterie\structureBundle\Entity;
use EuroLiterie\structureBundle\Entity\Horaire;

class HoraireRepo
{
    private $path ='EuroLiterie/structureBundle/XML/horaire.xml';
    public function getHoraires()
    {
        $horaires = array();
        $jours = new \SimpleXmlElement(file_get_contents($this->getXmlFilePath($this->path)));
        foreach ($jours->jour as $jour)
        {
            $horaire = new Horaire();
            $horaire->setJour((string)$jour->name);
            $horaire->setMatin((string)$jour->matin['debut'], 'debut');
            $horaire->setMatin((string)$jour->matin['fin'], 'fin');
            $horaire->setAprem((string)$jour->aprem['debut'], 'debut');
            $horaire->setAprem((string)$jour->aprem['fin'], 'fin');
            $horaires[] = $horaire;
        }
        return $horaires;
    }
    
    private function getXmlFilePath($path)
    {
        $dir = preg_split('/\/src/',__DIR__);
        return $dir[0].'/src/'.$path;
        
    }
}

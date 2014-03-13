<?php
namespace EuroLiterie\structureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 *@ORM\Entity(repositoryClass="MarqueRepo")
 *@ORM\Table(name="marques")
 *@ORM\HasLifecycleCallbacks()
 */
class Marque implements JsonSerializable
{
    protected $html;
    
    /**
     *@ORM\Id
     *@ORM\Column(type="integer")
     */
    protected $idMarque;

    /**
     *@ORM\Column(type="string")
     */
    protected $nomMarque;

    /**
     *@ORM\Column(type="string")
     */
    protected $pngUrl;

    /**
     *@ORM\Column(type="string")
     */
    protected $content;

    /**
     *@ORM\Column(type="string")
     */
    protected $marqueLien;

    /**
     * Set idMarque
     *
     * @param integer $idMarque
     * @return Marque
     */
    public function setIdMarque($idMarque)
    {
        $this->idMarque = $idMarque;
    
        return $this;
    }

    /**
     * Get idMarque
     *
     * @return integer 
     */
    public function getIdMarque()
    {
        return $this->idMarque;
    }

    /**
     * Set nomMarque
     *
     * @param string $nomMarque
     * @return Marque
     */
    public function setNomMarque($nomMarque)
    {
        $this->nomMarque = $nomMarque;
    
        return $this;
    }

    /**
     * Get nomMarque
     *
     * @return string 
     */
    public function getNomMarque()
    {
        return $this->nomMarque;
    }

    /**
     * Set pngUrl
     *
     * @param string $pngUrl
     * @return Marque
     */
    public function setPngUrl($pngUrl)
    {
        $this->pngUrl = $pngUrl;
    
        return $this;
    }

    /**
     * Get pngUrl
     *
     * @return string 
     */
    public function getPngUrl()
    {
        return $this->pngUrl;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Marque
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return nl2br($this->content);
    }

    /**
     * Set marqueLien
     *
     * @param string $marqueLien
     * @return Marque
     */
    public function setMarqueLien($marqueLien)
    {
        $this->marqueLien = $marqueLien;
    
        return $this;
    }

    /**
     * Get marqueLien
     *
     * @return string 
     */
    public function getMarqueLien()
    {
        return $this->marqueLien;
    }

    public function jsonSerialize()
    {
        return array('idMarque' => $this->idMarque,
            'nomMarque' => $this->nomMarque,
            'content' => $this->content,
            'marqueLien' => $this->marqueLien,
            'pngUrl' => $this->pngUrl);
    }
}

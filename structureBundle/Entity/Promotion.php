<?php
namespace EuroLiterie\structureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 *@ORM\Entity(repositoryClass="PromotionRepo")
 *@ORM\Table(name="promotions")
 *@ORM\HasLifecycleCallbacks()
 */
class Promotion implements JsonSerializable
{
    /**
     *@ORM\Id
     *@ORM\Column(type="integer")
     */
    protected $id;

    /**
     *@ORM\Column(type="integer")
     */
    protected $promoId;

    /**
     *@ORM\Column(type="string")
     */
    protected $tag;

    /**
     *@ORM\Column(type="text")
     */
    protected $PromoDesc;

    /**
     *@ORM\Column(type="date")
     */
    protected $dateDebut;

    /**
     *@ORM\Column(type="date")
     */
    protected $dateFin;

    /**
     *@ORM\Column(type="decimal", scale=2)
     */
    protected $promoPrix;
    protected $actuel = false;
    protected $venir = false;
    public function getActuel()
    {
        return $this->actuel;
    }
    public function getVenir()
    {
        return $this->venir;
    }

    public function jsonSerialize()
    {
        return array('id'=> $this->id,
            'PromoDesc' => $this->PromoDesc,
            'dateDebut' => $this->getDateDebut(),
            'dateFin' => $this->getDateFin());
    }

    /**
     *@ORM\PostLoad
     */
    public function setPeriodeAffichage()
    {
        $date = new \Datetime();
        if ($date > $this->dateDebut && $date < $this->dateFin)
        {
            $this->actuel = true;
            $this->venir = false;
        }else if ($date < $this->dateDebut)
        {
            $this->actuel = false;
            $this->venir = true;
        }else
        {
            $this->actuel = false;
            $this->venir = false;
        }
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Promotion
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set promoId
     *
     * @param integer $promoId
     * @return Promotion
     */
    public function setPromoId($promoId)
    {
        $this->promoId = $promoId;
    
        return $this;
    }

    /**
     * Get promoId
     *
     * @return integer 
     */
    public function getPromoId()
    {
        return $this->promoId;
    }

    /**
     * Set tag
     *
     * @param string $tag
     * @return Promotion
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    
        return $this;
    }

    /**
     * Get tag
     *
     * @return string 
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set PromoDesc
     *
     * @param string $promoDesc
     * @return Promotion
     */
    public function setPromoDesc($promoDesc)
    {
        $this->PromoDesc = $promoDesc;
    
        return $this;
    }

    /**
     * Get PromoDesc
     *
     * @return string 
     */
    public function getPromoDesc()
    {
        return nl2br($this->PromoDesc);
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Promotion
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    
        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->dateDebut->format('d/m/Y');
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     * @return Promotion
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    
        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime 
     */
    public function getDateFin()
    {
        return $this->dateFin->format('d/m/Y');
    }

    /**
     * Set promoPrix
     *
     * @param float $promoPrix
     * @return Promotion
     */
    public function setPromoPrix($promoPrix)
    {
        $this->promoPrix = $promoPrix;
    
        return $this;
    }

    /**
     * Get promoPrix
     *
     * @return float 
     */
    public function getPromoPrix()
    {
        return $this->promoPrix;
    }
}

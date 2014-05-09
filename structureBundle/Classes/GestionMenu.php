<?php
namespace EuroLiterie\structureBundle\Classes;

use Yomaah\structureBundle\Classes\BundleDispatcher;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Yomaah\ajaxBundle\Controller\AjaxController;



class GestionMenu
{
    private $em;
    private $dispatcher;
    private $db;

    public function __construct(\Doctrine\ORM\EntityManager $em, BundleDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->em = $em;
    }

    public function getMenu()
    {
        if (!($this->dispatcher->testException()))
        {
            if ($this->dispatcher->isClientSite())
            {
                $params['slider'] = $this->getSlider();
                $params['actuel'] = $this->getPromo();
                return $params;
            }else
            {
                return array();
            }
        }else
        {
            if ($this->dispatcher->getSite() == 'literie')
            {
                $params['slider'] = $this->getSlider();
                $params['actuel'] = $this->getPromo();
                $params['position'] = self::getOnException();
                return $params;

            }else
            {
                return array();
            }
        }
    }

    static function getOnException()
    {
        return array('position' => 'Erreur');
    }

    public function getPromo()
    {
        $promotions = $this->em->getRepository('EuroLiteriestructureBundle:Promotion')
                ->findBy(array('tag'=>'periode'), array('dateDebut' => 'asc'));
        $i =0;
        $actuel = false;
        foreach ($promotions as $promo)
        {
            if ($promo->getActuel())
            {
                $actuel[] = $promo;
            }
        }
        return $actuel;
        
    }
    public function getSlider()
    {
        $file = AjaxController::imageSearch('/slider/active', 'EuroLiterie/structureBundle');
        if (count($file) <= 5)
        {
            $slider = AjaxController::imageSearch('/slider/active', 'EuroLiterie/structureBundle');
        }else
        {
            for ($i = 0; $i < 4; $i++)
            {
                $tmpFile[] = $file[$i];
            }
            $slider = $tmpFile;
        }
        return $slider;
        
    }
}

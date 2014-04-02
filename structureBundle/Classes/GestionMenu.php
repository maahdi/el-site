<?php
namespace EuroLiterie\structureBundle\Classes;

use Yomaah\structureBundle\Classes\BundleDispatcher;
use Symfony\Component\Security\Core\SecurityContextInterface;
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

    public function getSlider()
    {
        if (!($this->dispatcher->testException()))
        {
            if ($this->dispatcher->isClientSite())
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
                $file = AjaxController::imageSearch('/slider/active', 'EuroLiterie/structureBundle');
                if (count($file) < 5)
                {
                    $params['slider'] = AjaxController::imageSearch('/slider/active', 'EuroLiterie/structureBundle');
                }else
                {
                    for ($i = 0; $i < 4; $i++)
                    {
                        $tmpFile[] = $file[$i];
                    }
                    $params['slider'] = $tmpFile;
                }
                $params['actuel'] = $actuel;
                return $params;
            }else
            {
                return array();
            }
        }
    }
}

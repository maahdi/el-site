<?php
namespace EuroLiterie\structureBundle\Classes;


class MenuTwigExtension extends \Twig_Extension
{
    protected $menu;
    protected $dispatcher;

    public function __construct(\EuroLiterie\structureBundle\Classes\GestionMenu $menu, \Yomaah\structureBundle\Classes\BundleDispatcher $dispatcher)
    {
        $this->menu = $menu;
        $this->dispatcher = $dispatcher;
    }

    public function getName()
    {
        return 'literie_menuTwigExtension';
    }

    public function getGlobals()
    {
        if (($this->dispatcher->isClientSite() && $this->dispatcher->getSite() == 'literie') || $this->dispatcher->getDeployed())
        {
            return $this->menu->getMenu();
            
        }else
        {
            return array();
        }
    }
}

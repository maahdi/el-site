<?php
namespace EuroLiterie\structureBundle\Classes;

/**
 * Extension Twig pour remplir les variables pour le menu automatiquement
 *
 **/
class MenuTwigExtension extends \Twig_Extension
{
    protected $menu;

    public function __construct(\EuroLiterie\structureBundle\Classes\GestionMenu $menu)
    {
        $this->menu = $menu;
    }

    public function getName()
    {
        return 'literie_menuTwigExtension';
    }

    public function getGlobals()
    {
        return $this->menu->getAllMenu();
    }
}

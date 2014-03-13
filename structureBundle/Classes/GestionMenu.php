<?php

namespace EuroLiterie\structureBundle\Classes;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Classe pour remplir les menus
 * Utilisé par MenuTwigExtension
 *
 **/
class GestionMenu
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function getAllMenu()
    {
        $request = $this->container->get('request');
        if (!(preg_match('/ajax/',$request->getPathInfo())))
        {
            return $this->getMenu($request);
        }else
        {
            return array(false);
        }
    }

    public function getMenu($request)
    {
        $session = $request->getSession();
        $secure = $this->container->get('security.context');
        $user = $secure->getToken()->getUser();
        /**
         * L'utilisateur doit être connecter
         * soit un client soit moi
         **/
        if ((!($user == "anon."))&& $secure->isGranted('ROLE_ADMIN'))
        {
            /**
             * Partie pour tester le site avec mon identifiant
             * !!!Attention!!! 
             * A enlever
             * en prod mettre : 

$menus = $this->getMenuFromRepo('left','Menu');
if ((!($user == "anon."))&& $secure->isGranted('ROLE_ADMIN'))
{
    $admin = false;
    if ($secure->isGranted('ROLE_ADMIN'))
    {
        $admin = true;
        $this->setAdminMenu($menus);
        return $this->getRetour('admin',$menus);
    }
}else
{
    return $this->getRetour('normal',$menus);
}

             */
            if ($secure->isGranted('ROLE_SUPER_ADMIN'))
            {
                $menus = $this->getMenuFromRepo('left','Menu');
                if (($session->get('zoneAdmin') != null) && $session->get('zoneAdmin'))
                {
                    $this->setAdminMenu($menus);
                    $session->set('idSite', 1);
                    return $this->getRetour('admin',$menus);
                }else
                {
                    return $this->getRetour('normal',$menus);
                }

            }else
            {
                $sitesAvailables = $user->getSites();
                $auth = false;
                /**
                 * vérifie que le site appartient bien à l'utilisateur qui le visite
                 */
                foreach ($sitesAvailables as $site)
                {
                    if ($site->getNomSite() == 'literie')
                    {
                        $session->set('idSite', 1);
                        $auth = true;
                    }
                }
                $menus = null;
                if ($auth)
                {
                  $menus = $this->getMenuFromRepo('left','Menu');
                }
                /**
                 * pour simuler connexion à la zone admin
                 */
                if (($session->get('zoneAdmin') != null) && $session->get('zoneAdmin'))
                {
                    $this->setAdminMenu($menus);
                    return $this->getRetour('admin',$menus);
                }else
                {
                    return $this->getRetour('normal', $menus);
                }
            }
        }return array(false);
       }
    

    private function getRetour($retour, $menus)
    {
        if ($retour == 'admin')
        {
            $visite = $this->getVisite();
            return array('menus' => $menus,'literie_admin' => true,'visite' => $visite);
        }else if ($retour == 'normal')
        {
            return array('menus' => $menus,'literie_admin' => false);
        }
    }
    private function getVisite()
    {
        $db = $this->container->get('database_connection');
        $sql = 'select count(idVisite) as nb from visites as v left join utilisateur as u on v.idUser = u.idUser where u.idGroup !=1 or v.idUser = 0';
        $result = $db->query($sql);
        $result->setFetchMode(\PDO::FETCH_OBJ);
        foreach ($result as $r)
        {
            $visite['total'] = $r->nb;
        }
        $sql = 'select count(idVisite) as nb from visites as v left join utilisateur as u on v.idUser = u.idUser where extract( month from current_date) = extract( month from dateConnexion) and (u.idGroup != 1 or v.idUser = 0)';
        $result = $db->query($sql);
        $result->setFetchMode(\PDO::FETCH_OBJ);
        foreach ($result as $r)
        {
            $visite['mois'] = $r->nb;
        }
        return $visite;

    }

    private function setAdminMenu($menu)
    {
        foreach ($menu as $m)
        {
            $m->setPath('admin_'.$m->getPath());
        }
    }

    private function setTestMenu($menu)
    {
        foreach ($menu as $m)
        {
            $m->setPath('test_'.$m->getPath());
        }
        
    }

    public function isGranted($role)
    {
        if ($this->secure->isGranted($role))
        {
            return true;
        }else
        {
            return false;
        }
    }
    private function getMenuFromRepo($position, $menu)
    {
        if ($position == 'left')
        {
            $fn = 'getLeft'.$menu;
        }else if ($position == 'right')
        {
            $fn = 'getRight'.$menu;
        }
        /**
         * A Remplacer en prod
$site = null;
         */
        $site = 1;
        return $this->container->get('doctrine.orm.default_entity_manager')->getRepository('yomaahBundle:'.$menu)->$fn($site);
    }

}

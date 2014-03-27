<?php
namespace EuroLiterie\structureBundle\Classes;

use Yomaah\structureBundle\Classes\BundleDispatcher;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Classe pour remplir les menus
 * Utilisé par MenuTwigExtension
 *
 **/
class GestionMenu
{
    private $db;
    private $em;
    private $secure;
    private $session;

    public function __construct(\Doctrine\ORM\EntityManager $em, \Doctrine\DBAL\Connection $db, SecurityContextInterface $secure, Session $session)
    {
        $this->session = $session;
        $this->db = $db;
        $this->em = $em;
        $this->secure = $secure;
    }

    public function getAllMenu()
    {
        //$request = $this->container->get('request');
        //if (!(preg_match('/ajax/',$request->getPathInfo())))
        //{
            //return $this->getMenu($request);
        //}else
        //{
            //return array(false);
        //}
        return $this->getMenu();
    }

    public function getMenu()
    {
        $user = $this->secure->getToken()->getUser();
        /**
         * L'utilisateur doit être connecter
         * soit un client soit moi
         **/
        if ($this->secure->getToken() != null)
        {
            /**
             * Partie pour tester le site avec mon identifiant
             * !!!Attention!!! 
             * A enlever
             * en prod mettre : 

$menus = $this->getMenuFromRepo('left','Menu');
if ((!($user == "anon."))&& $secure->isGranted('ROLE_ADMIN'))
{
    if ($secure->isGranted('ROLE_ADMIN'))
    {
        $this->setAdminMenu($menus);
        return $this->getRetour('admin',$menus);
    }
}else
{
    return $this->getRetour('normal',$menus);
}

 */
            if ((!($user == "anon."))&& $this->secure->isGranted('ROLE_ADMIN'))
            {
                if ($this->secure->isGranted('ROLE_SUPER_ADMIN'))
                {
                    $menus = $this->getMenuFromRepo('left','Menu');
                    if (($this->session->get('zoneAdmin') != null) && $this->session->get('zoneAdmin'))
                    {
                        $this->setAdminMenu($menus);
                        //$session->set('idSite', 1);
                        return $this->getRetour('admin',$menus);
                    }else
                    {
                        return $this->getRetour('normal',$menus);
                    }

                }else
                {
                    //$sitesAvailables = $user->getSites();
                    $auth = false;
                    /**
                     * vérifie que le site appartient bien à l'utilisateur qui le visite
                     */
                    //foreach ($sitesAvailables as $site)
                    //{
                        //if ($site->getNomSite() == 'literie')
                        //{
                            //$session->set('idSite', 1);
                            //$auth = true;
                        //}
                    //}
                    $menus = null;
                    if ($auth)
                    {
                      $menus = $this->getMenuFromRepo('left','Menu');
                    }
                    /**
                     * pour simuler connexion à la zone admin
                     */
                    if (($this->session->get('zoneAdmin') != null) && $this->session->get('zoneAdmin'))
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
        $sql = 'select count(idVisite) as nb from visites as v left join utilisateur as u on v.idUser = u.idUser where u.idGroup !=1 or v.idUser = 0';
        $result = $this->db->query($sql);
        $result->setFetchMode(\PDO::FETCH_OBJ);
        foreach ($result as $r)
        {
            $visite['total'] = $r->nb;
        }
        $sql = 'select count(idVisite) as nb from visites as v left join utilisateur as u on v.idUser = u.idUser where extract( month from current_date) = extract( month from dateConnexion) and (u.idGroup != 1 or v.idUser = 0)';
        $result = $this->db->query($sql);
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
        return $this->em->getRepository('yomaahBundle:'.$menu)->$fn($site);
    }

}

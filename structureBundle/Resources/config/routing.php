<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('literie_index', new Route('/', array(
    '_controller' => 'EuroLiteriestructureBundle:Main:index'
)));

$collection->add('literie_accueil', new Route('/accueil', array(
    '_controller' => 'EuroLiteriestructureBundle:Main:accueil'
)));

$collection->add('literie_marques', new Route('/marques', array(
    '_controller' => 'EuroLiteriestructureBundle:Main:marques'
)));

$collection->add('literie_contact', new Route('/contact', array(
    '_controller' => 'EuroLiteriestructureBundle:Main:contact'
)));

$collection->add('literie_magasin', new Route('/magasin', array(
    '_controller' => 'EuroLiteriestructureBundle:Main:magasin'
)));
$collection->add('admin_literie_accueil', new Route('/admin_accueil', array(
    '_controller' => 'EuroLiteriestructureBundle:Main:accueil'
)));

$collection->add('admin_literie_marques', new Route('/admin_marques', array(
    '_controller' => 'EuroLiteriestructureBundle:Main:marques'
)));

$collection->add('admin_literie_contact', new Route('/admin_contact', array(
    '_controller' => 'EuroLiteriestructureBundle:Main:contact'
)));

$collection->add('admin_literie_magasin', new Route('/admin_magasin', array(
    '_controller' => 'EuroLiteriestructureBundle:Main:accueil'
)));
/**
 * A enlever et dans menu.html.twig
 * mettre lien /login
 **/
$collection->add('admin_literie', new Route('/literie/admin', array(
    '_controller' => 'EuroLiteriestructureBundle:Main:admin')));
$collection->add('decoadmin_literie', new Route('/literie/decoadmin', array(
    '_controller' => 'EuroLiteriestructureBundle:Main:decoadmin')));
return $collection;

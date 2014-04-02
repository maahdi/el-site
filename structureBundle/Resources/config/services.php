<?php

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Parameter;

/*

$container->setDefinition(
    'euro_literiestructure.example',
    new Definition(
        'EuroLiterie\structureBundle\Example',
        array(
            new Reference('service_id'),
            "plain_value",
            new Parameter('parameter_name'),
        )
    )
);

*/
$container->setDefinition('literie_gestionMenu',
    new Definition ('EuroLiterie\structureBundle\Classes\GestionMenu',
        array(new Reference('doctrine.orm.entity_manager'), new Reference('bundleDispatcher')))
);


$menutwig = new Definition('EuroLiterie\structureBundle\Classes\MenuTwigExtension',array(new Reference('literie_gestionMenu')));
$menutwig->addTag('twig.extension');
$container->setDefinition('literie_menuTwigExtension',$menutwig);

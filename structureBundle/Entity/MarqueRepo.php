<?php

namespace EuroLiterie\structureBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * MarqueRepo
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MarqueRepo extends EntityRepository 
{
    public function getHtml($url)
    {
        return '<div class="marq admin-c border">
                    <input type="hidden" name="id" value="%idMarque%">
                    <section class="contentMarque">
                        <article class="adminMarque">
                            <label>Nom :</label><input type="text" name="nomMarque" value="%nomMarque%">
                            <label>Texte :</label><textarea class="textareaMarque" name="content" >%content%</textarea>
                            <label>Lien :</label><input type="text" name="marqueLien" value="%marqueLien%">
                        </article>
                        <article class="adminLogoMarque">
                            <label>Logo :</label><figure class="adminMarqueLogo"><img src="'.$url.'marques/%pngUrl%"></img></figure>
                            <section class="btn-logo modif">
                                <li>Modifier</li>
                            </section>
                        </article>
                    </section>
                    <section class="btn-adminPanel">
                        <article class="btn-admin maj">
                            <li>Mettre à jour</li>
                        </article>
                        <article class="btn-admin sup">
                            <li>Supprimer</li>
                        </article>
                    </section>
                </div>';
    }

    public function getNew()
    {
        $marque = new Marque ();
        $marque->setNomMarque('Nom de la marque');
        $marque->setMarqueLien('www.');
        $marque->setPngUrl('amiel.png');
        $marque->setContent('Présentation de la marque');
        $em = $this->getEntityManager();
        $em->persist($marque);
        $em->flush();
        $sql = 'select p from EuroLiteriestructureBundle:Marque p where p.idMarque = (select max(m.idMarque) from EuroLiteriestructureBundle:Marque m)';
        return $em->createQuery($sql)->getSingleResult();
    }
}

<?php

namespace EuroLiterie\structureBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EuroLiterie\structureBundle\Entity\HoraireRepo;
use Yomaah\structureBundle\Entity\MyMail;

class MainController extends Controller
{
    public function indexAction()
    {
        
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:index.html.twig');
    }

    public function accueilAction()
    {
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('accueil',1);
        $promotions = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:Promotion')->findBy(array('tag'=>'periode'), array('dateDebut' => 'asc'));
        $i =0;
        $actuel = array();
        $avenir = array();
        foreach ($promotions as $promo)
        {
            if ($promo->getActuel())
            {
                $actuel[] = $promo;
                $i++;
            }else
            {
                $avenir[] = $promo;
            }
        }
        if ($i == 0)
        {
            $actuel = false;
        }
        if (count($avenir) ==0)
        {
            $avenir = false;
        }
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:accueil.html.twig',
            array('position' => 'Accueil','articles' => $articles,'actuel' => $actuel,'avenir' => $avenir));
    }

    public function marquesAction()
    {
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('marques',1);
        $marques = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:Marque')->findAll();
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:marques.html.twig',
            array('position' => 'Nos Marques', 'articles' => $articles, 'marques' => $marques));
    }

    public function magasinAction()
    {
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:magasin.html.twig',array('position' => 'Notre magasin'));
    }

    public function contactAction()
    {
        $mail =  new MyMail();
        $form = $this->getForm($mail);
        $request = $this->get('request');
        $envoi = false;
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $m = $mail->getSwiftMailer();
                $this->get('mailer')->send($m); 
                $mail =  new MyMail();
                $form = $this->getForm($mail);
                $this->get('session')->set('envoie', true);
                return $this->redirect($this->generateUrl('literie_contact'));
            }
        }
        if ($this->get('session')->has('envoie'))
        {
            $this->get('session')->remove('envoie');
            $envoi = true;
        }
        $h = new HoraireRepo();
        $horaires = $h->getHoraires();
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('contact', 1);
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:contact.html.twig', 
            array('position' => 'Nous trouver', 'horaires' =>$horaires, 'articles' => $articles,'form' => $form->createView(),'envoie' => $envoi));
    }

    private function getForm($mail)
    {
        $formBuilder = $this->createFormBuilder($mail);
        $formBuilder->add('Objet','text',array('attr' => array ('placeholder' => 'L\'objet de votre message'),'label' => 'Sujet de votre message :'))
                    ->add('From','email',array('attr' => array ('placeholder' => 'Votre adresse email'),'label' => 'Votre email :'))
                    ->add('Message','textarea',array('attr' => array ('placeholder' => 'Votre message ...'),'label' => 'Votre message :'));
        return $formBuilder->getForm();
    }

    /**
     * Remplace fonction de login
     * de Yomaah\connexionBundle
     **/
    public function adminAction()
    {
        $this->get('session')->set('zoneAdmin', true);
        return $this->redirect($this->generateUrl('admin_literie_accueil'),301);
    }

    public function decoadminAction()
    {
        $this->get('session')->remove('zoneAdmin');
        return $this->redirect($this->generateUrl('admin_literie_accueil'),301);
    }

    public function getAdminContentAction($object)
    {
        if ($this->get('security.context')->isGranted('ROLE_USER'))
        {
            if (($repo =self::getRepoAdminContentList($object))!= false)
            {
                $response = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:'.$repo)->findAll(); 
                return new JsonResponse($response);
            }
        }
    }
    public function getAdminContentStructureAction($object)
    {
        if ($this->get('security.context')->isGranted('ROLE_USER'))
        {
            if (($repo =$this->getRepoAdminContentList($object))!= false)
            {
                $response = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:'.$repo)->getHtml(); 
                return new Response($response);
            }
        }
    }

    static function getRepoAdminContentList($object)
    {
        $modifiable = array('marquesAdmin' => 'Marque',
                    'promotionsAdmin' => 'Promotion');
        if (array_key_exists($object, $modifiable))
        {
            return $modifiable[$object];

        }else
        {
            return false;
        }
    }

    public function saveElementAction($input, $textarea, $id, $object)
    {
        if ($this->get('security.context')->isGranted('ROLE_USER'))
        {
            $elem = explode('&',$input);
            $obj = array();
            foreach($elem as $e)
            {
                $tmp = explode('=',$e);
                if (preg_match('/date/',urldecode($tmp[0])) == 1)
                {
                    $date = preg_replace('/\//','-',urldecode($tmp[1]));
                    var_dump($date);
                    $obj['set'.ucfirst($tmp[0])] = new \Datetime($date);
                    
                }else
                {
                    $obj['set'.ucfirst($tmp[0])] = urldecode($tmp[1]);
                }
            }
            $elem = null;
            if ($textarea != null)
            {
                $elem = explode('&', $textarea);
                foreach($elem as $e)
                {
                    $tmp = explode('=', $e);
                    $obj['set'.ucfirst($tmp[0])]= urldecode($tmp[1]);
                }
                $elem = null;
            }
            if (($repo =$this->getRepoAdminContentList($object))!= false)
            {
                $element = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:'.$repo)->find($id); 
                foreach($obj as $key=>$val)
                {
                    $element->$key($val);
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($element);
                $em->flush();
                return new Response();
            }
        }
    }

    public function deleteElementAction($id, $object)
    {
        if ($this->get('security.context')->isGranted('ROLE_USER'))
        {
            if (($repo = self::getRepoAdminContentList($object)) != false)
            {
                $em = $this->getDoctrine()->getManager();
                $element = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:'.$repo)->find($id);
                $em->remove($element);
                $em->flush();
                return new Response();
            }
        }
    }

    public function addElementAction($object)
    {
        if ($this->get('security.context')->isGranted('ROLE_USER'))
        {
            if (($repo = self::getRepoAdminContentList($object)) != false)
            {
                $element = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:'.$repo)->getNew();
                return new JsonResponse($element);
            }
        }
    }
}

<?php

namespace EuroLiterie\structureBundle\Controller;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EuroLiterie\structureBundle\Entity\HoraireRepo;
use EuroLiterie\structureBundle\Entity\KeywordsRepo;
use Yomaah\structureBundle\Entity\MyMail;

class MainController extends Controller
{
    //private $keywords = 'euroliterie, matelats, sommier, vente, literie, lits électriques';

    public function indexAction()
    {
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:index.html.twig');
    }

    public function accueilAction()
    {
        //$articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('accueil',1);
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
        $params = $this->getParams('accueil');
        $params['actuel'] = $actuel;
        $params['avenir'] = $avenir;
        //return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:accueil.html.twig',
            //array('position' => 'Accueil','articles' => $articles,'actuel' => $actuel,'avenir' => $avenir));
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:accueil.html.twig', $params);
    }

    private function getParams($page)
    {
        $params['articles'] = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage($page, 1);
        $keywords = $this->getDoctrine()->getRepository('yomaahBundle:Page')->findKeywords($page, 1);
        $repoKeyword = new KeywordsRepo();
        $Gkeywords = $repoKeyword->getGeneralKeywords();
        if (!$keywords['keywords'])
        {
            $params['keywords'] = $Gkeywords;
        }else
        {
            $params['keywords'] = $Gkeywords.', '.$keywords['keywords']; 
        }
        //$params['position'] = $this->getPosition($page);
        $page = $this->getDoctrine()->getRepository('yomaahBundle:Page')->findBy(array('pageUrl' => $page));
        $params['position'] = $page[0]->getPosition();
        return $params;
    }

    /*
     * Possibilité de mettre sa en base ou yml pour changer dynamiquement
     */
    private function getPosition($page)
    {
        $positions = array('accueil' => 'Accueil',
            'marques' => 'Nos Marques',
            'contact' => 'Nous Trouver',
            'magasin' => 'Notre magasin');
        return $positions[$page];
        
    }

    public function marquesAction()
    {
        //$articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('marques',1);
        $params = $this->getParams('marques');
        $params['marques'] = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:Marque')->findAll();
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:marques.html.twig', $params);
    }

    public function magasinAction()
    {
        $params = $this->getParams('magasin');
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:magasin.html.twig',$params);
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
        $params = $this->getParams('contact');
        $h = new HoraireRepo();
        $params['horaires'] = $h->getHoraires();
        $params['form'] = $form->createView();
        $params['envoie'] = $envoi;
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:contact.html.twig', $params);
        //$h = new HoraireRepo();
        //$horaires = $h->getHoraires();
        //$articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('contact', 1);
        //return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:contact.html.twig', 
            //array('position' => 'Nous trouver', 'horaires' =>$horaires, 'articles' => $articles,'form' => $form->createView(),'envoie' => $envoi));
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
            'promotionsAdmin' => 'Promotion',
            'pagesAdmin' => 'Page');
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
            if (($repo = $this->getRepoAdminContentList($object)) != false)
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

    public function imagesAdminStructureAction()
    {
        return new Response('<section class="logoGalerie">
                    <input type="hidden" value="pngUrl" />
                    <figure class="adminMarqueLogo"><img src="../../bundles/euroliteriestructure/images/marques/pngUrl"></img></figure>
                    <input type="checkbox" name="check" />
                </section>');
        
    }

    public function imagesAdminAction($objet)
    {
        $subject = explode('Admin', $objet);
        $tmp = explode('Controller',__DIR__);
        $rootDir = $tmp[0].'Resources/public/images/'.$subject[0];

        $finder = new Finder();
        $f = $finder->depth('== 0')->files()->notname('/~$/')->in($rootDir);
        if (count($f) > 0)
        {
            $tmp = array();
            foreach ($f as $file)
            {
                $tmp[] = explode ($rootDir.'/', $file);
            }
            foreach ($tmp as $file)
            {
                $files[] = $file[1];
            }
            return new JsonResponse($files);
        }
    }
}

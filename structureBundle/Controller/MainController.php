<?php

namespace EuroLiterie\structureBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EuroLiterie\structureBundle\Entity\HoraireRepo;
use Yomaah\structureBundle\Entity\KeywordsRepo;
use Yomaah\structureBundle\Entity\MyMail;
use Yomaah\structureBundle\Interfaces\AjaxInterface;
use Yomaah\ajaxBundle\Controller\AjaxController;
use Yomaah\ajaxBundle\Classes\ConfBuilder;

class MainController extends Controller implements AjaxInterface
{
    public function indexAction()
    {
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:index.html.twig');
    }

    public function accueilAction()
    {
        $params = $this->getParams('literie_accueil');
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:accueil.html.twig', $params);
    }
    public function getRepo($name)
    {
        $repo = array('horaires' => 'Horaire');
        if (isset($repo[$name]))
        {
            $r = $repo[$name].'Repo';
            return new HoraireRepo();
        }
    }

    public function getAdminParams($page, $em, $dispatcher)
    {
        $params['articles'] = $em->getRepository('yomaahBundle:Article')
                ->findByPage(array('pageUrl' => $page,'idSite' => $dispatcher->getIdSite()));
        $keywords = $em->getRepository('yomaahBundle:Page')->findKeywords($page, $dispatcher->getIdSite());
        $conf = new ConfBuilder($dispatcher);
        $Gkeywords = $conf->getGeneralKeywords();
        if (!$keywords['keywords'])
        {
            $params['keywords'] = $Gkeywords;
        }else
        {
            $params['keywords'] = $Gkeywords.', '.$keywords['keywords']; 
        }
        $p = $em->getRepository('yomaahBundle:Page')->findPageByUrl(array('pageUrl' => $page, 'idSite' => $dispatcher->getIdSite()));
        $params['position'] = $p->getPosition();
        switch($page)
        {
        case 'literie_marques':
            $params['marques'] = $em->getRepository('EuroLiteriestructureBundle:Marque')->findAll();
            break;
        case 'literie_magasin':
            $params['images'] = AjaxController::imageSearch('galerie/magasin/active', 'EuroLiterie/structureBundle');
            break;
        case 'literie_contact':
            $h = new HoraireRepo();
            $params['horaires'] = $h->getHoraires();
            $params['envoie'] = false;
        }
        return $params;
    }

    private function getParams($page)
    {
        $dispatcher = $this->get('bundleDispatcher');
        $params['articles'] = $this->getDoctrine()->getRepository('yomaahBundle:Article')
                ->findByPage(array('pageUrl' => $page,'idSite' => $dispatcher->getIdSite()));
        $keywords = $this->getDoctrine()->getRepository('yomaahBundle:Page')->findKeywords($page, $dispatcher->getIdSite());
        $conf = new ConfBuilder($dispatcher);
        $Gkeywords = $conf->getGeneralKeywords();
        if (!$keywords['keywords'])
        {
            $params['keywords'] = $Gkeywords;
        }else
        {
            $params['keywords'] = $Gkeywords.', '.$keywords['keywords']; 
        }
        $p = $this->getDoctrine()->getRepository('yomaahBundle:Page')->findPageByUrl(array('pageUrl' => $page, 'idSite' => $dispatcher->getIdSite()));
        $params['position'] = $p->getPosition();

        switch($page)
        {
        case 'literie_marques':
            $params['marques'] = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:Marque')->findAll();
            break;
        case 'literie_magasin':
            $params['images'] = AjaxController::imageSearch('galerie/magasin/active', 'EuroLiterie/structureBundle');
            break;
        }
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
        $params = $this->getParams('literie_marques');
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:marques.html.twig', $params);
    }

    public function magasinAction()
    {
        $params = $this->getParams('literie_magasin');
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
        $params = $this->getParams('literie_contact');
        $h = new HoraireRepo();
        $params['horaires'] = $h->getHoraires();
        $params['form'] = $form->createView();
        $params['envoie'] = $envoi;
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:contact.html.twig', $params);
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
        return $this->redirect($this->generateUrl('literie_accueil'),301);
    }

    public function getRepoAdminContentList($object)
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

    public function saveElementAction(Array $param)
    {
        if (($repo = $this->getRepoAdminContentList($param['lien'])) != false)
        {
            $element = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:'.$repo)->find($param['id']); 
            $em = $this->getDoctrine()->getManager();
            if ($param['input'] != false)
            {
                foreach($param['input'] as $key => $input)
                {
                    $element->$key($input);
                }
            }else if ($param['textarea'] != false)
            {
                foreach($param['textarea'] as $key => $input)
                {
                    $element->$key($input);
                }
            }
            $em->persist($element);
            $em->flush();
            return new Response();
        }else if ($param['lien'] == 'sliderAdmin')
        {
            return $this->saveSlider($param['active'], $param['inactive']);
        }
    }

    public function deleteElementAction(Array $param)
    {
        if (($repo = $this->getRepoAdminContentList($param['lien'])) != false)
        {
            $em = $this->getDoctrine()->getManager();
            $element = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:'.$repo)->find($param['id']);
            $em->remove($element);
            $em->flush();
            return new Response();
        }
    }

    public function addElementAction(Array $param)
    {
        if (($repo = $this->getRepoAdminContentList($param['lien'])) != false)
        {
            $element = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:'.$repo)->getNew();
            return new JsonResponse($element);
        }
    }

    private function getDeployedImagesUrl()
    {
        $dispatcher = $this->get('bundleDispatcher');
        if ($dispatcher->getDeployed())
        {
            return '../bundles/euroliteriestructure/images/';
        }else
        {
            return '../../bundles/euroliteriestructure/images/';
        }
    }

    public function logoAdminStructureAction()
    {
        return new Response('<section class="logoGalerie">
                    <input type="hidden" value="pngUrl" />
                    <figure class="adminMarqueLogo"><img src="'.$this->getDeployedImagesUrl().'marques/pngUrl"></img></figure>
                    <input type="checkbox" name="check" />
                </section>');
    }
    public function atteindreAction(Array $param)
    {
        $url = $param['url'];
        if ($param['lien'] == 'marquesAdmin')
        {
            $url .= '/admin_marques';
        }else
        {
            $url .= '/admin_accueil';
        }
        return new Response($url);
    }

    public function getAdminContentStructureAction(Array $param)
    {
        $dispatcher = $this->get('bundleDispatcher');
        if ($dispatcher->isAdmin())
        {
            if (($repo = $this->getRepoAdminContentList($param['lien'])) != false)
            {
                $response = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:'.$repo)->getHtml($this->getDeployedImagesUrl()); 

            }else if ($param['lien'] == 'GkeywordsAdmin')
            {
                $keyRepo = new KeywordsRepo();
                $response = $keyRepo->getHtml();

            }else if ($param['lien'] == 'sliderAdmin')
            {
                $response = $this->get('templating')
                    ->render('EuroLiteriestructureBundle:Ajax:imagesSlider.html.twig',array('url' => $this->getDeployedImagesUrl()));

            }else if ($param['lien'] == 'sliderMiniature')
            {
                $response = '<article class="sliderImage">
                        <input type="hidden" value="" />
                        <figure><img src=""></img></figure>
                        <input type="checkbox" name="check"/>
                    </article>';
            }           
        }else if ($param['lien'] == 'promoInfo')
        {
            $promo = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:Promotion')->find($param['id']);
            $response = '<div><p>'.$promo->getPromoInfo().'</p></div>';
        }
        return new Response($response);
    }

    public function getDialogAction(Array $param)
    {
        if (($repo = $this->getRepoAdminContentList($param['lien'])) != false)
        {
            $filename = $param['dialog'].$repo;
            
        }else if ($param['lien'] == 'sliderAdmin')
        {
            $filename = $param['dialog'].'Slider';
        }
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Dialog:'.$filename.'.html.twig');
    }

    public function getAdminInterfaceAction(Array $param)
    {
        if (($filename = $this->getRepoAdminContentList($param['lien'])) != false)
        {
            return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:AdminMenu:adminInterface'.$filename.'.html.twig');
            
        }else if ($param['lien'] == 'sliderAdmin')
        {
            return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:AdminMenu:adminInterfaceSlider.html.twig');
        }

    }

    public function getAdminContentAction(Array $param)
    {
        if (($repo = $this->getRepoAdminContentList($param['lien'])) != false)
        {
            $response = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:'.$repo)->findAll(); 
            return new JsonResponse($response);
        }else if ($param['lien'] == 'sliderAdmin')
        {
            $slider = array();
            $slider['active'] = AjaxController::imageSearch('slider/active', 'EuroLiterie/structureBundle');
            $slider['inactive'] = AjaxController::imageSearch('slider/inactive', 'EuroLiterie/structureBundle');
            $slider['struct'] = '<article class="sliderImage">
                    <input type="hidden" value="%imgUrl%" />
                    <figure><img src="'.$this->getDeployedImagesUrl().'slider/%dossier%/%imgUrl%"></img></figure>
                    <input type="checkbox" name="check"/>
                </article>';
            return new JsonResponse($slider);

        }

    }

    public function deleteLogoAction($param)
    {
        if ($param['png'] != false)
        {
            if (!(AjaxController::testFileExists('../deleted/marques', $png)))
            {
                AjaxController::moveImage('marques/', '..deleted/marques/', $png);
            }else
            {
                AjaxController::moveImage('marques/', '..deleted/marques/'.time().'_', $png);
            }
            return new Response();
        }
    }

    public function saveSlider($active, $inactive)
    {
        if (is_array($active))
        {
            foreach ($active as $file)
            {
                if (AjaxController::testNameValide($file, 'jpg|png|jpeg'))
                {
                    if (!(AjaxController::testFileExists('./bundles/euroliteriestructure/images/slider/active/', $file))
                        && AjaxController::testFileExists('./bundles/euroliteriestructure/images/slider/inactive/', $file))
                    {
                        AjaxController::moveImage('slider/inactive/', 'slider/active/', $file, 'euroliteriestructure');
                    }
                }
            }
        }else
        {
            AjaxController::moveImage('slider/active/', 'slider/inactive/', '*');
        }
        if (is_array($inactive))
        {
            foreach($inactive as $file)
            {
                if (AjaxController::testNameValide($file, 'png|jpg|jpeg'))
                {
                    if (!(AjaxController::testFileExists('./bundles/euroliteriestructure/images/slider/inactive/', $file))
                        && AjaxController::testFileExists('./bundles/euroliteriestructure/images/slider/active/', $file))
                    {
                        AjaxController::moveImage('slider/active/', 'slider/inactive/', $file, 'euroliteriestructure');

                    }else if (AjaxController::testFileExists('./bundles/euroliteriestructure/images/slider/inactive', $file))
                    {
                        AjaxController::moveImage('slider/active/', 'slider/inactive/', $file, 'euroliteriestructure', time().$file);
                    }
                }
            }
        }
        return new Response();
    }

    public function saveImageAction(Array $param)
    {
        if (($repo = self::getRepoAdminContentList($param['lien'])) != false)
        {
            $marques = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:'.$repo)->find($param['id']);
            if ($param['png'] != false)
            {
                $marques->setPngUrl($param['png']);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($marques);
            $em->flush();
            return new Response();
        }
    }
    public function uploadImageAction(Array $param)
    {
        $file = $param['file'];
        $maxSize = $param['fileInfo']['maxSize'];
        $maxW = $param['fileInfo']['maxW'];
        $colorR = $param['fileInfo']['colorR'];
        $colorG = $param['fileInfo']['colorG'];
        $colorB = $param['fileInfo']['colorB'];
        $maxH = $param['fileInfo']['maxH'];
        $img = array();
        if ($param['lien'] == 'marquesAdmin')
        {
            $img = $this->uploadLogoAction($file, $maxSize, $maxW, $colorR, $colorG, $colorB, $maxH);

        }else if ($param['lien'] == 'sliderAdmin')
        {
            $img = $this->uploadSliderAction($file, $maxSize, $maxW, $colorR, $colorG, $colorB, $maxH);
        }
        if($img['imgUploaded'] === true){
            return new Response ('<img src="../../bundles/euroliteriestructure/images/success.gif" width="16" height="16" border="0" style="marin-bottom: -4px;" /> Success!<br /><img src="'.$img['image'].'" border="0" />');
        }else{
            $response = '<img src="../../bundles/euroliteriestructure/images/error.gif" width="16" height="16px" border="0" style="marin-bottom: -3px;" /> Error(s) Found: ';
            foreach($img['errorList'] as $value){
                    $response .= $value.', ';
            }
            return new Response ($response);
        }
    }

    public function uploadSliderAction($file, $maxSize, $maxW, $colorR, $colorG, $colorB, $maxH)
    {
        $tmp = explode('Controller',__DIR__);
        $folder = $tmp[0].'Resources/public/images/slider/inactive/';
        $filesize_image = $file->getClientSize();
        if($filesize_image > 0){
            $upload_image = AjaxController::uploadImage('euroliteriestructure', $file, $maxSize, $maxW, $folder, $colorR, $colorG, $colorB, $maxH, true);
            if(is_array($upload_image)){
                foreach($upload_image as $key => $value) {
                    if($value == "-ERROR-") {
                        unset($upload_image[$key]);
                    }
                }
                $document = array_values($upload_image);
                for ($x=0; $x<sizeof($document); $x++){
                    $errorList[] = $document[$x];
                }
                $imgUploaded = false;
            }else{
                $imgUploaded = true;
            }
        }else{
            $imgUploaded = false;
            $errorList[] = "File Size Empty";
        }
        if ($imgUploaded)
        {
            return array('imgUploaded' => true, 'image' => $upload_image);
        }else
        {
            return array('imgUploaded' => false, 'errorList' => $errorList);
        }
    }
    public function deleteImageAction(Array $param)
    {
        if ($param['lien'] == 'marquesAdmin')
        {
            $dossier = 'marques/';
            AjaxController::deleteImage($dossier, $dossier, $param['png'], 'euroliteriestructure');
        }else if ($param['lien'] == 'sliderAdmin')
        {
            $dossier = 'slider/';
            $tmp = array();
            foreach ($param['png'] as $png)
            {
                if (AjaxController::testNameValide($png, 'jpg|jpeg|png'))
                {
                    if (AjaxController::testFileExists('./bundles/euroliteriestructure/images/slider/active/', $png))
                    {
                        $dossierFile = $dossier.'active/';

                    }else if (AjaxController::testFileExists('./bundles/euroliteriestructure/images/slider/inactive/', $png))
                    {
                        $dossierFile = $dossier.'inactive/';
                    }
                    AjaxController::deleteImage($dossier, $dossierFile, $png, 'euroliteriestructure');
                }
            }
        }
        return new Response();
    }

    public function uploadLogoAction($file, $maxSize, $maxW, $colorR, $colorG, $colorB, $maxH)
    {
        $tmp = explode('Controller',__DIR__);
        $folder = $tmp[0].'Resources/public/images/marques/';
        $filesize_image = $file->getClientSize();
        if($filesize_image > 0){
            $upload_image = AjaxController::uploadImage('euroliteriestructure', $file, $maxSize, $maxW, $folder, $colorR, $colorG, $colorB, $maxH);
            if(is_array($upload_image)){
                foreach($upload_image as $key => $value) {
                    if($value == "-ERROR-") {
                        unset($upload_image[$key]);
                    }
                }
                $document = array_values($upload_image);
                for ($x=0; $x<sizeof($document); $x++){
                    $errorList[] = $document[$x];
                }
                $imgUploaded = false;
            }else{
                $imgUploaded = true;
            }
        }else{
            $imgUploaded = false;
            $errorList[] = "File Size Empty";
        }
        if ($imgUploaded)
        {
            return array('imgUploaded' => true, 'image' => $upload_image);
        }else
        {
            return array('imgUploaded' => false, 'errorList' => $errorList);
        }
    }
}

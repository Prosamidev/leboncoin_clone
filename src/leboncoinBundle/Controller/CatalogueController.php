<?php

namespace leboncoinBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use leboncoinBundle\Entity\Annonce;
use leboncoinBundle\Form\AnnonceType;
use leboncoinBundle\Form\ImageType;
use leboncoinBundle\Entity\Image;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Session\Session;


class CatalogueController extends Controller
{
    
    public function indexAction()
    {          
        $ad = $this->getDoctrine()->getRepository('leboncoinBundle:Annonce')->findAll();
        
            return $this->render('leboncoinBundle:Default:index.html.twig', array(
                'ad' => $ad
            ));
        
    }
    
     public function showOwnAnnonceAction(){
        
         $id_user = $this->container->get('security.context')->getToken()->getUser()->getId();
         
         $ad = $this->getDoctrine()->getRepository('leboncoinBundle:Annonce')->findBy(array('user' => $id_user));
         
        return $this->render('leboncoinBundle:Default:index.html.twig', array(
            'ad' => $ad,
        ));
         
     }
     
     public function showannonceAction($id){
         
         $ad = $this->getDoctrine()->getRepository('leboncoinBundle:Annonce')->find($id); 
         $m = new Image();  
          $form = $this->createForm(new ImageType(), $m);
          $id_user = $this->container->get('security.context')->getToken()->getUser()->getId();
            echo $id_user;
            if($id_user != null){
            $user = $this->getDoctrine()->getRepository('UserBundle:User')->find($id_user);
            echo $user->getUsername();
            
             return $this->render('leboncoinBundle:Default:show.html.twig', array(
            'ad' => $ad,
            'form' => $form->createView(),
             'user' => $user
            ));
            }else{
                return $this->render('leboncoinBundle:Default:show.html.twig', array(
            'ad' => $ad,
            'form' => $form->createView(),
            ));
            }
    }
    
     public function UploadAction($id) {
            $m = new Image();
            
            $files = $this->getRequest()->files->get('images');
            $ad = $this->getDoctrine()->getRepository('leboncoinBundle:Annonce')->find($id); 
            $file = $files->getClientOriginalName();
            echo 1;
            $m->setFile($files);
            $m->setPath($file);
            $m->setAnnonce($ad);
            $m->upload();
            
            $ad->addImage($m); 
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($m);
            $em->flush();
            echo 2;
            return $this->redirect($this->generateUrl('leboncoin_show_annonce', array('id'=> $id)));
     
    }
     
     public function DelAction(Request $request) {
       
        $id_user = $this->container->get('security.context')->getToken()->getUser()->getId();

         $ad = $this->getDoctrine()->getRepository('leboncoinBundle:Annonce')->findBy(array('user' => $id_user));
               
        return $this->render('leboncoinBundle:Default:delete.html.twig', array(
            'ad' => $ad,            
        ));
    }
    
    public function DelAnnonceAction(Request $request) {
       
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {
                $annonceToDel = $em->getRepository('leboncoinBundle:Annonce')->find($_POST['id']);
                $em->remove($annonceToDel);
                $em->flush();
            }
   
       return $this->redirect($this->generateUrl('leboncoin_del'));
    }
    
    
    public function addAction(){
        $annonce = new Annonce();
               
         $form = $this->createForm(new AnnonceType(), $annonce);
                
        return $this->render('leboncoinBundle:Default:ajout.html.twig', array(
                             'form' => $form->createView()));
    }
    
    public function addAnnonceAction(Request $request) {
         
        $id_user = $this->container->get('security.context')->getToken()->getUser()->getId();
        
        $annonce = new Annonce();
        $image = new Image();
        $request = $this->getRequest();
        $this->image = new Image();
       
        
       
        
        $em = $this->get('doctrine.orm.entity_manager');
        $form = $request->request->get('leboncoinbundle_annoncetype');
        $files = $this->getRequest()->files->get('images');
        
        $user = $em->getRepository('UserBundle:User')->find($id_user);
        $annonce->setTitre($form["titre"]);
        $annonce->setPrix($form["prix"]);
        $annonce->setDescription($form["description"]);
        $annonce->setDate(new \DateTime());
        
        
    $m = new Image();
    
    $path = $this->getRequest()->getBasePath('images');
    $file = $files->getClientOriginalName();
    $m->setFile($files);
    $m->setPath($file);
    $m->setAnnonce($annonce);
    $m->upload();
    $annonce->addImage($m); 
    $annonce->setUser($user);
    $em->persist($annonce);
    $em->persist($m);
    $em->flush();
               
        return $this->redirect($this->generateUrl('leboncoin_show'));
        
    }
}




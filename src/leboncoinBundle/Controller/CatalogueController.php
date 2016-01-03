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
        
            return $this->render('leboncoinBundle:Default:index.html.twig');
        
    }
    
     
}




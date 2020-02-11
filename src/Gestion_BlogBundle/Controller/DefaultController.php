<?php

namespace Gestion_BlogBundle\Controller;

use Gestion_BlogBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $article=$this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();
        return $this->render('@Gestion_Blog/Default/index.html.twig',
            array('article'=>$article));
    }
}

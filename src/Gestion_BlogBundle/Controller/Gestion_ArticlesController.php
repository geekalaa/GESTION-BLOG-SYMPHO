<?php

namespace Gestion_BlogBundle\Controller;

use Gestion_BlogBundle\Entity\Article;
use Gestion_BlogBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
class Gestion_ArticlesController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $article = new Article();
        $Form=$this->createForm(ArticleType::class,$article);
        $Form->handleRequest($request);
        if($Form->isSubmitted() && $Form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $image=$article->getImage();

                $nom_image = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_articles_dossier'),
                    $nom_image);
                
                $article->setImage($nom_image);

            $article->setDate(new \DateTime('now'));
            $em->persist($article);
            $em->flush();
        }
        return $this->render('@Gestion_Blog/Gestion_Articles/ajouter.html.twig',
            array('ajout_Form'=>$Form->createView()));
        ;
    }

    function Affiche_list_articleAction(){
        $article=$this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();
        return $this->render('@Gestion_Blog/Gestion_Articles/gestion_blog.html.twig',
            array('article'=>$article));
    }

}

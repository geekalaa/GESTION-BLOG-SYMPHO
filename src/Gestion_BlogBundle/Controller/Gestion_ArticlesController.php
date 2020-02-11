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

    function UpdateAction($id,Request $request){

        $em=$this->getDoctrine()->getManager();
        $article=$em->getRepository(Article::class)
            ->find($id);
        $last_image_name = $article->getImage();
        $Form=$this->createForm(ArticleType::class,$article);
        $Form->handleRequest($request);
        if($Form->isSubmitted()){
            $image = $article->getImage();
            $imageData = $Form->get('image')->getData();
            if($imageData == null){
                $article->setImage($last_image_name);
                $em=$this->getDoctrine()->getManager();
                $em->flush();
                return $this->redirectToRoute('gestion_blog_homepage_Admin');
            }
                $nom_image = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_articles_dossier'),
                    $nom_image);

                 $article->setImage($nom_image);



            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('gestion_blog_homepage_Admin');

        }
        return $this->render('@Gestion_Blog/Gestion_Articles/modifier.html.twig',
            array('form_edit'=>$Form->createView()));
    }

    function DeleteAction($id){
        $em=$this->getDoctrine()->getManager();
        $article=$em->getRepository(Article::class)
            ->find($id);
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('gestion_blog_homepage_Admin');

    }
    function Single_AfficheAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)
            ->find($id);
        return $this->render('@Gestion_Blog/Gestion_Articles/affichage_single_article.twig',
            array('articlex'=>$article));
    }

}

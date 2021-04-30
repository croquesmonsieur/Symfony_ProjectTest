<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_list", methods={"GET"})
     *
     */
    public function index()
    {
        //return new Response('<html><body>Hello</body></html>');
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render('articles/index.html.twig', array('articles' => $articles));
    }

    /**
     * @Route("/article/new", name="new_article", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {
        $article = new Article();
        $form = $this->createFormBuilder($article)->add('title', TextType::class, array('attr' => array('class' => 'form-control')))->add('content', TextareaType::class, array('required' => false, 'attr' => array('class' => 'form-control')))->add('save', SubmitType::class, array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary mt-3')))->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render('articles/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        return $this->render('articles/show.html.twig', array('article' => $article));
    }

    /**
     * @Route("/article/delete/{id}", name="delete_article", methods={"GET", "DELETE"})
     */
    public function delete(Article $id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();


       return $this->redirectToRoute('article_list');
    }

    /*
        /**
         * @Route("/article/save")
         *
        */
    /*public function save(): Response{
        $entityManager = $this->getDoctrine()->getManager();
        $article = new Article();
        $article->setTitle('Neon Adventures');
        $article->setContent('The focus on sound and the visual tremble');

        $entityManager->persist($article);
        $entityManager->flush();
        return new Response('Saved an article with id '. $article->getId());
    }
*/
}
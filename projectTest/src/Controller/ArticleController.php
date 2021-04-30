<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/article/{id}", name="article_show")
     */
    public function show($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        return $this->render('articles/show.html.twig', array('article' => $article));
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
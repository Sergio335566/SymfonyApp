<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\Type\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function Index(ArticleRepository $articleRepository)
    {   $article = $articleRepository->findBy([], ["id" => "DESC"], 10);
        return $this->render('Main\index.html.twig', [
            'article' => $article,
        ]);
    }
    /**
     * @Route("/create", name="app_article_create")
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $manager =  $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();

            $this->addFlash('success', 'Article Created! Knowledge is power!');
            return new RedirectResponse("/");
        }
        return $this->render('Article\form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{article}/update", name="app_article_update")
     */
    public function update(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Article Modified! Knowledge is power!');
            return new RedirectResponse($this->generateUrl('app_index'));
        }
        return $this->render('Article/edit.html.twig', [
            'form' => $form->createView(),
            'article'=> $article,
        ]);
    }
}
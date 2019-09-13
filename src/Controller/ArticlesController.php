<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\Type\ArticlesType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function Index(ArticlesRepository $articlesRepository)
    {   $articles = $articlesRepository->findBy([], ["id" => "DESC"], 10);
        return $this->render('Main\index.html.twig', [
            'articles' => $articles,
        ]);
    }
    /**
     * @Route("/create", name="app_articles_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticlesType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $article->setAuthor($this->getUser());
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Article Created! Knowledge is power!');
            return new RedirectResponse("/");
        }
        return $this->render('Article\form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{articles}/update", name="app_articles_update")
     * @IsGranted("ROLE_ADMIN")
     */
    public function update(Articles $articles, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($articles->getAuthor() !== $this->getUser()) {
            return new RedirectResponse("/");
    }
        $form = $this->createForm(ArticleTypes::class, $articles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Article Modified! Knowledge is power!');
            return new RedirectResponse($this->generateUrl('app_index'));
        }
        return $this->render('Article/edit.html.twig', [
            'form' => $form->createView(),
            'article'=> $articles,
        ]);
    }
    /**
     * @Route("/{articles}/delete", name="app_articles_delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Articles $articles, Request $request, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($articles);
        $entityManager->flush();
        return new RedirectResponse($this->generateUrl('app_index'));
    }
}
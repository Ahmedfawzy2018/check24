<?php

declare(strict_types=1);

namespace App\Controller\Blog;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'post_index')]
    public function action(PostRepository $repository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);

        return $this->render('index.html.twig', [
            'pagination' => $repository->paginate($page)
        ]);
    }
}

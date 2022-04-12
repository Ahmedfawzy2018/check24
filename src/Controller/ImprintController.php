<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ImprintRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ImprintController extends AbstractController
{
    #[Route('/imprint', name: 'imprint')]
    public function action(ImprintRepository $repository): Response
    {
        return $this->render('index.html.twig', ['pagination' => $repository->paginate(1)]);
    }
}

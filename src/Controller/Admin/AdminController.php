<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/admin', name: 'admin_index')]
final class AdminController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('admin/admin/index.html.twig');
    }
}

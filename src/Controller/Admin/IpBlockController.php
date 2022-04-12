<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\IpBlock;
use App\Form\IpBlockType;
use App\Repository\IpBlockRespository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ip-block')]
final class IpBlockController extends AbstractController
{
    #[Route('/', name: 'admin_ip_block_index', methods: ['GET'])]
    public function index(IpBlockRespository $ipBlockRepository): Response
    {
        return $this->render('admin/ip_block/index.html.twig', [
            'ip_blocks' => $ipBlockRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_ip_block_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $ipBlock = new IpBlock('');
        $form = $this->createForm(IpBlockType::class, $ipBlock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ipBlock);
            $entityManager->flush();

            return $this->redirectToRoute('admin_ip_block_index');
        }

        return $this->render('admin/ip_block/new.html.twig', [
            'ip_block' => $ipBlock,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'admin_ip_block_show', methods: ['GET'])]
    public function show(IpBlock $ipBlock): Response
    {
        return $this->render('admin/ip_block/show.html.twig', [
            'ip_block' => $ipBlock,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_ip_block_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, IpBlock $ipBlock): Response
    {
        $form = $this->createForm(IpBlockType::class, $ipBlock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_ip_block_index');
        }

        return $this->render('admin/ip_block/edit.html.twig', [
            'ip_block' => $ipBlock,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'admin_ip_block_delete', methods: ['DELETE'])]
    public function delete(Request $request, IpBlock $ipBlock): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ipBlock->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ipBlock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_ip_block_index');
    }
}

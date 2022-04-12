<?php

declare(strict_types=1);

namespace App\Controller\Blog;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;

final class CommentController extends AbstractController
{
    #[Route('/post/comment/{id}', name: 'post_comment', methods: ["POST"] )]
    public function action(Post $post, Request $request): Response
    {
        $comment = new Comment();
        $comment->setPost($post);
        $comment->setDate(new DateTimeImmutable());
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_detail', ["slug" => $post->slug()]);
    }
}

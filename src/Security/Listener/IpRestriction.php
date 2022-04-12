<?php

declare(strict_types=1);

namespace App\Security\Listener;

use App\Entity\User;
use App\Repository\IpBlockRespository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class IpRestriction
{
    private TokenStorageInterface $token;
    private IpBlockRespository $repository;

    public function __construct(TokenStorageInterface $token, IpBlockRespository $repository)
    {
        $this->token = $token;
        $this->repository = $repository;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $user = $this->token?->getToken()?->getUser();

        if (!$user instanceof User) {
            return;
        }

        if ($this->repository->exists($event->getRequest()->getClientIp()) === false) {
            return;
        }

        $event->setResponse(new Response('access denied', Response::HTTP_FORBIDDEN));
    }
}

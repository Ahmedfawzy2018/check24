<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\IpBlockRespository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=IpBlockRespository::class)
 */
class IpBlock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @Assert\NotBlank(message="IP address can't be null")
     * @Assert\Ip()
     *
     * @ORM\Column(type="string", length=255)
     */
    private ?string $ip;

    public function __construct(string $ip)
    {
        $this->ip = $ip;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }
}

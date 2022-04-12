<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Vote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Rate::class, inversedBy="votes")
     * @ORM\JoinColumn(nullable=false)
     */
    private Rate $rate;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $value;

    public function __construct(Rate $rate, int $value)
    {
        $value = $value <= 0 ? 1 : $value;
        $value = $value >= 5 ? 5 : $value;

        $this->rate = $rate;
        $this->value = $value;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): Rate
    {
        return $this->rate;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}

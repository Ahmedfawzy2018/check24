<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RateRepository::class)
 */
class Rate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     */
    private float $rating = 0.0;

    /**
     * @ORM\Column(type="integer")
     */
    private int $numberOfVotes = 0;

    /**
     * @ORM\OneToOne(targetEntity=Post::class, inversedBy="rate")
     */
    private ?Post $post;

    /**
     * @ORM\OneToMany(targetEntity=Vote::class, mappedBy="rate", orphanRemoval=true, cascade={"persist"})
     */
    private Collection $votes;

    public function __construct(Post $post)
    {
        $this->post = $post;
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function addVote(int $vote): void
    {
        $this->votes->add(new Vote($this, $vote));
    }

    public function getVotes()
    {
        return $this->votes;
    }

    public function update(float $rating, int $numberOfVotes): void
    {
        $this->rating = $rating;
        $this->numberOfVotes = $numberOfVotes;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function getNumberOfVotes(): int
    {
        return $this->numberOfVotes;
    }
}

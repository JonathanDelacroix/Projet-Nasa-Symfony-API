<?php

namespace App\Entity;

use DateTimeInterface;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:"id", type:"integer")]
    private $id;

    #[ORM\Column(name:"title", type:"string", length: 255, nullable: true)]
    private $title;

    #[ORM\Column(name:"explanation", type:"string", length: 255, nullable: true)]
    private $explanation;

    #[ORM\Column(type: "date", nullable: true)]
    private $date;

    #[ORM\Column(name:"url_image", type:"string", length: 255, nullable: true)]
    private $urlImage;

    #[ORM\Column(name:"media_type", type:"string", length: 255, nullable: true)]
    private $mediaType;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(string $explanation): static
    {
        $this->explanation = $explanation;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of urlImage
     */
    public function getUrlImage(): ?string
    {
        return $this->urlImage;
    }

    /**
     * Set the value of urlImage
     */
    public function setUrlImage($urlImage): static
    {
        $this->urlImage = $urlImage;

        return $this;
    }

    public function getMediaType(): ?string
    {
        return $this->mediaType;
    }

    public function setMediaType(string $mediaType): static
    {
        $this->mediaType = $mediaType;

        return $this;
    }
}

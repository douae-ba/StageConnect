<?php

namespace App\Entity;

use App\Repository\EspacepartageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EspacepartageRepository::class)]
class Espacepartage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $lien = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
#[ORM\JoinColumn(nullable: false)]
private ?User $ajouteePar = null;


#[ORM\ManyToOne(targetEntity: User::class)]
private ?User $destinataire = null;

    #[ORM\Column]
    private ?\DateTime $dateAjout = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): static
    {
        $this->lien = $lien;

        return $this;
    }

    public function getAjouteePar(): ?User
    {
        return $this->ajouteePar;
    }

    public function setAjouteePar(User $ajouteePar): static
    {
        $this->ajouteePar = $ajouteePar;

        return $this;
    }

    public function getDateAjout(): ?\DateTime
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTime $dateAjout): static
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }
    public function getDestinataire(): ?User
{
    return $this->destinataire;
}

public function setDestinataire(?User $user): self
{
    $this->destinataire = $user;
    return $this;
}
}

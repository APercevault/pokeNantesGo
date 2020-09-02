<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $image;

    /**
     * @ORM\Column(type="json")
     */
    private $role = [];

    /**
     * @ORM\ManyToMany(targetEntity=Sortie::class, inversedBy="users")
     */
    private $sortie;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="user")
     */
    private $article;

    public function __construct()
    {
        $this->sortie = new ArrayCollection();
        $this->article = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getRole(): ?array
    {
        return $this->role;
    }

    public function setRole(array $role): self
    {
        $this->role = $role;
        
        return $this;
    }
    public function getRoles()
    {
        return array('ROLE_USER');
    }
    /**
     * @return Collection|sortie[]
     */
    public function getSortie(): Collection
    {
        return $this->sortie;
    }

    public function addSortie(sortie $sortie): self
    {
        if (!$this->sortie->contains($sortie)) {
            $this->sortie[] = $sortie;
        }

        return $this;
    }

    public function removeSortie(sortie $sortie): self
    {
        if ($this->sortie->contains($sortie)) {
            $this->sortie->removeElement($sortie);
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
            $article->setUser($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->contains($article)) {
            $this->article->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getUser() === $this) {
                $article->setUser(null);
            }
        }

        return $this;
    }
    public function eraseCredentials()
    {
    }
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
}

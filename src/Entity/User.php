<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\EntityListeners({"App\EntityListener\UserListener"})
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int  $id = null;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(message="Email is invalid")
     * @Assert\NotBlank(message="Email can't be blank")
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @var string
     * @Assert\NotBlank(message="password can't be blank")
     * @Assert\Length(min="6")
     */
    private ?string $plainPassword = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="nickname can't be blank")
     */
    private string $nickname;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $registedAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $suspendAt = null;

    public function __construct()
    {
        $this->registedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword():string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getRegistedAt(): ?\DateTimeImmutable
    {
        return $this->registedAt;
    }

    public function setRegistedAt(\DateTimeImmutable $registedAt): self
    {
        $this->registedAt = $registedAt;

        return $this;
    }

    public function getSuspendAt(): ?\DateTimeImmutable
    {
        return $this->suspendAt;
    }

    public function setSuspendAt(?\DateTimeImmutable $suspendAt): self
    {
        $this->suspendAt = $suspendAt;

        return $this;
    }

    public function isSuspended(): bool
    {
        return  $this->suspendAt !== null;
    }
}

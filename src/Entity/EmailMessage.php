<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class EmailMessage
{
    /**
     * @Assert\NotBlank
     */
    private $firstName;

    /**
     * @Assert\NotBlank
     */
    private $lastName;

    /**
     * @Assert\Email(message = "L'adresse '{{ value }}' n'est pas valide.")
     */
    private $email;

    /**
     * @Assert\NotBlank
     */
    private $content;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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
    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
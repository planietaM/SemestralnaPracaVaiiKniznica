<?php

namespace App\Models;

use Framework\Core\IIdentity;
use Framework\Core\Model;

class users extends Model implements IIdentity {
    protected ?string $rolaPouzivatela = null;
    protected ?string $meno = null;
    protected ?int $id = null;
    protected ?string $heslo = null;
    protected ?string $email = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRolaPouzivatela(): ?string
    {
        return $this->rolaPouzivatela;
    }

    public function getRola(): ?string
    {
        return $this->rolaPouzivatela;
    }

    public function getMeno(): ?string
    {
        return $this->meno;
    }
    public function getName(): string
    {
        return $this->meno;
    }

    public function getHeslo(): ?string
    {
        return $this->heslo;
    }

    public function setRolaPouzivatela(?string $rolaPouzivatela ): void
    {
        $this->rolaPouzivatela = $rolaPouzivatela;
    }

    public function setMeno(?string $meno): void
    {
        $this->meno = $meno;
    }

    public function setHeslo(?string $heslo): void
    {
        $this->heslo = $heslo;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }



}

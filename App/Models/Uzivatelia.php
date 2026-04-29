<?php

namespace App\Models;
use Framework\Core\Identity;
use Framework\Core\Model;


class Uzivatelia extends Model implements Identity{
    protected ?string $rolaPouzivatela = null;
    protected ?string $meno = null;
    protected ?int $id = null;
    protected ?string $heslo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRolaPouzivatela(): ?string
    {
        return $this->rolaPouzivatela;
    }

    public function getMeno(): ?string
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

    public function setId(?string $id): void
    {
        $this->id = $id;
    }



}

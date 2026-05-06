<?php

namespace App\Models;

use Framework\Core\Model;

class bookcopies extends Model
{
    protected ?int $dostupna = null;
    protected ?int $id = null;
    protected ?int $idOriginalKopie = null;

    public function getDostupna(): ?int
    {
        return $this->dostupna;
    }

    public function getIdDanejKnihy(): ?int
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOriginalKopie(): ?int
    {
        return $this->idOriginalKopie;
    }

    public function setDostupna(?int $dostupna): void
    {
        $this->dostupna = $dostupna;
    }

    public function setIdDanejKnihy(?int $idDanejKnihy): void
    {
        $this->id = $idDanejKnihy;
    }

    public function setIdOriginalKopie(?int $idOriginalKopie): void
    {
        $this->idOriginalKopie = $idOriginalKopie;
    }
}
<?php


namespace App\Models;

use Framework\Core\Model;


class KopieKnizky extends Model
{
    protected ?int $dostupna = null;
    protected ?int $idDanejKnihy = null;
    protected ?int $idOriginalKopie = null;


    public function getDostupna(): ?int
    {
        return $this->dostupna;
    }

    public function getIdDanejKnihy(): ?int
    {
        return $this->idDanejKnihy;
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
        $this->idDanejKnihy = $idDanejKnihy;
    }

    public function setIdOriginalKopie(?int $idOriginalKopie): void
    {
        $this->idOriginalKopie = $idOriginalKopie;
    }
}

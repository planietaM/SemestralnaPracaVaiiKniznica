<?php

namespace App\Models;
use Framework\Core\Model;

class borrowbooks extends Model{
    protected ?int $id = null;
    protected ?int $idUzivatela = null;
    protected ?int $idKnizky = null;
    protected ?int $idOriginaluKnizky = null;
    protected ?string $datumPozicania = null;  // Zmeň z DateTime na string
    protected ?string $datumVratenia = null;
    protected ?int $dostupna = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPozicania(): ?int
    {
        return $this->id;
    }

    public function getIdUzivatela(): ?int
    {
        return $this->idUzivatela;
    }

    public function getIdKnizky(): ?int
    {
        return $this->idKnizky;
    }

    public function getIdOriginaluKnizky(): ?int
    {
        return $this->idOriginaluKnizky;
    }

    public function getDatumPozicania(string $format = 'Y-m-d'): ?string
    {
        return $this->datumPozicania;  // Vrač priamo string
    }

    public function getDatumVratenia(string $format = 'Y-m-d'): ?string
    {
        return $this->datumVratenia;
    }

    public function getDostupna(): ?int
    {
        return $this->dostupna;
    }

    public function setIdPozicania(?int $idPozicania): void
    {
        $this->id = $idPozicania;
    }

    public function setIdUzivatela(?int $idUzivatela): void
    {
        $this->idUzivatela = $idUzivatela;
    }

    public function setIdKnizky(?int $idKnizky): void
    {
        $this->idKnizky = $idKnizky;
    }

    public function setIdOriginaluKnizky(?int $idOriginaluKnizky): void
    {
        $this->idOriginaluKnizky= $idOriginaluKnizky;
    }

    public function setDatumPozicania(?string $datum): void
    {
        $this->datumPozicania = $datum;
    }

    public function setDatumVratenia(?string $datum): void
    {
        $this->datumVratenia = $datum;
    }

    public function setDostupna(?int $dostupna): void
    {
        $this->dostupna = $dostupna;
    }
}
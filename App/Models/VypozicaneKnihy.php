<?php

namespace App\Models;
use Framework\Core\Model;


class VypozicaneKnihy extends Model{
    protected ?int $idPozicania = null;
    protected ?int $idUzivatela = null;
    protected ?int $idKnizky = null;

    protected ?\DateTime $datumPozicania = null;
    protected ?\DateTime $datumVratenia = null;

    protected ?string $statusKnizky = null; // 'aktivna', 'vratena', 'po_termine'


    public function getIdPozicania(): ?int
    {
        return $this->idPozicania;
    }

    public function getIdUzivatela(): ?int
    {
        return $this->idUzivatela;
    }

    public function getIdKnizky(): ?int
    {
        return $this->idKnizky;
    }

    public function getDatumPozicania(string $format = 'Y-m-d'): ?string
    {
        return $this->datumPozicania?->format($format);
    }

    public function getDatumVratenia(string $format = 'Y-m-d'): ?string
    {
        return $this->datumVratenia?->format($format);
    }
    public function getStatusKnizky(): ?string
    {
        return $this->statusKnizky;
    }


    public function setIdPozicania(?int $idPozicania): void
    {
        $this->idPozicania = $idPozicania;
    }

    public function setIdUzivatela(?int $idUzivatela): void
    {
        $this->idUzivatela = $idUzivatela;
    }

    public function setIdKnizky(?int $idKnizky): void
    {
        $this->idKnizky = $idKnizky;
    }

    public function setDatumPozicania(?string $datum): void
    {
        $this->datumPozicania = $datum ? new \DateTime($datum) : null;
    }

    public function setDatumVratenia(?string $datum): void
    {
        $this->datumVratenia = $datum ? new \DateTime($datum) : null;
    }

    public function setStatusKnizky(?string $statusKnizky): void
    {
        $this->statusKnizky = $statusKnizky;
    }


}
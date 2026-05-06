<?php

namespace App\Models;
use Framework\Core\Model;

class books extends Model{
    protected ?string $menoAutora = null;
    protected ?string $nazovKnizky = null;
    protected ?int $id = null;
    protected ?string $fotkaKnizky = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenoAutora(): ?string
    {
        return $this->menoAutora;
    }

    public function getNazovKnizky(): ?string
    {
        return $this->nazovKnizky;
    }

    public function getFotkaKnizky(): ?string
    {
        return $this->fotkaKnizky;
    }

    public function setMenoAutora(?string $menoAutora): void
    {
        $this->menoAutora = $menoAutora;
    }

    public function setNazovKnizky(?string $nazovKnizky): void
    {
        $this->nazovKnizky = $nazovKnizky;
    }

    public function setFotkaKnizky(?string $fotkaKnizky): void
    {
        $this->fotkaKnizky = $fotkaKnizky;
    }

    public function setIdKnizky(?int $idKnizky): void
    {
        $this->id = $idKnizky;
    }
}
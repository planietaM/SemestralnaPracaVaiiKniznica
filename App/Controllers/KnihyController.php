<?php

namespace App\Controllers;

use App\Models\books;
use App\Models\Pouzivatelia;
use App\Models\bookcopies;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\ViewResponse;
use Framework\Core\BaseController;

class KnihyController extends BaseController
{
    public function index(Request $request): Response
    {
        $knihy = books::getAll();
        $pouzivatelia = Pouzivatelia::getAll();
        $kopieKnizky = bookcopies::getAll();

        return $this->html([
            'knihy' => $knihy,
            'pouzivatelia' => $pouzivatelia,
            'kopieKnizky' => $kopieKnizky,
        ],"index");
    }

    public function celkovyPocet(Request $request): Response
    {
        $knihy = books::getAll();
        $kopieKnizky = bookcopies::getAll();

        $celkovyPocet = 0;
        foreach ($knihy as $kniha) {
            foreach ($kopieKnizky as $kopie) {
                if ($kopie->getIdDanejKnihy() === $kniha->getId()) {
                    $celkovyPocet++;
                }
            }
        }
        #return new ViewResponse("knihy/celkovyPocet", [
        ##]);

        return $this->html([
            'celkovyPocet' => $celkovyPocet,
        ], "celkovyPocet");
    }


}
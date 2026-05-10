<?php

namespace App\Controllers;

use App\Models\books;
use App\Models\bookcopies;
use App\Models\users;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\ViewResponse;
use Framework\Core\BaseController;

class KnihyController extends BaseController
{
    public function index(Request $request): Response
    {
        $knihy = books::getAll();

        #return $this->html([
        #    'knihy' => $knihy,
        #    'pouzivatelia' => $pouzivatelia,
        #    'kopieKnizky' => $kopieKnizky,
        #],"index");

        return $this->html([
            'knihy' => $knihy,
        ], "index");
    }

    public function kopieKniziek(Request $request): Response
    {
        $kopieKniziek = bookcopies::getAll();

        return $this->html([
            'kopieKniziek' => $kopieKniziek,
        ], "kopieKniziek");
    }

    public function vymaz(Request $request): Response
    {
        $idKnihy = $_POST['idKnizky'] ?? null;

        $pozicanie = books::getOne($idKnihy);

        if (!is_null($pozicanie)) {
            $pozicanie->delete();
        }

        return $this->redirect($this->url("admin.index"));
    }


    public function pridajKnihu(Request $request): Response
    {
        $message = null;

        if ($request->isPost()) {

            $nazovKnizky = $request->post('nazovKnizky');
            $menoAutora = $request->post('menoAutora');
            $fotkaKnizky = $request->post('fotkaKnizky');
            $pocetKopii = $request->post('pocetKopii');







            if (empty($nazovKnizky) || empty($menoAutora) || empty($fotkaKnizky) || empty($pocetKopii)) {
                $message = "Všetky polia sú povinné!";
            } elseif (strlen($nazovKnizky) < 5) {
                $message = "Je kratky nazov knizky";
            } elseif ($pocetKopii <= 0) {
                $message = "zadal si zly pocet Knihh";
            } else {
                try {
                    // Musí sa volať presne ako class v modeli: users
                    $book = new \App\Models\books();

                    $book->setNazovKnizky($nazovKnizky);
                    $book->setMenoAutora($menoAutora);
                    $book->setFotkaKnizky($fotkaKnizky);
                    $book->save();

                    for($i = 0 ; $i < $pocetKopii ; $i++){
                        $bookcopies = new \App\Models\bookcopies();
                        $bookcopies->setDostupna(1);
                        $bookcopies->setIdOriginalKopie($book->getId());
                        $bookcopies->save();
                    }

                } catch (\Exception $e) {
                    // Ak napr. email už existuje a DB vyhodí chybu
                    $message = "Chyba pri registrácii: " . $e->getMessage();
                }


            }


        }
        return $this->html([
            'message' => $message
        ], 'pridajKnihu');
    }


    public function uprav(Request $request): Response
    {
        $message = null;
        $kniha = null;

        $idKnihy = $_POST['idKnizky'] ?? null;


        if ($idKnihy) {
            $kniha = books::getOne($idKnihy);
        }

        if (!$kniha) {
            return $this->redirect($this->url("admin.index"));
        }

        // Skontroluj či je to POST s formulárom na úpravu (s submit buttonom)
        if ($request->isPost() && $request->post('submit')) {
            $nazovKnizky = $request->post('nazovKnizky') ?: null;
            $menoAutora = $request->post('menoAutora') ?: null;
            $fotkaKnizky = $request->post('fotkaKnizky') ?: null;

            if (empty($nazovKnizky) && empty($menoAutora) && empty($fotkaKnizky)) {
                $message = "Musíš zmeniť aspoň jedno pole!";
            } elseif ($nazovKnizky && strlen($nazovKnizky) < 5) {
                $message = "Je príliš krátky názov knihy";
            } else {
                try {
                    if ($nazovKnizky) {
                        $kniha->setNazovKnizky($nazovKnizky);
                    }
                    if ($menoAutora) {
                        $kniha->setMenoAutora($menoAutora);
                    }
                    if ($fotkaKnizky) {
                        $kniha->setFotkaKnizky($fotkaKnizky);
                    }
                    $kniha->save();

                    return $this->redirect($this->url("admin.index"));
                } catch (\Exception $e) {
                    $message = "Chyba pri úprave: " . $e->getMessage();
                }
            }
        }

        return $this->html([
            'kniha' => $kniha,
            'message' => $message
        ], 'uprav');
    }

}
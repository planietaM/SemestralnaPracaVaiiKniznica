<?php

namespace App\Controllers;

use App\Models\books;
use App\Models\bookcopies;
use App\Models\borrowbooks;
use App\Models\users;
use Framework\Http\Request;
use Framework\Http\Responses\JsonResponse;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\ViewResponse;
use Framework\Core\BaseController;

class KnihyController extends BaseController
{
    public function index(Request $request): Response
    {
        $knihy = books::getAll();
        return $this->html([
            'knihy' => $knihy,
        ], "index");
    }
    public function vyhladavanieKniziek (Request $request): Response
    {
        $knihy = books::getAll();

        #return $this->html([
        #    'knihy' => $knihy,
        #    'pouzivatelia' => $pouzivatelia,
        #    'kopieKnizky' => $kopieKnizky,
        #],"index");

        return $this->html([
            'knihy' => $knihy,
        ], "vyhladavanieKniziek");
    }
    public function search(Request $request): Response
    {
        $textZInputu = trim((string)($request->get('hladanyText') ?? ''));
        $knihy = books::getAll();

        if ($textZInputu !== '') {
            $hladanyText = mb_strtolower($textZInputu);
            $knihy = array_filter($knihy, function ($kniha) use ($hladanyText) {
                return str_contains(mb_strtolower($kniha->getNazovKnizky()), $hladanyText)
                    || str_contains(mb_strtolower($kniha->getMenoAutora()), $hladanyText);
            });
        }

        $data = array_map(function ($kniha) {
            return [
                'id' => $kniha->getId(),
                'nazov' => $kniha->getNazovKnizky(),
                'autor' => $kniha->getMenoAutora(),
                'fotka' => $kniha->getFotkaKnizky(),
            ];
        }, $knihy);

        return new JsonResponse(array_values($data));
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

        $borrowbooks = borrowbooks::getAll();
        $bookcopies = bookcopies::getAll();

        foreach ($borrowbooks as $borrow){
            if($borrow->getIdOriginaluKnizky() == $idKnihy){
                $borrow->delete();
            }
        }

        foreach ($bookcopies as $book){
            if($book->getIdOriginalKopie() == $idKnihy){
                $book->delete();
            }
        }

        if (!is_null($pozicanie)) {
            $staryNazovFotky = $pozicanie->getFotkaKnizky();
            $staraCestaSuboru = __DIR__ . '/../../public/images/'.$staryNazovFotky;
            unlink($staraCestaSuboru);
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
            $pocetKopii = $request->post('pocetKopii');
            $file = $request->file('fotkaKnizky');

            if (!$file || !$file->isOk()) {
                $message = "Chyba pri nahrávaní fotky";
                return $this->html([
                    'message' => $message
                ], 'pridajKnihu');
            }
            $nazovFotky = $file->getName();
            $book = new \App\Models\books();
            $book->save();
            $cestaSuboru = __DIR__ . '/../../public/images/'.$book->getId().$nazovFotky;

            if (empty($nazovKnizky) || empty($menoAutora) || empty($pocetKopii)) {
                $message = "Všetky polia sú povinné!";
                $book->delete();
            } elseif (strlen($nazovKnizky) < 5) {
                $message = "Je kratky nazov knizky";
                $book->delete();
            } elseif ($pocetKopii <= 0) {
                $message = "zadal si zly pocet Knihh";
                $book->delete();
            }elseif (file_exists($cestaSuboru)){
                $message = "Tato fotka sa uz pouziva";
                $book->delete();
            } else {
                try {
                    // Musí sa volať presne ako class v modeli: users
                    $book->setNazovKnizky($nazovKnizky);
                    $book->setMenoAutora($menoAutora);
                    $book->setFotkaKnizky($book->getId().$nazovFotky);
                    $book->save();

                    $file->store($cestaSuboru);

                    for($i = 0 ; $i < $pocetKopii ; $i++){
                        $bookcopies = new \App\Models\bookcopies();
                        $bookcopies->setDostupna(1);
                        $bookcopies->setIdOriginalKopie($book->getId());
                        $bookcopies->save();
                    }

                } catch (\Exception $e) {
                    // Ak napr. email už existuje a DB vyhodí chybu
                    $message = "Chyba pri registrácii: " . $e->getMessage();
                    $book->delete();
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

        // Skontroluj idKnizky z POST alebo parametrov
        $idKnihy = $request->post('idKnizky') ?? null;

        if ($idKnihy) {
            $kniha = books::getOne($idKnihy);
        }

        if (!$kniha) {
            return $this->redirect($this->url("admin.index"));
        }

        // Ak je POST požiadavka a existuje aspoň jedno pole na úpravu
        if ($request->isPost()) {

            $nazovKnizky = trim($request->post('nazovKnizky') ?? '');
            $menoAutora = trim($request->post('menoAutora') ?? '');
            $file = $request->file('fotkaKnizky');

            $nazovFotky = null;
            if ($file && $file->isOk()) {
                $nazovFotky = $file->getName();
                $cestaSuboru = __DIR__ . '/../../public/images/'.$idKnihy.$nazovFotky;
            } elseif ($file) {
                $message = "Chyba pri nahrávaní fotky";
            }


            if (empty($nazovKnizky) && empty($menoAutora) && empty($nazovFotky)) {
                $message = "Musíš zmeniť aspoň jedno pole!";
            } elseif ($nazovKnizky && strlen($nazovKnizky) < 5) {
                $message = "Je príliš krátky názov knihy";
            } elseif (file_exists($cestaSuboru)){
                $message = "Tato fotka sa pouziva";
            }
            if($message == null) {
                try {
                    if (!empty($nazovKnizky)) {
                        $kniha->setNazovKnizky($nazovKnizky);
                    }
                    if (!empty($menoAutora)) {
                        $kniha->setMenoAutora($menoAutora);
                    }
                    if (!empty($nazovFotky)) {
                        $staryNazovFotky = $kniha->getFotkaKnizky();
                        $staraCestaSuboru = __DIR__ . '/../../public/images/'.$staryNazovFotky;

                        unlink($staraCestaSuboru);

                        $file->store($cestaSuboru);
                        $kniha->setFotkaKnizky($idKnihy.$nazovFotky);
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
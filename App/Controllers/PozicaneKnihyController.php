<?php
namespace App\Controllers;
use App\Models\books;
use App\Models\users;
use App\Models\bookcopies;
use App\Models\borrowbooks;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\ViewResponse;
use Framework\Core\BaseController;

class PozicaneKnihyController extends BaseController
{

    public function index(Request $request): Response
    {
        $pozicaneKnihy = borrowbooks::getAll();
        $vsetciPouzivatelia = users::getAll();
        $vsetkyKnihy = books::getAll();
        $vsetkyKopieKnih = bookcopies::getAll();

        return $this->html([
            'pozicaneKnihy' => $pozicaneKnihy,
            'vsetciPouzivatelia' => $vsetciPouzivatelia,
            'vsetkyKnihy' => $vsetkyKnihy,
            'vsetkyKopieKnih' => $vsetkyKopieKnih,
        ], "index");
    }

    public function pozicaj(Request $request): Response
    {
        $idDanejKnihy = $_POST['idDanejKnihy'] ?? null;
        $idOriginalKopie = $_POST['IdOriginalKopie'] ?? null;
        $message = null;
        $existujeUser = false;
        $maUzPozicanuTakutoKnizku = false;
        $vsetciPouzivatelia = \App\Models\users::getAll();
        $vsetkyPozicaneKnizky = \App\Models\borrowbooks::getAll();
        $kopieKniziek = \App\Models\bookcopies::getAll();


        if ($request->isPost()) {
            $idPoziciavatela = $request->post('idPoziciavatela') ?? '';

            foreach ($vsetciPouzivatelia as $existujuciUser) {
                if ($existujuciUser->getId() == $idPoziciavatela) {
                    $existujeUser = true;
                    break;
                }
            }

            if ($existujeUser == false) {
                $message = "Neexistuje uživatel s tímto ID!";
            } else {
                foreach ($vsetkyPozicaneKnizky as $knizka) {
                    if ($knizka->getIdUzivatela() == $idPoziciavatela &&
                        $idOriginalKopie == $knizka->getIdOriginaluKnizky() &&
                        $knizka->getDatumVratenia() == null
                    ) {
                        $maUzPozicanuTakutoKnizku = true;
                        break;
                    }
                }

                if ($maUzPozicanuTakutoKnizku == true) {
                    $message = "Zakaznik uz ma pozicanu tuto knizku!";
                } else {
                    try {
                        $pozicanie = new \App\Models\borrowbooks();
                        $pozicanie->setIdUzivatela($idPoziciavatela);
                        $pozicanie->setIdOriginaluKnizky($idOriginalKopie);
                        $pozicanie->setIdKnizky($idDanejKnihy);
                        $pozicanie->setDatumPozicania(date('Y-m-d'));
                        $pozicanie->setDostupna(0);
                        $pozicanie->save();

                        foreach ($kopieKniziek as $kopia) {
                            if ($kopia->getIdOriginalKopie() == $idOriginalKopie && $kopia->getId() == $idDanejKnihy) {
                                $kopia->setDostupna(0);
                                $kopia->save();
                                break;
                            }
                        }
                        return $this->redirect($this->url("admin.index"));
                    } catch (\Exception $e) {
                        $message = "Chyba při pozicani knihy: " . $e->getMessage();
                    }
                }
            }
        }

        return $this->html([
            'message' => $message
        ], 'pozicaj');
    }

    /**
     * @throws \Exception
     */
    public function vratit(Request $request): Response
    {
        $idPozicania = $_POST['idPozicania'] ?? null;
        $vsetkyPozicaneKnizky = \App\Models\borrowbooks::getAll();
        $kopieKniziek = \App\Models\bookcopies::getAll();

        if ($request->isPost()) {


            foreach ($vsetkyPozicaneKnizky as $knizka) {
                if ($knizka->getId() == $idPozicania) {

                    foreach ($kopieKniziek as $kopia) {
                        if ($kopia->getIdOriginalKopie() == $knizka->getIdOriginaluKnizky() && $kopia->getId() == $knizka->getIdKnizky()) {
                            $kopia->setDostupna(1);
                            $kopia->save();
                            break;
                        }
                    }

                    $knizka->setDatumVratenia(date('Y-m-d'));
                    $knizka->setDostupna(1);
                    $knizka->save();
                    break;
                }
            }


        }
        return $this->redirect($this->url("admin.index"));
    }

    public function vymaz(Request $request): Response
    {
        $idPozicania = $_POST['idPozicania'] ?? null;
        $pozicanie = \App\Models\borrowbooks::getOne($idPozicania);

        if (!is_null($pozicanie)) {
            $pozicanie->delete();
        }

        return $this->redirect($this->url("admin.index"));


    }

}
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
        $jeToAdmin = false;
        $maUzPozicanuTakutoKnizku = false;
        $vsetciPouzivatelia = \App\Models\users::getAll();
        $vsetkyPozicaneKnizky = \App\Models\borrowbooks::getAll();
        $kopieKniziek = \App\Models\bookcopies::getAll();


        if ($request->isPost()) {
            $idPoziciavatela = $request->post('idPoziciavatela') ?? '';

            foreach ($vsetciPouzivatelia as $existujuciUser) {
                if ($existujuciUser->getId() == $idPoziciavatela) {
                    $existujeUser = true;
                    if($existujuciUser->getRola() == 'admin') {
                        $jeToAdmin = true;
                    }
                    break;
                }

            }

            if ($existujeUser == false) {
                $message = "Neexistuje uživatel s tímto ID!";
            } elseif($jeToAdmin == true) {
                $message = "Admin si nemoze pozicat Knihu";
            }else {
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
            'message' => $message,
            'users' => $vsetciPouzivatelia
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

    public function uprav(Request $request): Response
    {

        $users = users::getAll();
        $borrowbooks = borrowbooks::getAll();
        $books = books::getAll();
        $bookcopies = bookcopies::getAll();

        if ($request->isPost() == false) {
            return $this->redirect($this->url("admin.index"));
        }


        $idPozicania = $request->post('idPozicania') ?? null;
        $idUzivatela = $request->post('idUzivatela') ?: null;
        $dostupna = $request->post('dostupna') ?: null;
        $datumVratenia = $request->post('datumVratenia') ?: null;
        $datumPozicania = $request->post('datumPozicania') ?: null;
        $idKnizky = $request->post('idKnizky') ?: null;
        $idOriginaluKnizky = $request->post('idOriginaluKnizky') ?: null;

        $message = null;

        $pozicanaKnizka = borrowbooks::getOne($idPozicania);

        if ($request->post('submit') !== null) {


            if ($idUzivatela!= null) {
                $existujeUser = false;
                foreach ($users as $user) {
                    if($user->getId() == $idUzivatela) {
                        $existujeUser = true;
                        if($user->getRola() == 'admin') {
                            $message = "Admin si nemoze pozicat Knihu";
                        }
                        break;
                    }
                }
                if ($existujeUser == false) {
                    $message = "Toto id neexistuje";
                }
                $pozicanaKnizka->setIdUzivatela($idUzivatela);
            }

            if ($dostupna !== null) {
                if($dostupna == 0){
                    $message = "Knizku nieje mozne pozicat pretoze neviem komu";
                }elseif($dostupna != 1){
                    $message = "Neplatna hodnota pro dostupna. Použijte 0 nebo 1.";
                }else if($pozicanaKnizka->getDostupna() == $dostupna) {
                    $message = "Zadavas to istu dostupnost, ktora ma tato pozicanie";
                }else{
                    foreach ($bookcopies as $book) {
                        if($book->getId() == $pozicanaKnizka->getIdKnizky() && $book->getIdOriginalKopie() == $pozicanaKnizka->getIdOriginaluKnizky()){
                            $book->setDostupna($dostupna);
                            $book->save();
                            break;
                        }
                    }
                    $pozicanaKnizka->setDostupna($dostupna);
                    $pozicanaKnizka->setDatumVratenia(date('Y-m-d'));
                }

            }


            if ($datumVratenia!= null) {

                if($pozicanaKnizka->getDatumPozicania() > $datumVratenia  && $pozicanaKnizka->getDatumVratenia() != null) {
                    $message = "Chces vratit knizku skorej nez bola pozicana";
                }else {
                    $pozicanaKnizka->setDatumVratenia($datumVratenia);
                }
            }

             if ($datumPozicania!= null) {
                 if($pozicanaKnizka->getDatumVratenia() != null) {
                    if($pozicanaKnizka->getDatumVratenia() < $datumPozicania) {
                        $message = "Chces pozicat knizku neskor nez bola vratena";
                    }else{
                    $pozicanaKnizka->setDatumPozicania($datumPozicania);
                    }
                 } else{
                        $pozicanaKnizka->setDatumPozicania($datumPozicania);
                }
            }



            if($idKnizky != null) {

                $existujeKniha = false;

                foreach ($bookcopies as $book) {
                    if($book->getId() == $idKnizky){
                        $existujeKniha = true;
                        $dostupnaKNiha = $book->getDostupna();
                         if($dostupnaKNiha == 0){
                            $message = "Tato knizka neni dostupna";
                        }
                        break;
                    }
                }
                if ($existujeKniha == false) {
                    $message = "Toto id knizky neexistuje";
                }
                $pozicanaKnizka->setIdKnizky($idKnizky);
            }

             if ($idOriginaluKnizky != null) {
                $existujeKniha = false;
                $maDanyKus = false;
                foreach ($books as $book) {
                    if($book->getId() == $idOriginaluKnizky){
                        $existujeKniha = true;
                        foreach ($bookcopies as $bookCopie) {
                            if($bookCopie->getId() == $pozicanaKnizka->getIdKnizky() &&
                                $idOriginaluKnizky ==  $bookCopie->getIdOriginalKopie()){
                                $maDanyKus = true;
                                break;
                            }
                        }
                        break;
                    }
                }
                if ($existujeKniha == false) {
                    $message = "Toto id originalu knizky neexistuje";
                }elseif($maDanyKus == false) {
                    $message = "Tato knizka nema k tomuto originalu dany kus";
                }
                $pozicanaKnizka->setIdOriginaluKnizky($idOriginaluKnizky);
            }

            try {
                if($message == null) {
                    $pozicanaKnizka->save();

                    return $this->redirect($this->url("admin.index"));
                }
            } catch (\Exception $e) {
                $message = "Chyba pri úprave požičania: " . $e->getMessage();
            }
        }

        // Vráť view s objektom požičania
        return $this->html([
            'pozicanaKnizka' => $pozicanaKnizka,
            'message' => $message
        ], 'uprav');
    }





}
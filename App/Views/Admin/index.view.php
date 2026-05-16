<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\View $view */
/** @var array $books */
/** @var array $borrowbooks */
/** @var array $users */
/** @var array $bookcopies */
?>

<div class="container-fluid px-5 py-1">
    <div class="container-fluid">

        <div class="text-center nadpisovy-fond">
            <h1><strong>Welcom Admin</strong></h1>
        </div>

        <div class="text-center nadpisovy-fond">
            <h2>Knihy</h2>
        </div>

         <div class = "p-3">
            <button type="button"
                    onclick="window.location.href='<?= $link->url("knihy.pridajKnihu") ?>'"
                    class="btn btn-primary tlacidlo-prekliknutie">Pridaj knihu
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover" border="2">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Názov</th>
                    <th>Autor</th>
                    <th>Odstranit</th>
                    <th>Upravit</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= $book->getId() ?></td>
                        <td><?= $book->getNazovKnizky() ?></td>
                        <td><?= $book->getMenoAutora() ?></td>
                        <td>
                            <form method="POST" action="<?= $link->url("knihy.vymaz") ?>">
                                <input type="hidden" name="idKnizky" value="<?= $book->getId() ?>">
                                <button type="submit" class="btn btn-danger tlacidlo-vymazania" onclick="return confirm('Naozaj chces vymazat tuto knihu')" >Vymazať</button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="<?= $link->url("knihy.uprav") ?>">
                                <input type="hidden" name="idKnizky" value="<?= $book->getId() ?>">
                                <button type="submit" class="btn btn-danger tlacidlo-uprav">Uprav</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <div class="text-center nadpisovy-fond">
            <h2>Používatelia</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover" border="2">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Meno</th>
                    <th>Email</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->getId() ?></td>
                        <td><?= $user->getMeno() ?></td>
                        <td><?= $user->getEmail() ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <div class="text-center nadpisovy-fond">
            <h2>Požičané knihy</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover" border="2">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Užívateľa</th>
                    <th>Nazov knizky</th>
                    <th>Meno autora</th>
                    <th>Dátum požičania</th>
                    <th>Vratit</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($borrowbooks as $borrow): ?>
                    <?php
                    if ($borrow->getDatumVratenia() != null) {
                        continue;
                    }
                    $nazov = "";
                    $autor = "";
                    foreach ($books as $book) {
                        if ($book->getId() == $borrow->getIdOriginaluKnizky()) {
                            $nazov = $book->getNazovKnizky();
                            $autor = $book->getMenoAutora();
                            break;
                        }
                    }
                    ?>
                    <tr>
                        <td><?= $borrow->getId() ?></td>
                        <td><?= $borrow->getIdUzivatela() ?></td>
                        <td><?= $nazov ?></td>
                        <td><?= $autor ?></td>
                        <td><?= $borrow->getDatumPozicania() ?></td>
                        <td>
                            <form method="POST" action="<?= $link->url("pozicaneKnihy.vratit") ?>" style="display:inline;">
                                <input type="hidden" name="idPozicania" value="<?= $borrow->getId() ?>">
                                <button type="submit" class="btn btn-primary tlacidlo-potvrdenia ">Vrátiť</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <div class="text-center nadpisovy-fond">
            <h2>Knihy vhodné na požičanie</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover" border="2">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nazov knizky</th>
                    <th>Meno autora</th>
                    <th>Dostupná</th>
                    <th>Tlacidlo</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bookcopies as $copy): ?>
                    <?php
                    if ($copy->getDostupna() == 0) {
                        continue;
                    }
                    $nazov = "";
                    $autor = "";
                    foreach ($books as $book) {
                        if ($book->getId() == $copy->getIdOriginalKopie()) {
                            $nazov = $book->getNazovKnizky();
                            $autor = $book->getMenoAutora();
                            break;
                        }
                    }
                    ?>
                    <tr>
                        <td><?= $copy->getId() ?></td>
                        <td><?= $nazov ?></td>
                        <td><?= $autor ?></td>
                        <td><?= $copy->getDostupna() ?></td>
                        <td>
                            <form method="POST" action="<?= $link->url("pozicaneKnihy.pozicaj") ?>">
                                <input type="hidden" name="idDanejKnihy" value="<?= $copy->getIdDanejKnihy() ?>">
                                <input type="hidden" name="IdOriginalKopie" value="<?= $copy->getIdOriginalKopie() ?>">
                                <button type="submit" class="btn btn-primary tlacidlo-prekliknutie">Požičaj</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <div class="text-center nadpisovy-fond">
            <h2>Požičané knihy</h2>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover" border="2">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Užívateľa</th>
                    <th>Nazov knizky</th>
                    <th>Meno autora</th>
                    <th>Dátum požičania</th>
                    <th>Dátum vratenia</th>
                    <th>Dostupna</th>
                    <th>Odstranit</th>
                    <th>Upravit</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($borrowbooks as $borrow): ?>
                    <?php
                    $nazov = "";
                    $autor = "";
                    foreach ($books as $book) {
                        if ($book->getId() == $borrow->getIdOriginaluKnizky()) {
                            $nazov = $book->getNazovKnizky();
                            $autor = $book->getMenoAutora();
                            break;
                        }
                    }
                    ?>
                    <tr>
                        <td><?= $borrow->getId() ?></td>
                        <td><?= $borrow->getIdUzivatela() ?></td>
                        <td><?= $nazov ?></td>
                        <td><?= $autor ?></td>
                        <td><?= $borrow->getDatumPozicania() ?></td>
                        <td><?= $borrow->getDatumVratenia() ?></td>
                        <td><?= $borrow->getDostupna() ?></td>
                        <td>
                            <form method="POST" action="<?= $link->url("pozicaneKnihy.vymaz") ?>">
                                <input type="hidden" name="idPozicania" value="<?= $borrow->getId() ?>">
                                <button type="submit" class="btn btn-danger tlacidlo-vymazania" onclick="return confirm('Naozaj chces vymazat tuto knihu')">Vymazať</button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="<?= $link->url("pozicaneKnihy.uprav") ?>">
                                <input type="hidden" name="idPozicania" value="<?= $borrow->getId() ?>">
                                <button type="submit" class="btn btn-danger tlacidlo-uprav">Uprav</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
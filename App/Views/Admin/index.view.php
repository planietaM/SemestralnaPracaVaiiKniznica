<?php

/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\View $view */


?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div>
                Welcome, <strong><?= $user->getName() ?></strong>!<br><br>
                This part of the application is accessible only after logging in.
            </div>
        </div>
    </div>
</div>

<?php
/** @var array $books */
/** @var array $borrowbooks */
/** @var array $users */
/** @var array $bookcopies */
?>

<h1>Admin</h1>

<h2>Knihy</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Názov</th>
        <th>Autor</th>
    </tr>
    <?php foreach ($books as $book): ?>
        <tr>
            <td><?= $book->getId() ?></td>
            <td><?= $book->getNazovKnizky() ?></td>
            <td><?= $book->getMenoAutora() ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Používatelia</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Meno</th>
        <th>Email</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user->getId() ?></td>
            <td><?= $user->getMeno() ?></td>
            <td><?= $user->getEmail() ?></td>
        </tr>
    <?php endforeach; ?>
</table>





<h2>Požičané knihy</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>ID Užívateľa</th>
        <th>Nazov knizky</th>
        <th>Meno autora</th>
        <th>Dátum požičania</th>
        <th>Vratit</th>
    </tr>
    <?php foreach ($borrowbooks as $borrow): ?>
        <?php
        if ($borrow->getDatumVratenia() != null) {
            continue;
        }

        $nazov = "";
        $autor= "";
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
            <td><?= $autor?></td>
            <td><?= $borrow->getDatumPozicania() ?></td>
            <td>
                <form method="POST"
                      action="<?= $link->url("pozicaneKnihy.vratit") ?>"
                      style="display:inline;">
                    <input type="hidden" name="idPozicania" value="<?= $borrow->getId() ?>">
                    <button type="submit" class="btn btn-primary">Vrátiť</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>











<h2>Knihy vhodné na požičanie</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nazov knizky</th>
        <th>Meno autora</th>
        <th>Dostupná</th>
        <th>Tlacidlo</th>
    </tr>
    <?php foreach ($bookcopies as $copy): ?>
        <?php
        if ($copy->getDostupna() == 0) {
            continue;
        }
        $nazov = "";
        $autor= "";
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
            <td><?= $autor?></td>
            <td><?= $copy->getDostupna() ?></td>
            <td>
                <form method="POST"
                      action="<?= $link->url("pozicaneKnihy.pozicaj") ?>">
                    <input type="hidden" name="idDanejKnihy" value="<?= $copy->getIdDanejKnihy() ?>">
                    <input type="hidden" name="IdOriginalKopie" value="<?= $copy->getIdOriginalKopie() ?>">
                    <button type="submit" class="btn btn-primary">Požičaj</button>
                </form>
            </td>
            <td>
                <form method="POST"
                      action="<?= $link->url("pozicaneKnihy.vymaz") ?>">
                    <input type="hidden" name="idDanejKnihy" value="<?= $copy->getIdDanejKnihy() ?>">
                    <input type="hidden" name="IdOriginalKopie" value="<?= $copy->getIdOriginalKopie() ?>">
                    <button type="submit" class="btn btn-primary">Vymaz</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>



<h2>Záznam požičania</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Názov knižky</th>
        <th>Meno autora</th>
        <th>ID Užívateľa</th>
        <th>Dátum požičania</th>
        <th>Vrátiť</th>
        <th>Vymazať</th>
    </tr>
    <?php foreach ($borrowbooks as $borrow): ?>
        <?php
        $nazov = "";
        $autor = "";
        foreach ($bookcopies as $book) {
            if ($book->getId() == $borrow->getIdOriginaluKnizky()) {
                $nazov = $book->getNazovKnizky();
                $autor = $book->getMenoAutora();
                break;
            }
        }
        ?>
        <tr>
            <td><?= $borrow->getId() ?></td>
            <td><?= $nazov ?></td>
            <td><?= $autor ?></td>
            <td><?= $borrow->getIdUzivatela() ?></td>
            <td><?= $borrow->getDatumPozicania() ?></td>
            <td>
                <form method="POST" action="<?= $link->url("pozicaneKnihy.vymaz") ?>" style="display:inline;">
                    <input type="hidden" name="idPozicania" value="<?= $borrow->getId() ?>">
                    <button type="submit" class="btn btn-danger">Vymazať</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
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
            <h1><strong>Vytaj <?= $user->getName()?></strong></h1>
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
                </tr>
                </thead>
                <tbody>
                <?php foreach ($borrowbooks as $borrow): ?>
                    <?php
                    if ($borrow->getDatumVratenia() != null) {
                        continue;
                    }
                    if($borrow->getIdUzivatela() != $user->getId()){
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
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>


        <div class="text-center nadpisovy-fond">
            <h2>Upomienkove knihy</h2>
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
                </tr>
                </thead>
                <tbody>
                <?php foreach ($borrowbooks as $borrow): ?>
                    <?php
                    if ($borrow->getDatumVratenia() != null) {
                        continue;
                    }

                    $limitDatum = new DateTime();
                    $limitDatum->modify('-2 months');

                    $datumPozicaniaDT = new DateTime($borrow->getDatumPozicania());

                    if ($datumPozicaniaDT > $limitDatum) {
                        continue;
                    }

                    if($borrow->getIdUzivatela() != $user->getId()){
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
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
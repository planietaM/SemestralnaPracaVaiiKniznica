<?php
/** @var array $books */
/** @var array $borrowbooks */
/** @var array $users */
/** @var array $bookcopies */
?>

    <h1>Blbyyyy userikkkkkk</h1>

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
            <th>ID Knihy</th>
            <th>Dátum požičania</th>
        </tr>
        <?php foreach ($borrowbooks as $borrow): ?>
            <tr>
                <td><?= $borrow->getId() ?></td>
                <td><?= $borrow->getIdUzivatela() ?></td>
                <td><?= $borrow->getIdKnizky() ?></td>
                <td><?= $borrow->getDatumPozicania() ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Kópie kníh</h2>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>ID Originálu</th>
        <th>Dostupná</th>
    </tr>
<?php foreach ($bookcopies as $copy): ?>
    <tr>
        <td><?= $copy->getId() ?></td>
        <td><?= $copy->getIdOriginalKopie() ?></td>
        <td><?= $copy->getDostupna() ?></td>
    </tr>
<?php endforeach; ?>
    </table><?php

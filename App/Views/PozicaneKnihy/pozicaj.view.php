<?php

/** @var string|null $message */
/** @var \App\Core\LinkGenerator $link */
/** @var array $users */
?>

<h2>Požičaj si knihu</h2>

<?php if ($message): ?>
    <div class="alert alert-danger"><?= $message ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">

        <form method="POST" action="<?= $link->url("pozicaneKnihy.pozicaj") ?>">
            <input type="hidden" name="idDanejKnihy" value="<?= htmlspecialchars($_POST['idDanejKnihy'] ?? '') ?>">
            <input type="hidden" name="IdOriginalKopie" value="<?= htmlspecialchars($_POST['IdOriginalKopie'] ?? '') ?>">
            <h1 class="p-3">Vyber si pouzivatela ktory si chce pozicat knihu</h1>
            <select name="idPoziciavatela" id="idPoziciavatela">
                <?php
                foreach ($users as $user) {
                    if ($user->getName() == "admin") {
                        continue;
                    } else {
                        echo '<option value="' .$user->getId() . '">' .$user->getName() . '</option>';
                    }
                }
                ?>
            </select>
            <button type="submit" class="btn btn-success">Požičaj knihu</button>
            <a href="<?= $link->url("admin.index") ?>" class="btn btn-secondary">Zrušiť</a>
        </form>
    </div>
</div>
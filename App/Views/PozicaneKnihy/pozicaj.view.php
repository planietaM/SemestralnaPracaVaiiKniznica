<?php

/** @var string|null $message */
/** @var \App\Core\LinkGenerator $link */
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

            <div class="form-group">
                <label for="idPoziciavatela"><strong>Zadaj ID používateľa:</strong></label>
                <input type="text"
                       id="idPoziciavatela"
                       name="idPoziciavatela"
                       class="form-control"
                       placeholder="Napíš ID používateľa"
                       required>
            </div>

            <button type="submit" class="btn btn-success">Požičaj knihu</button>
            <a href="<?= $link->url("admin.index") ?>" class="btn btn-secondary">Zrušiť</a>
        </form>
    </div>
</div>
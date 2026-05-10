<?php

/** @var string|null $message */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */
/** @var \App\Models\borrowbooks $pozicanaKnizka */

// Extrahovanie všetkých údajov
$idPozicaniaPozicanejKnizky = $pozicanaKnizka->getId();
$idUzivatelaPozicaniaKnizky = $pozicanaKnizka->getidUzivatela();
$idKnizkyPozicaniaKnizky = $pozicanaKnizka->getidKnizky();
$idOriginaluKnizkyPozicaniaKnizky = $pozicanaKnizka->getidOriginaluKnizky();
$datumPozicaniaPozicaniaKnizky = $pozicanaKnizka->getdatumPozicania();
$datumVrateniaPozicaniaKnizky = $pozicanaKnizka->getdatumVratenia();
$dostupnaVrateniaPozicaniaKnizky = $pozicanaKnizka->getDostupna();

?>

<h2>Uprav danú knižku</h2>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Uprav danú knižku</h5>

                    <?php if ($message): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>

                    <form class="form-signin" method="post" action="<?= $link->url("uprav") ?>">

                        <!-- Hidden field aby sme poslali ID späť -->
                        <input type="hidden" name="idPozicania" value="<?= htmlspecialchars($idPozicaniaPozicanejKnizky) ?>">
                        <input type="hidden" name="idUzivatela_original" value="<?= htmlspecialchars($idUzivatelaPozicaniaKnizky ?? '') ?>">
                        <input type="hidden" name="idKnizky_original" value="<?= htmlspecialchars($idKnizkyPozicaniaKnizky ?? '') ?>">
                        <input type="hidden" name="idOriginaluKnizky_original" value="<?= htmlspecialchars($idOriginaluKnizkyPozicaniaKnizky ?? '') ?>">
                        <input type="hidden" name="datumPozicania_original" value="<?= htmlspecialchars($datumPozicaniaPozicaniaKnizky ?? '') ?>">
                        <input type="hidden" name="datumVratenia_original" value="<?= htmlspecialchars($datumVrateniaPozicaniaKnizky ?? '') ?>">
                        <input type="hidden" name="dostupna_original" value="<?= htmlspecialchars($dostupnaVrateniaPozicaniaKnizky ?? '') ?>">


                        <div class="form-label-group mb-3">
                            <label for="idUzivatela" class="form-label">ID Užívateľa</label>
                            <input name="idUzivatela" type="number" id="idUzivatela" class="form-control"
                                   placeholder="<?= $idUzivatelaPozicaniaKnizky ?>">
                        </div>

                        <div class="form-label-group mb-3">
                            <label for="idKnizky" class="form-label">ID Knihy</label>
                            <input name="idKnizky" type="number" id="idKnizky" class="form-control"
                                   placeholder="<?= $idKnizkyPozicaniaKnizky ?>">
                        </div>

                        <div class="form-label-group mb-3">
                            <label for="idOriginaluKnizky" class="form-label">ID Originálu Knihy</label>
                            <input name="idOriginaluKnizky" type="number" id="idOriginaluKnizky" class="form-control"
                                   placeholder="<?= $idOriginaluKnizkyPozicaniaKnizky ?>">
                        </div>

                        <div class="form-label-group mb-3">
                            <label for="datumPozicania" class="form-label">Dátum Požičania</label>
                            <input name="datumPozicania" type="date" id="datumPozicania" class="form-control">
                        </div>

                        <div class="form-label-group mb-3">
                            <label for="datumVratenia" class="form-label">Dátum Vrátenia</label>
                            <input name="datumVratenia" type="date" id="datumVratenia" class="form-control">
                        </div>

                        <div class="form-label-group mb-3">
                            <label for="dostupna" class="form-label">Dostupná</label>
                            <input name="dostupna" type="number" id="dostupna" min="0" max="1" class="form-control">
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary" type="submit" name="submit">Upraviť údaje</button>
                            <button type="button"
                                    onclick="window.location.href='<?= $link->url("admin.index") ?>'"
                                    class="btn btn-primary">Zrušiť úpravy</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
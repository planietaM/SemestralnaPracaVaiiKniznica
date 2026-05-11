<?php

/** @var string|null $message */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \App\Models\books $kniha */

?>

<h2>Uprav knihu</h2>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body ">
                    <h5 class="card-title text-center">Uprav knihu</h5>

                    <?php if ($message): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>

                    <form class="form-signin" method="post" action="<?= $link->url("knihy.uprav") ?>">

                        <input type="hidden" name="idKnizky" value="<?= htmlspecialchars($kniha->getId()) ?>">

                        <div class="form-label-group mb-3">
                            <label for="nazovKnizky" class="form-label">Názov</label>
                            <input name="nazovKnizky" type="text" id="nazovKnizky" class="form-control"
                                   value="<?= htmlspecialchars($kniha->getNazovKnizky()) ?>">
                        </div>

                        <div class="form-label-group mb-3 ">
                            <label for="menoAutora" class="form-label">Autor</label>
                            <input name="menoAutora" type="text" id="menoAutora" class="form-control "
                                   value="<?= htmlspecialchars($kniha->getMenoAutora()) ?>">
                        </div>

                        <div class="form-label-group mb-3">
                            <label for="fotkaKnizky" class="form-label">URL Fotky</label>
                            <input name="fotkaKnizky" type="text" id="fotkaKnizky" class="form-control"
                                   value="<?= htmlspecialchars($kniha->getFotkaKnizky()) ?>">
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary" type="submit" name="submit">Upraviť</button>
                            <button type="button"
                                    onclick="window.location.href='<?= $link->url("admin.index") ?>'"
                                    class="btn btn-primary">Zrušiť</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
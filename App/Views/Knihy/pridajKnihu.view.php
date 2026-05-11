<?php

/** @var string|null $message */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */


?>

<div class="col-sm-9 col-md-7 col-lg-5 mx-auto ">
    <div class="card card-signin my-5 hnedy-pozadie">
        <div class="card-body">
            <h5 class="card-title text-center">PridajKnizku</h5>
            <div class="text-center text-danger mb-3">
                <?= @$message ?>
            </div>


            <form class="form-signin" method="post" action="<?= $link->url("pridajKnihu") ?>">


                <div class="form-label-group mb-3">
                    <label for="nazovKnizky" class="form-label">Nazov Knihy</label>
                    <input name="nazovKnizky" type="text" id="nazovKnizky" class="form-control"
                           placeholder="nazovKnizky" required>
                </div>

                <div class="form-label-group mb-3">
                    <label for="menoAutora" class="form-label">Meno Autora</label>

                    <input name="menoAutora" type="text" id="menoAutora" class="form-control"
                           placeholder="menoAutora" required >
                </div>


                <div class="form-label-group mb-3">
                    <label for="fotkaKnizky" class="form-label">Fotka</label>
                    <input name="fotkaKnizky" type="text" id="fotkaKnizky" class="form-control"
                           placeholder="fotkaKnizky" required>
                </div>

                <div class="form-label-group mb-3">
                    <label for="pocetKopii" class="form-label">Pocet kopii</label>
                    <input name="pocetKopii" type="number" id="pocetKopii" class="form-control"
                           placeholder="pocetKopii" required>
                </div>


                <div class="text-center">
                    <button class="btn btn-primary tlacidlo-potvrdenia" type="submit" name="submit">Pridaj Knizku
                    </button>
                    <button type="button "
                            onclick="window.location.href='<?= $link->url("home.index") ?>'"
                            class="btn btn-primary  tlacidlo-prekliknutie" >Hlavná stránka
                    </button>
                </div>


            </form>
        </div>
    </div>
</div>




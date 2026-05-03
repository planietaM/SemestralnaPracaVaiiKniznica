<?php

/** @var int $celkovyPocet */
/** @var \Framework\Support\LinkGenerator $link */
?>

<h1>Pokročilé vyhľadavanie</h1>
<h2><?= $celkovyPocet ?></h2>
<h2>A je to </h2>
<div class="row mt-3">
    <div class="col">
        <a href="<?= $link->url("home.index") ?>">Back to main page</a>
    </div>

</div>
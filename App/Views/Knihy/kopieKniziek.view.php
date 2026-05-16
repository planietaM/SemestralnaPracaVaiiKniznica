<?php
/** @var array $kopieKniziek */
/** @var \Framework\Support\LinkGenerator $link */
?>


<div class="container-fluid">





    <div class="text-center nadpisovy-fond">
        <h2>Vsetky knizky</h2>
    </div>



    <div class="table-responsive">
        <table class="table table-striped table-hover data-table" border="2">
            <thead>
            <tr>
                <th>ID</th>
                <th>IDOriginalu</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($kopieKniziek  as $kniha): ?>
                <tr>
                    <td><?= htmlspecialchars((string)$kniha->getId()) ?></td>
                    <td><?= htmlspecialchars((string)$kniha->getIdOriginalKopie()) ?></td>
                </tr>
            <?php endforeach ?>


            </tbody>
        </table>
    </div>

    <script src="/js/script.js"></script>

    <button type="button "
            onclick="window.location.href='<?= $link->url("home.index") ?>'"
            class="btn btn-primary  tlacidlo-prekliknutie" >Hlavná stránka
    </button>



</div>

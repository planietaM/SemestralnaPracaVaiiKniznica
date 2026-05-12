<?php
/** @var array $knihy */
/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="container-fluid px-5 py-1">
    <div class="container-fluid">

        <div class="text-center nadpisovy-fond">
            <h2>Pokrocile vyhladavanie kniziek</h2>
        </div>

        <div class="mb-3">
            <input type="text" id="tableSearch" class="form-control w-100" placeholder="🔍 Rýchle hľadanie ...">
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Názov knihy</th>
                    <th>Autor</th>
                    <th>Fotka</th>
                </tr>
                </thead>
                <tbody id="booksTbody">
                <?php foreach ($knihy as $kniha): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)$kniha->getId()) ?></td>
                        <td><?= htmlspecialchars($kniha->getNazovKnizky()) ?></td>
                        <td><?= htmlspecialchars($kniha->getMenoAutora()) ?></td>
                        <td>
                            <img src="/images/<?= htmlspecialchars($kniha->getFotkaKnizky()) ?>" height="100">
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <div class="py-3">
            <button type="button"
                    onclick="window.location.href='<?= $link->url("home.index") ?>'"
                    class="btn btn-primary tlacidlo-prekliknutie p-3">Hlavná stránka
            </button>
        </div>
    </div>
</div>

<script src="<?= $link->asset('js/hladanieVTabulkeAjax.js') ?>"></script>
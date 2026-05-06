<?php
/** @var array $knihy */
/** @var \Framework\Support\LinkGenerator $link */
?>


<div class="container-fluid">




    <div class="row ">
        <div class="col ">
            <div class="text-center">
                <h2>Vyhladavanie kniziek</h2>
            </div>
        </div >

        <input type="text" id="tableSearch" class="form-control w-100" placeholder="🔍 Rýchle hľadanie ...">
    </div>


    <div class="table-responsive">
        <table class="table table-striped table-hover" border="2">
            <thead>
            <tr>
                <th>ID</th>
                <th>Názov knihy</th>
                <th>Autor</th>
                <th>Fotka</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($knihy as $kniha): ?>
                <tr>
                    <td><?= htmlspecialchars((string)$kniha->getId()) ?></td>
                    <td><?= htmlspecialchars($kniha->getNazovKnizky()) ?></td>
                    <td><?= htmlspecialchars($kniha->getMenoAutora()) ?></td>
                    <td>
                        <?php if ($kniha->getFotkaKnizky()): ?>
                            <img src="<?= htmlspecialchars($kniha->getFotkaKnizky()) ?>"
                                 height="50">
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <script src="/js/script.js"></script>




</div>

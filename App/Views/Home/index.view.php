<?php

/** @var \Framework\Support\LinkGenerator $link */
?>
<div class="pozadie-stranky">
    <div class="container-fluid px-5 py-1">
        <div class="text-center">
            <div class = "p-3 nadpisovy-fond">
            <h1>Knižničný systém</h1>
            </div>

            <div class="px-5 ">
                <div class="row">
                    <!-- Ľavý stĺpec -->
                    <div class="col-md-6">
                        <div class="podnadpisovy-fond p-3">
                            <h3>Pokrocile hladanie</h3>
                            <p>
                                Oat cake jujubes sugar chupa  tootsie roll candy canes. Soufflé jelly beans cake jelly topping danish. Topping dessert sweet lollipop lollipop halvah marzipan cake caramels. Ice cream marshmallow carrot cake sesame snaps cookie.
                            </p>
                        </div>
                        <button type="button"
                                onclick="window.location.href='<?= $link->url("knihy.index") ?>'"
                                class="btn btn-primary  tlacidlo-prekliknutie">Vyhladavanie
                        </button>
                    </div>

                    <!-- Pravý stĺpec -->
                    <div class="col-md-6">
                        <div class="podnadpisovy-fond p-3">
                            <h3>Tabuľka vsetkych kniziek</h3>
                            <p>
                                Bear claw brownie cheesecake toffee biscuit chocolate bar jujubes cookie.  toffeeHalvah shortbread cupcake croissant cake pudding. Candy candy canes topping sesame snaps cotton candy sweet caramels.
                            </p>
                        </div>
                        <button type="button "
                                onclick="window.location.href='<?= $link->url("knihy.kopieKniziek") ?>'"
                                class="btn btn-primary  tlacidlo-prekliknutie" >Ponuka
                        </button>
                    </div>

                </div>
            </div>




            <img src="<?= $link->asset('images/kniznicaObrazok.jpg') ?>" alt="Knižnica" class="img-fluid mt-4 mb-4">
            <p>
                Biscuit biscuit cake cotton candy chocolate cake biscuit chocolate pudding. Macaroon jujubes gummi bears donut lemon drops icing cookie. Dragée cotton candy carrot cake lemon drops oat cake marshmallow. Cotton candy tiramisu powder halvah soufflé sugar plum powder pie apple pie. Tiramisu carrot cake chocolate bar jelly-o jelly dessert wafer. Tootsie roll pudding cheesecake gingerbread ice cream cotton candy. Ice cream muffin candy liquorice sugar plum cotton candy cupcake bonbon chocolate cake. Marzipan biscuit apple pie pie marshmallow gummies gummies. Gummies candy cheesecake shortbread bonbon tootsie roll gingerbread danish cotton candy. Gummies soufflé sesame snaps oat cake dessert. Biscuit donut pudding gingerbread cupcake bear claw topping soufflé macaroon. Toffee cake cheesecake powder toffee jujubes icing. Chupa chups chocolate cake cupcake cake gummi bears marzipan ice cream topping sesame snaps.
            </p>
            <p>
                Powder halvah sugar plum dessert croissant. Danish cotton candy chocolate cake jujubes sweet roll jelly-o. Jelly-o candy canes cake tart cookie cheesecake dragée. Pie jujubes dragée cupcake wafer lemon drops cookie chocolate tart. Macaroon tiramisu topping carrot cake dragée sweet bonbon wafer bonbon. Sweet jelly brownie powder sesame snaps cookie ice cream. Liquorice tootsie roll chocolate bar gummi bears marshmallow apple pie. Lollipop danish sweet lemon drops donut icing. Tiramisu powder sesame snaps pudding bonbon macaroon. Danish donut dragée dragée gummies. Croissant tart powder gummi bears cake marzipan caramels topping. Carrot cake sweet roll fruitcake topping candy canes wafer.
            </p>

        </div>
    </div>
</div>

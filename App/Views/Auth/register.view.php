<?php


/** @var string|null $message */
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('auth');
?>

<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <h5 class="card-title text-center">Zaregistruj Sa</h5>
                    <div class="text-center text-danger mb-3">
                        <?= @$message ?>
                    </div>


                    <form class="form-signin" method="post" action="<?= $link->url("register") ?>">


                        <div class="form-label-group mb-3">
                            <label for="meno" class="form-label">Meno</label>

                            <input name="meno" type="text" id="meno" class="form-control" placeholder="Meno"
                                   required autofocus>
                        </div>


                        <div class="form-label-group mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input name="email" type="email" id="email" class="form-control"
                                   placeholder="E-mail" required>
                        </div>

                        <div class="form-label-group mb-3">
                            <label for="heslo" class="form-label">Heslo</label>
                            <input name="heslo" type="password" id="heslo" class="form-control"
                                   placeholder="Heslo" required>
                        </div>

                        <div class="form-label-group mb-3">
                            <label for="hesloOverenie" class="form-label">Overenie Hesla</label>
                            <input name="hesloOverenie" type="password" id="hesloOverenie" class="form-control"
                                   placeholder="Overenie Hesla" required>
                        </div>


                        <div class="text-center">
                            <button class="btn btn-primary" type="submit" name="submit">Vztvoorit účet
                            </button>

                            <button type="button"
                                    onclick="window.location.href='<?= $link->url("auth.login") ?>'"
                                    class="btn btn-primary"> Prihlas Sa
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

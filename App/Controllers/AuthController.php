<?php

namespace App\Controllers;

use App\Configuration;
use Exception;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\ViewResponse;

/**
 * Class AuthController
 *
 * This controller handles authentication actions such as login, logout, and redirection to the login page. It manages
 * user sessions and interactions with the authentication system.
 *
 * @package App\Controllers
 */
class AuthController extends BaseController
{
    /**
     * Redirects to the login page.
     *
     * This action serves as the default landing point for the authentication section of the application, directing
     * users to the login URL specified in the configuration.
     *
     * @return Response The response object for the redirection to the login page.
     */
    public function index(Request $request): Response
    {
        return $this->redirect(Configuration::LOGIN_URL);
    }

    /**
     * Authenticates a user and processes the login request.
     *
     * This action handles user login attempts. If the login form is submitted, it attempts to authenticate the user
     * with the provided credentials. Upon successful login, the user is redirected to the admin dashboard.
     * If authentication fails, an error message is displayed on the login page.
     *
     * @return Response The response object which can either redirect on success or render the login view with
     *                  an error message on failure.
     * @throws Exception If the parameter for the URL generator is invalid throws an exception.
     */
    public function login(Request $request): Response
    {
        $logged = null;
        if ($request->hasValue('submit')) {
            $logged = $this->app->getAuthenticator()->login($request->value('username'), $request->value('password'));
            if ($logged) {
                $user = $this->app->getAuthenticator()->getUser();

                if ($user->getRola() === 'admin') {
                    return $this->redirect($this->url("admin.index"));
                } else {
                    return $this->redirect($this->url("user.index"));
                }
            }
        }

        $message = $logged === false ? 'Bad username or password' : null;
        return $this->html(compact("message"));
    }

    public function register(Request $request): Response
    {
        $message = null;

        if ($request->isPost()) {

            $meno = $request->post('meno') ?? '';
            $email = $request->post('email') ?? '';
            $heslo = $request->post('heslo') ?? '';
            $hesloOverenie = $request->post('hesloOverenie') ?? '';

            $vsetciPouzivatelia = \App\Models\users::getAll();
            $emailUzExistuje = false;
            $menoUzExistuje = false;
            $jeProblemPriDatach = false;

            if (empty($meno) || empty($email) || empty($heslo)) {
                $message = "Všetky polia sú povinné!";
                $jeProblemPriDatach = true;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = "Neplatný formát e-mailu!";
                $jeProblemPriDatach = true;
            }
            foreach ($vsetciPouzivatelia as $existujuciUser) {

                if ($existujuciUser->getEmail() === $email) {
                    $emailUzExistuje = true;
                    break;
                }
                if ($existujuciUser->getMeno() === $meno) {
                    $menoUzExistuje = true;
                    break;
                }

            }

            if (strlen($heslo) < 6) {
                $message = "Heslo musí mať aspoň 6 znakov!";
                $jeProblemPriDatach = true;
            } elseif ($heslo !== $hesloOverenie) {
                $message = "Heslá sa nezhodujú!";
                $jeProblemPriDatach = true;
            } elseif ($emailUzExistuje) {
                $message = "Tento e-mail je už zaregistrovany!";
                $jeProblemPriDatach = true;
            } elseif ($menoUzExistuje) {
                $message = "Toto meno je už zaregistrovane!";
                $jeProblemPriDatach = true;
            }



            if($jeProblemPriDatach == false) {
                // 3. SEM IDE LOGIKA UKLADANIA (iba ak prebehla validácia OK)
                try {
                    // Musí sa volať presne ako class v modeli: users
                    $user = new \App\Models\users();

                    // Používame SETTERY, pretože vlastnosti sú protected
                    $user->setMeno($meno);
                    $user->setEmail($email);
                    $user->setHeslo(password_hash($heslo, PASSWORD_DEFAULT));

                    $user->setRolaPouzivatela('user');

                    // Uloženie do DB
                    $user->save();

                    // Presmerovanie po úspechu
                    return $this->redirect($this->url("auth.login"));

                } catch (\Exception $e) {
                    // Ak napr. email už existuje a DB vyhodí chybu
                    $message = "Chyba pri registrácii: " . $e->getMessage();
                }
            }
        }


        return $this->html([
            'message' => $message
        ], 'register');
    }

    /**
     * Logs out the current user.
     *
     * This action terminates the user's session and redirects them to a view. It effectively clears any authentication
     * tokens or session data associated with the user.
     *
     * @return ViewResponse The response object that renders the logout view.
     */
    public function logout(Request $request): Response
    {
        $this->app->getAuthenticator()->logout();
        return $this->html();
    }
}

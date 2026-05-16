<?php

namespace App\Controllers;
use App\Models\bookcopies;
use App\Models\books;
use App\Models\users;
use App\Models\borrowbooks;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;


class AdminController extends BaseController
{

    public function authorize(Request $request, string $action): bool
    {
        if($this->user->getRola() === 'admin') {
            return true;
        }
        return false;
    }

    public function index(Request $request): Response
    {
        $books = books::getAll();
        $borrowbooks = borrowbooks::getAll();
        $users = users::getAll();
        $bookcopies = bookcopies::getAll();

        return $this->html([
            'books' => $books,
            'borrowbooks' => $borrowbooks,
            'users' => $users,
            'bookcopies' => $bookcopies,
        ]);
    }
}

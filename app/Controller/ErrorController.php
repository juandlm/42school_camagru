<?php
namespace Camagru\Controller;

use Camagru\Core\Controller;

class ErrorController extends Controller
{
    public function index() {
        $this->render("index");
    }
}

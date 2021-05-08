<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Noauth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments=null)
    {
        $session = session();

        if ($session->user['isLoggedIn']) {
            return redirect()->to(site_url('profile'));
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments=null)
    {
        // Do something here
    }
}

<?php

namespace Turanct\Shack;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class Shack implements HttpKernelInterface
{
    private $app;
    private $sha;

    public function __construct(HttpKernelInterface $app, Sha $sha)
    {
        $this->app = $app;
        $this->sha = $sha;
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        $response = $this->app->handle($request, $type, $catch);

        $sha = $this->sha->get();
        $response->headers->set('X-Shack-Sha', $sha);

        return $response;
    }
}

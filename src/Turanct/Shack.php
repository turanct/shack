<?php

namespace Turanct;

use Turanct\Shack\Sha;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class Shack implements HttpKernelInterface
{
    private $app;
    private $sha;
    private $addStamp;

    public function __construct(HttpKernelInterface $app, Sha $sha, $addStamp = true)
    {
        $this->app = $app;
        $this->sha = $sha;
        $this->addStamp = (bool) $addStamp;
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        $response = $this->app->handle($request, $type, $catch);

        $sha = $this->sha->get();

        if (!empty($sha)) {
            $response->headers->set('X-Shack-Sha', $sha);

            if (
                $this->addStamp === true
                && stristr($response->headers->get('Content-Type'), 'text/html')
            ) {
                $body = $response->getContent();
                $body = str_replace('</body>', $this->getStamp($sha) . '</body>', $body);
                $response->setContent($body);
            }
        }

        return $response;
    }

    private function getStamp($sha = '')
    {
        return '<div id="sha-stamp" style="position: fixed; bottom: 0; right: 0; height: 16px; background: rgb(0, 0, 0) transparent; background-color: rgba(0, 0, 0, 0.2); padding: 0 5px; border-top-left-radius: 5px;">
    <span style="text-align: center;">
    <small style="color: white; font-weight: normal;font-size: 12px;">' . $sha . '</small>
    </span>
</div>';
    }
}

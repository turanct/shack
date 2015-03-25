<?php

namespace Turanct;

use Turanct\Shack\Sha;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Shack class
 */
final class Shack implements HttpKernelInterface
{
    /**
     * @var HttpKernelInterface The kernel we're decorating
     */
    private $app;

    /**
     * @var Sha The sha implementation
     */
    private $sha;

    /**
     * @var bool Should we add an HTML stamp to html pages?
     */
    private $addStamp;

    /**
     * Constructor
     *
     * @param HttpKernelInterface $app      The kernel we're decorating
     * @param Sha                 $sha      The sha implementation
     * @param bool                $addStamp Should we add an HTML stamp to the html pages?
     */
    public function __construct(HttpKernelInterface $app, Sha $sha, $addStamp = true)
    {
        $this->app = $app;
        $this->sha = $sha;
        $this->addStamp = (bool) $addStamp;
    }

    /**
     * @inheritDoc
     */
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        $response = $this->app->handle($request, $type, $catch);

        $sha = $this->sha->get();

        if (!empty($sha)) {
            $this->addShackHeader($response, $sha);
            $this->addStamp($response, $sha);
        }

        return $response;
    }

    /**
     * Add the shack header to a response object
     *
     * @param Response $response The response instance
     * @param string   $sha      The sha for this page
     *
     * @return Response The changed response
     */
    private function addShackHeader(Response $response, $sha)
    {
        $response->headers->set('X-Shack-Sha', $sha);

        return $response;
    }

    /**
     * Add the shack stamp to html pages
     *
     * @param Response $response The response instance
     * @param string   $sha      The sha for this page
     *
     * @return Response The changed response
     */
    private function addStamp(Response $response, $sha)
    {
        if (
            $this->addStamp === true
            && stristr($response->headers->get('Content-Type'), 'text/html')
        ) {
            $body = $response->getContent();
            $body = str_replace('</body>', $this->getStamp($sha) . '</body>', $body);
            $response->setContent($body);
        }

        return $response;
    }

    /**
     * Get the html for the stamp
     *
     * @param string $sha The sha for this page
     *
     * @return string The stamp to be inserted into a page's html
     */
    private function getStamp($sha = '')
    {
        return '<div id="sha-stamp" style="position: fixed; bottom: 0; right: 0; height: 16px; background: rgb(0, 0, 0) transparent; background-color: rgba(0, 0, 0, 0.2); padding: 0 5px; border-top-left-radius: 5px;">
    <span style="text-align: center;">
    <small style="color: white; font-weight: normal;font-size: 12px;">' . $sha . '</small>
    </span>
</div>';
    }
}

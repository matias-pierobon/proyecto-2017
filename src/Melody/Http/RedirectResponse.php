<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/15/17
 * Time: 9:42 PM
 */

namespace Melody\Http;


class RedirectResponse extends Response
{
    /* @var string */
    protected $targetUrl;

    public function __construct($url, $status = 302, $headers = array()){
        parent::__construct('', $status, $headers);
        $this->setTargetUrl($url);
    }

    /**
     * @return string
     */
    public function getTargetUrl()
    {
        return $this->targetUrl;
    }

    /**
     * @param string $url The URL to redirect to
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function setTargetUrl($url)
    {
        if (empty($url)) {
            throw new \InvalidArgumentException('Cannot redirect to an empty URL.');
        }
        $this->targetUrl = $url;
        $this->setContent(
            sprintf('<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="refresh" content="0;url=%1$s" />
        <title>Redirecting to %1$s</title>
    </head>
    <body>
        Redirecting to <a href="%1$s">%1$s</a>.
    </body>
</html>', htmlspecialchars($url, ENT_QUOTES, 'UTF-8')));
        $this->headers->set('Location', $url);
        return $this;
    }
}
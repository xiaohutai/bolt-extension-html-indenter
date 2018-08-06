<?php

namespace Bolt\Extension\XiaoHuTai\HtmlIndenter;

use Bolt\Extension\SimpleExtension;
use Gajus\Dindent\Indenter;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Automatically indents HTML responses. For aesthetic purposes.
 */
class HtmlIndenterExtension extends SimpleExtension
{
    /**
     * Subscribe to kernel responses.
     */
    protected function subscribe(EventDispatcherInterface $dispatcher)
    {
        /*
        // Only when debug is OFF
        $app = $this->getContainer();
        $config = $app['config'];
        $debug = $config->get('general/debug');

        if (! $debug) {
            $dispatcher->addListener(KernelEvents::RESPONSE, [$this, 'onKernelResponse']);
        }
        //*/

        $dispatcher->addListener(KernelEvents::RESPONSE, [ $this, 'onKernelResponse' ]);
    }

    /**
     * If response is HTML, indent it
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $response = $event->getResponse();
        $contenttype = $response->headers->get('content_type');

        if (strpos($contenttype, 'html') !== false) {
            $content = $response->getContent();
            $content = $this->indentHtml($content);
            $response->setContent( $content );
        }
    }

    /**
     * Indents HTML.
     *
     * @param string $html
     * @return string
     */
    private function indentHtml($html)
    {
        $config = $this->getConfig();

        // The `minify` option overrules everything
        if (isset($config['minify']) && $config['minify']) {
            return $this->minifyHtml($html);
        }

        $indenter = new Indenter([
            'indentation_character' => $config['indentation_character']
        ]);

        foreach ($config['blocks'] as $element) {
            $indenter->setElementType($element, Indenter::ELEMENT_TYPE_BLOCK);
        }

        foreach ($config['inline'] as $element) {
            $indenter->setElementType($element, Indenter::ELEMENT_TYPE_INLINE);
        }

        return $indenter->indent($html);
    }

    /**
     * Minifies HTML.
     *
     * TODO: Proper implementation
     * Inspired from https://github.com/dactivo/Bolt.cm-HTML-minifier/blob/master/Extension.php
     *
     * @param string $html
     * @return string
     */
    private function minifyHtml($html)
    {
        $search = [
            '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
            '/[^\S ]+\</s',  // strip whitespaces before tags, except space
            '/(\s)+/s'       // shorten multiple whitespace sequences
        ];

        $replace = [
            '>',
            '<',
            '\\1'
        ];

        $html = preg_replace($search, $replace, $html);
        return $html;
    }
}

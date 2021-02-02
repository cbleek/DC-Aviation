<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Mail;

use Laminas\Mail\Header\ContentType;
use Laminas\Stdlib\Response;
use Laminas\View\Model\ViewModel;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
trait StringTemplateHtmlMailTrait
{
    private $renderer;
    private $htmlTemplate = 'aviation.mail.HTMLContentMail';
    private $renderedBody;

    public function __construct($renderer, $options)
    {
        parent::__construct($options);
        $this->renderer = $renderer;
        $this->getHeaders()->addHeader(ContentType::fromString('Content-Type: text/html; charset=UTF-8'));
        $this->setEncoding('UTF-8');
    }

    public function getBodyText()
    {
        if ($this->renderedBody) {
            return $this->renderedBody;
        }

        $content = parent::getBodyText();

        $viewModel = new ViewModel(['content' => $content, 'mail' => $this]);
        $viewModel->setTemplate($this->htmlTemplate);

        $response = new Response();

        $view  = $this->renderer->getView();
        $view->setResponse($response);
        $view->render($viewModel);

        $this->renderedBody = $response->getContent();

        return $this->renderedBody;
    }



    /**
     * Get template
     *
     * @return mixed
     */
    public function getHtmlTemplate()
    {
        return $this->htmlTemplate;
    }

    /**
     * Set template
     *
     * @param mixed $template
     */
    public function setHtmlTemplate($template): void
    {
        $this->htmlTemplate = $template;
    }
}

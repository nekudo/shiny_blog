<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

use RuntimeException;

class HtmlResponder extends HttpResponder
{
    /**
     * @var string $layout Layout file to use when rendering.
     */
    protected $layout = 'default';

    /**
     * @var string $themeFolder Folder containing templates/layouts.
     */
    protected $themeFolder = '';

    /**
     * @var array $templateData Data available within templates/layouts.
     */
    protected $templateData = [];

    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->themeFolder = $config['themesFolder'] . '/' . $config['theme'] . '/';
    }

    /**
     * Sets layout to use when displaying a template.
     *
     * @param string $layout
     */
    public function setLayout(string $layout)
    {
        $this->layout = $layout;
    }

    /**
     * Assigns data to be rendered into a template/layout.
     *
     * @param string $variableName
     * @param mixed $variableContent
     */
    public function assign(string $variableName, $variableContent)
    {
        $this->templateData[$variableName] = $variableContent;
    }

    /**
     * Renders a template and layout and echos the result.
     *
     * @param string $templateName
     */
    public function show(string $templateName)
    {
        $templateContent = $this->renderTemplate($templateName);
        $this->templateData['template'] = $templateContent;
        $html = $this->renderLayout();
        $this->found($html);
    }

    /**
     * Renders template file.
     *
     * @param string $templateName
     * @return string
     */
    public function renderTemplate(string $templateName) : string
    {
        $templateFile = $this->themeFolder . $templateName . '.php';
        return $this->render($templateFile);
    }

    /**
     * Renders a layout file.
     *
     * @return string
     */
    public function renderLayout() : string
    {
        $layoutFile = $this->themeFolder .'layouts/' . $this->layout . '.php';
        return $this->render($layoutFile);
    }

    /**
     * Renders a file from themes folder.
     *
     * @param string $templateFile
     * @return string
     */
    protected function render(string $templateFile) : string
    {
        if (!file_exists($templateFile)) {
            throw new RuntimeException('Template file not found.');
        }
        extract($this->templateData);
        ob_start();
        include $templateFile;
        return ob_get_clean();
    }
}

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
     * @var string $templateName Template to render.
     */
    protected $templateName = '';

    /**
     * @var string $themeFolder Folder containing templates/layouts.
     */
    protected $themeFolder = '';

    /**
     * @var string $pageTitle Title of page.
     */
    protected $pageTitle = '';

    /** @var string $description Pages meta description */
    protected $description = '';

    /** @var string $feedUrl */
    protected $feedUrl = '';

    /** @var string $index */
    protected $index = 'index,follow';

    /**
     * @var int $page Current page.
     */
    protected $page = 0;

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
     * Sets page-title.
     *
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->pageTitle = $title;
    }

    /**
     * Returns formatted page title.
     *
     * @return string
     */
    public function getTitle() : string
    {
        return $this->pageTitle;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Gets meta-description for current page type.
     *
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * Sets feed url property.
     *
     * @param string $urlPath
     */
    public function setFeedUrl(string $urlPath)
    {
        $this->feedUrl = $this->getUrlFromPath($urlPath);
    }

    /**
     * Returns feed-url property.
     *
     * @return string
     */
    public function getFeedUrl() : string
    {
        return $this->feedUrl;
    }

    /**
     * Sets meta index/follow directives.
     *
     * @param string $index
     */
    public function setIndex(string $index)
    {
        $this->index = $index;
    }

    /**
     * Gets index,follow/nofollow setting.
     *
     * @return string
     */
    public function getIndex() : string
    {
        return $this->index;
    }

    /**
     * Returns current page type.
     *
     * @return string
     */
    protected function getPageType() : string
    {
        $pageType = $this->templateName;
        if (empty($pageType)) {
            throw new RuntimeException('Unknown page type.');
        }
        if ($pageType === 'blog' && $this->page > 1) {
            $pageType .= '_paginated';
        }
        return $pageType;
    }

    /**
     * Sets paginated value (Should be true if page > 1)
     *
     * @param int $page
     */
    public function setPage(int $page)
    {
        $this->page = $page;
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
    protected function renderTemplate(string $templateName) : string
    {
        $this->templateName = $templateName;
        $templateFile = $this->themeFolder . $templateName . '.php';
        return $this->render($templateFile);
    }

    /**
     * Renders a layout file.
     *
     * @return string
     */
    protected function renderLayout() : string
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

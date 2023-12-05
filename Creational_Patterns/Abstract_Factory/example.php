<?php
interface TemplateFactory{
    public function createTitleTemplate(): TitleTemplate;
    public function createPageTemplate(): PageTemplate;
    public function getRender(): TemplateRender;
}

class TwigTemplateFactory implements TemplateFactory{
    public function createTitleTemplate(): TitleTemplate{
        return new TwigTitleTemplate();
    }

    public function createPageTemplate(): PageTemplate{
        return new TwigPageTemplate();
    }

    public function getRender(): TemplateRender{
        return new TwigTemplateRender();
    }
}

interface TitleTemplate{
    public function getTemplateString(): string;
}

interface PageTemplate{
    public function getTemplateString(): string;
}

interface TemplateRender{
    public function render(string $templateString, array $arguments = []): string;
}

class TwigTitleTemplate implements TitleTemplate{
    public function getTemplateString(): string{
        return "<h1>{{ title }}</h1>";
    }
}

class PHPTitleTemplate implements TitleTemplate{
    public function getTemplateString(): string{
        return "<h1><?= \$title; ?></h1>";
    }
}

abstract class BasePageTemplate implements PageTemplate{
    protected $titleTemplate;

    public function __construct(TitleTemplate $titleTemplate){
        $this->titleTemplate = $titleTemplate;
    }
}

class TwigPageTemplate extends BasePageTemplate{
    public function getTemplateString(): string{
        $renderedTitle = $this->titleTemplate->getTemplateString();
        return <<<HTML
        <div class="page">
            $renderedTitle
            <article class="content">{{ content }}</article>
        </div>
        HTML;
    }
}

class PHPPageTemplate extends BasePageTemplate{
    public function getTemplateString(): string{
        $renderedTitle = $this->titleTemplate->getTemplateString();
        return <<<HTML
        <div class="page">
            $renderedTitle
            <article class="content"><?= \$content; ?></article>
        </div>
        HTML;
    }
}

class TwigTemplateRender implements TemplateRender{
    public function render(string $templateString, array $arguments = []): string{
        return \Twig::render($templateString, $arguments);
    }
}

class PHPTemplateRenderer implements TemplateRender{
    public function render(string $templateString, array $arguments = []): string{
        extract($arguments);

        ob_start();
        eval(' ?>' . $templateString . '<?php ');
        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }
}





?>
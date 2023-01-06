<?php

namespace A17\Twill\Services\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

class BladePartial
{
    protected function __construct(
        protected ?string $view = null,
        protected ?array $params = [],
    ) {
    }

    public static function make(): self
    {
        return new self();
    }

    public function view(string $view, array $params = []): static
    {
        $this->view = $view;
        $this->params = $params;

        return $this;
    }

    public function render(): ?View
    {
        if (! $this->view) {
            return null;
        }

        $form = ViewFacade::shared('form');

        return ViewFacade::make(
            $this->view,
            array_merge(
            $this->params,
            [
                'item' => $form['item'] ?? null,
                'form_fields' => $form['form_fields'] ?? [],
                'formModuleName' => $form['moduleName'] ?? null,
                'routePrefix' => $form['routePrefix'] ?? null,
            ]
        )
        );
    }
}

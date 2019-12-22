<?php

namespace RedRock\Subscriptions;

class SettingsView extends View {
    private $subpageToRender;
    private $tabViewToRender;
    private $flashMessageToRender;
    
    public function __construct(
        $subpageToRender,
        $tabViewToRender        = NULL,
        $flashMessageToRender   = NULL
    ) {
        $this->subpageToRender      = $subpageToRender;
        $this->tabViewToRender      = $tabViewToRender;
        $this->flashMessageToRender = $flashMessageToRender;
    }
    
    private function renderSubpage() {
        $subpageToRender->renderInPlace();
    }
    
    private function maybeRenderTabView() {
        if ($tabViewToRender !== NULL) {
            $tabViewToRender->renderInPlace();
        }
    }
    
    private function maybeRenderFlashMessage() {
        if ($flashMessageToRender !== NULL) {
            $flashMessageToRender->renderInPlace();
        }
    }
}

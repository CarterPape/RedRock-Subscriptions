<?php

namespace RedRock\Subscriptions;

class SettingsView extends View {
    private $subpageToRender;
    private $tabViewToRender;
    private $flashMessageToRender;
    
    public __construct(
        $subpageToRender,
        $tabViewToRender        = NULL,
        $flashMessageToRender   = NULL
    ) {
        $this->subpageToRender      = $subpageToRender;
        $this->tabViewToRender      = $tabViewToRender;
        $this->flashMessageToRender = $flashMessageToRender;
    }
    
    private function renderSubpage() {
        $subpageToRender->renderIt();
    }
    
    private function maybeRenderTabView() {
        if ($tabViewToRender !== NULL) {
            $tabViewToRender->renderIt();
        }
    }
    
    private function maybeRenderFlashMessage() {
        if ($flashMessageToRender !== NULL) {
            $flashMessageToRender->renderIt();
        }
    }
}

<?php

namespace RedRock\Subscriptions;

?>

<div class="wrap">
    <?php $this->maybeRenderTabView(); ?>
    <?php $this->maybeRenderFlashMessage(); ?>
    <div id="memberful-wrap">
        <?php $this->renderCurrentSettingsSubpage(); ?>
    </div>
</div>

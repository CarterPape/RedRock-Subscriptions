<?php

namespace RedRock\Subscriptions;

?>

<div id="print-plus-digital-offer">
<?php
    if (!empty($this->subscriptions)) {
?>
        <ul>
<?php        
            foreach ($this->subscriptions as $id => $subscription) {
?>
                <li>
                    <a href="<?php echo $subscription->checkoutURL; ?>">
                        <?php echo esc_html($subscription->name); ?>
                    </a>
                </li>
<?php
            }
?>
        </ul>
<?php
    }
?>
</div>

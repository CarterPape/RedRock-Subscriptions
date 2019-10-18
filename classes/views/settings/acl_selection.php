<div class="memberful-acl-block">
    <!-- also, 'anyone_with_free_reads' -->
    <input
        type="checkbox"
        name="memberful_viewable_by_any_registered_users"
        value="1"
<?php
        if (isset($viewable_by_any_registered_users) && $viewable_by_any_registered_users) {
            echo "checked='checked'";
        }
?>
    />
    <label for="memberful_viewable_by_any_registered_users">
        Any registered user
    </label>
</div>
<div
    data-depends-on="memberful_viewable_by_any_registered_users"
    data-depends-value-not="1"
>
<?php
    if (!empty($subscriptions)) {
?>
        <div
            id="memberful-subscriptions"
            class="memberful-acl-block"
        >
            <p class="memberful-access-label">Anybody subscribed to:</p>
            <ul>
<?php
            foreach ($subscriptions as $id => $subscription) {
?>
                <li>                    
                    <input type="checkbox" name="memberful_subscription_acl[]" value="<?php echo $id; ?>" <?php checked($subscription['checked']); ?> />
                    <label for="memberful_subscription_acl[]">
                        <?php echo esc_html($subscription['name']); ?>
                    </label>
                </li>
<?php
            }
?>
            </ul>
        </div>
<?php
    }
?>
</div>

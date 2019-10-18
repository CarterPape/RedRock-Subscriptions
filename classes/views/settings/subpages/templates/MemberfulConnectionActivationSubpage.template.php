<?php

namespace RedRock\Subscriptions;

?>


<div id="memberful-registration">
    <div class="memberful-sign-up postbox">
        <h1>You'll need a Memberful account.</h1>
        <p><a href="https://memberful.com">Sign up for a Memberful account</a>.</p>
    </div>
    <div class="memberful-register-plugin">
        <h3>Already have an account?</h3>
        <form method="post" action="<?php echo admin_url('admin-post.php') ?>">
            <fieldset>
                <textarea
                    placeholder="Paste your WordPress registration key here"
                    name="activation_code"
                />
                <input
                    type="submit"
                    value="Connect to Memberful"
                    class="
                        button
                        button-primary
                        button-large
                    "
                />
                <input
                    type="hidden"
                    name="action"
                    value="RRS_activate_Memberful_connection"
                />
                <?php $this->renderNonceField(); ?>
            </fieldset>
        </form>
    </div>
</div>

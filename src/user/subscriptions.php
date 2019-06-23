<?php
require_once Plugin::defaultInstance()->getPluginDir().'/src/user/entity.php';

/**
 * Interface for interacting with a user's downloads
 *
 */
class Memerful_WP_User_Subscriptions extends Memerful_WP_User_Entity { 

    static public function sync($user_id, $entities) {
        $syncer = new Memerful_WP_User_Subscriptions($user_id);
        return $syncer->set($entities);
    }

    protected function entity_type() {
        return 'subscription';
    }

    protected function format($entity) {
        return array(
            'activated_at'    => $entity->activated_at,
            'autorenew'       => $entity->renew_at_end_of_period,
            'expires'         => $entity->expires,
            'expires_at'      => $entity->expires_at,
            'id'              => $entity->subscription->id,
            'in_trial_period' => $entity->in_trial_period
        );
    }
}

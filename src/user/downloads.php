<?php
require MEMBERFUL_DIR . '/src/user/entity.php';

class Memerful_WP_User_Downloads extends Memerful_WP_User_Entity { 

    static public function sync($user_id, $entities) {
        $syncer = new Memerful_WP_User_Downloads($user_id);
        return $syncer->set($entities);
    }

    protected function entity_type() {
        return 'download';
    }

    protected function format($entity) {
        return array('id' => $entity->download->id);
    }
}

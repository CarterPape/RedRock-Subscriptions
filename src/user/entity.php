<?php

abstract class Memberful_Wp_User_Entity {
    protected $entities;
    protected $user_id;

    public function __construct($user_id) {
        $this->user_id = $user_id;
    }
    
    public function get() {
        if ($this->entities === NULL) {
            $this->entities = get_user_meta($this->user_id, $this->meta_field());
        }

        return $this->entities;
    }
    
    public function add(array $entities) {
        $current = $this->get();

        foreach ($entities as $entity) {
            $data = $this->format($entity);

            $current[$data['id']] = $data;
        }

        update_user_meta($this->user_id, $this->meta_field(), $current);
    }

    public function set(array $entities) {
        $new_purchasables = array();

        foreach ($entities as $entity) {
            $data = $this->format($entity);

            $new_purchasables[$data['id']] = $data;
        }

        update_user_meta($this->user_id, $this->meta_field(), $new_purchasables);
    }

    protected function meta_field() {
        return 'memberful_'.$this->entity_type();
    }

    abstract protected function entity_type();
    abstract protected function format($entity);
}

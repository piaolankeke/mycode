<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->table='forums_setting';
        $this->id='forum_id';
    }

}

?>

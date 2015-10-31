<?php 

class Proposicao_model extends MY_Model {

    const TABLE_NAME = 'proposicoes';

    var $nome;
    var $descricao;
    var $id;

    function __construct()
    {
        $this->TABLE_NAME = self::TABLE_NAME;
        parent::__construct();
    }
    
    public function get_all()
    {
        $query = $this->db->get(self::TABLE_NAME);
        return $this->get_self_results($query);
    }
}

<?php 

class Proposicao_model extends MY_Model {

    const TABLE_NAME = 'proposicoes';

    var $nome;
    var $ementa;
    var $id;
    var $camara_id;
    var $situacao;

    const STATUS_DISPONIVEL = 0;
    const STATUS_DESATIVADA = 1;
    const STATUS_RESERVADA = 2;
    const STATUS_PUBLICADA = 3;

    function __construct($data = array())
    {
        $this->TABLE_NAME = self::TABLE_NAME;
        parent::__construct($data);

    }
    
    public function get_all()
    {
        $query = $this->db->get(self::TABLE_NAME);
        return $this->get_self_results($query);
    }

    public function get_ativas()
    {
        $query = $this->db->get_where(self::TABLE_NAME, array('situacao !=' => self::STATUS_DESATIVADA));
        return $this->get_self_results($query);
    }

    public function get_by_camara_id($idProposicao)
    {
        $query = $this->db->get_where(self::TABLE_NAME, array('camara_id' => $idProposicao));
        return $this->get_first_self_result($query);
    }

    public function desativar()
    {
        $this->situacao = self::STATUS_DESATIVADA;
    }

    public function ativar()
    {
        //TODO: quando tiver alguem colaborando, mudar para reservada
        $this->situacao = self::STATUS_DISPONIVEL;
    }

    public function is_ativa()
    {
        return $this->situacao != self::STATUS_DESATIVADA;
    }

    public function list_from_xml_camara($content)
    {
        $models = [];
        if($content == null) 
        {
            return $models;
        }

        $xml = new SimpleXMLElement($content);
        foreach ($xml->xpath('//proposicao') as $item) {
            $model = new Proposicao_model();
            $model->nome = (string) $item->nomeProposicao;
            $model->ementa = (string) $item->Ementa;
            $model->camara_id = (int) $item->idProposicao;
            $model->situacao = self::STATUS_DISPONIVEL;

            array_push($models, $model);
        }
        
        return $models;
    }

    public function get_from_xml_camara($content)
    {
        $models = $this->list_from_xml_camara($content);
        if(empty($models))
        {
            return null;
        }

        return array_pop($models);
    }
}

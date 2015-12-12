<?php 

class Proposicao_model extends MY_Model {

    const TABLE_NAME = 'proposicoes';

    var $id;
    var $nome;
    var $ementa;
    
    var $camara_id;
    var $situacao;
    
    var $descricao;
    var $resumo;
    var $colaborador_id;

    var $numero;
    var $ano;

    var $tema;
    var $data_apresentacao;
    var $regime_tramitacao;
    var $apreciacao;
    var $situacao_camara;
    var $link;
    var $explicacao_ementa;
    var $tipo;
    var $tipo_descricao;
    
    var $autor;
    var $autor_uf;
    var $autor_partido;
    var $autor_camara_id;

    var $xml;

    private $colaborador = null;

    const STATUS_DISPONIVEL = 0;
    const STATUS_DESATIVADA = 1;
    const STATUS_RESERVADA = 2;
    const STATUS_PUBLICADA = 3;


    private $sitaucao_desc = 
    [
        0 => "Disponível",
        1 => "Desativada",
        2 => "Reservada",
        3 => "Publicada"
    ];

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

    public function get_em_edicao()
    {
        $this->db->dbprefix(self::TABLE_NAME);
        $this->db->where_in('situacao', [self::STATUS_DISPONIVEL, self::STATUS_RESERVADA]);
        $query = $this->db->get(self::TABLE_NAME);
        return $this->get_self_results($query);
    }

    public function get_by_camara_id($idProposicao)
    {
        $query = $this->db->get_where(self::TABLE_NAME, array('camara_id' => $idProposicao));
        return $this->get_first_self_result($query);
    }

    public function get_colaborador()
    {
        if(!$this->colaborador)
        {
            //TODO: rever melhor opção para esta busca
            $ci =& get_instance();
            $ci->load->model('User_model');
            $this->colaborador = $ci->User_model->get_by_id($this->colaborador_id);
        }

        return $this->colaborador;   
    }


    public function get_situacao_desc()
    {
        return $this->sitaucao_desc[$this->situacao];
    }

    public function desativar()
    {
        $this->situacao = self::STATUS_DESATIVADA;
    }

    public function ativar()
    {
        //TODO: quando tiver alguem colaborando, ver se deve mudar para reservada
        $this->situacao = self::STATUS_DISPONIVEL;
    }

    public function is_ativa()
    {
        return $this->situacao != self::STATUS_DESATIVADA;
    }

    public function is_reservada()
    {
        return $this->situacao == self::STATUS_RESERVADA;
    }

    public function pode_excluir(&$errors)
    {
        $errors = [];
        if($this->situacao != self::STATUS_DESATIVADA)
        {
            $errors[] = 'Proposição em situação inválida para ser excluída';
            return false;
        }
        return true;
    }

    public function excluir(&$errors)
    {
        $errors = [];
        if(!$this->pode_excluir($errors))
        {
            throw new Exception(join(',', $errors));
        }

        $this->delete();
    }

    public function pode_reservar(&$errors)
    {
        $errors = [];
        if($this->situacao != self::STATUS_DISPONIVEL)
        {
            $errors[] = 'Proposição em situação inválida para reservar';
            return false;
        }
        return true;
    }

    public function reservar($user)
    {
        $errors = [];
        if(!$this->pode_reservar($errors))
        {
            throw new Exception(join(',', $errors));
        }

        $this->colaborador_id = $user->id;
        $this->situacao = self::STATUS_RESERVADA;
    }

    public function pode_liberar($user, &$errors)
    {
        $errors = [];
        if($this->situacao != self::STATUS_RESERVADA)
        {
            $errors[] = 'Proposição em situação inválida para liberar';
        }
        if($this->colaborador_id != $user->id && !$user->is(User_model::ROLE_ADMIN))
        {
            $errors[] = 'Apenas o colaborador dono da reserva pode liberar esta proposição';
        }

        return empty($errors);
    }

    public function liberar($user)
    {
        $errors = [];
        if(!$this->pode_liberar($user, $errors))
        {
            throw new Exception(join(',', $errors));
        }

        $this->colaborador_id = null;
        $this->situacao = self::STATUS_DISPONIVEL;
    }

    public function pode_editar_resumo($user, &$errors)
    {
        $errors = [];
        if($this->situacao != self::STATUS_RESERVADA)
        {
            $errors[] = 'Proposição em situação inválida para edição do resumo';
        }
        if($this->colaborador_id != $user->id && !$user->is(User_model::ROLE_ADMIN))
        {
            $errors[] = 'Apenas o colaborador dono da reserva pode editar o reseumo desta proposição';
        }

        return empty($errors);
    }

    public function editar_resumo($user, $resumo, $descricao)
    {
        $errors = [];
        if(!$this->pode_editar_resumo($user, $errors))
        {
            throw new Exception(join(',', $errors));
        }

        $this->resumo = $resumo;
        $this->descricao = $descricao;
    }

    public function pode_publicar($user, &$errors)
    {
        $errors = [];
        if($this->situacao != self::STATUS_RESERVADA)
        {
            $errors[] = 'Proposição em situação inválida para publicação';
        }

        if(empty($this->descricao) || empty($this->resumo))
        {
            $errors[] = 'Proposição ainda sem resumo ou descição';
        }

        if($this->colaborador_id != $user->id && !$user->is(User_model::ROLE_ADMIN))
        {
            $errors[] = 'Apenas o colaborador dono da reserva pode publicar esta proposição';
        }

        return empty($errors);
    }


    public function publicar($user)
    {
        $errors = [];
        if(!$this->pode_publicar($user, $errors))
        {
            throw new Exception(join(',', $errors));
        }

        $this->situacao = self::STATUS_PUBLICADA;
    }
}

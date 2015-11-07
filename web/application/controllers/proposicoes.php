<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Proposicoes extends MY_Controller
{
    protected $before_filter = array('action' => 'authorize');

    public function authorize()
    {
        $user = $this->get_currentuser();
        if(!$user)
        {
            redirect(base_url());
        }

        $called_action = $this->router->fetch_method();
        $is_admin = $user->roles == User_model::ROLE_ADMIN;
        if(in_array($called_action, ['pesquisar', 'adicionar', 'desativar']) && !$is_admin)
        {
            redirect(base_url());   
        }

        $this->is_admin = $is_admin;
        $this->set_data('is_admin', $is_admin);
    }

    public function index()
    {
        $this->load->model('Proposicao_model');

        $proposicoes = $this->is_admin ? $this->Proposicao_model->get_all() : $this->Proposicao_model->get_ativas();

        $this->set_data('proposicoes', $proposicoes);
        $this->load->view('proposicoes/index', $this->get_data());
    }

    public function pesquisar()
    {
        $sigla = isset($_GET['sigla']) ? trim($_GET['sigla']) : null;
        $numero = isset($_GET['numero']) ? trim($_GET['numero']) : null;
        $ano = isset($_GET['ano']) ? trim($_GET['ano']) : null;

        if($sigla == null || $ano == null || $numero == null)
        {
            $this->load->view('proposicoes/pesquisar', ['proposicoes' => [], 'sigla' => $sigla, 'numero' => $numero, 'ano' => $ano]);
            return;
        }

        $this->load->helper('camara');
        $proposicoes = pesquisar_proposicao_camara($sigla, $numero, $ano);
        $this->load->view('proposicoes/pesquisar', ['sigla' => $sigla, 'numero' => $numero, 'ano' => $ano, 'proposicoes' => $proposicoes]);
    }

    public function adicionar($idProposicao)
    {
        $sigla = isset($_GET['sigla']) ? $_GET['sigla'] : null;
        $numero = isset($_GET['numero']) ? $_GET['numero'] : null;
        $ano = isset($_GET['ano']) ? $_GET['ano'] : null;

        $this->load->model('Proposicao_model');
        $proposicao = $this->Proposicao_model->get_by_camara_id($idProposicao);  

        if($proposicao)
        {
            $this->session->set_flashdata('errors', ['Proposição já adicionada']);
            redirect('/proposicoes/pesquisar?sigla='.$sigla.'&numero='.$numero.'&ano='.$ano, 'refresh');
        }

        $this->load->helper('camara');
        $proposicao = obter_proposicao_camara($idProposicao);

        $id = $proposicao->insert();

        $this->session->set_flashdata('messages', ['Proposição adicionada com sucesso']);
        redirect(base_url('/proposicoes'));
    }

    public function desativar($id)
    {
        $this->load->model('Proposicao_model');
        $proposicao = $this->Proposicao_model->get_by_id($id);

        $proposicao->desativar();
        $proposicao->update();

        $this->session->set_flashdata('messages', ['Proposição desativada com sucesso']);
        redirect(base_url('/proposicoes'));
    }

    public function ativar($id)
    {
        $this->load->model('Proposicao_model');
        $proposicao = $this->Proposicao_model->get_by_id($id);

        $proposicao->ativar();
        $proposicao->update();

        $this->session->set_flashdata('messages', ['Proposição ativada com sucesso']);
        redirect(base_url('/proposicoes'));
    }
}

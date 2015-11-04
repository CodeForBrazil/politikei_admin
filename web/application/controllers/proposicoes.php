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
        if(in_array($called_action, ['pesquisar', 'adicionar']) && !$is_admin)
        {
            redirect(base_url());   
        }

        $this->set_data('is_admin', $is_admin);
    }

    public function index()
    {
        $this->load->model('Proposicao_model');
        $proposicoes = $this->Proposicao_model->get_all();
        $this->set_data('proposicoes', $proposicoes);
        $this->load->view('proposicoes/index', $this->get_data());
    }

    public function pesquisar()
    {
        $sigla = isset($_GET['sigla']) ? trim($_GET['sigla']) : null;
        $numero = isset($_GET['numero']) ? trim($_GET['numero']) : null;
        $ano = isset($_GET['ano']) ? trim($_GET['ano']) : null;

        if($sigla == null || $ano == null || $numero == null){
            $this->load->view('proposicoes/pesquisar', ['proposicoes' => [], 'sigla' => $sigla, 'numero' => $numero, 'ano' => $ano]);
            return;
        }

        $proposicoes = $this->pesquisar_proposicao_camara($sigla, $numero, $ano);
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

        $proposicao = $this->obter_proposicao_camara($idProposicao);

        $id = $proposicao->insert();

        $this->session->set_flashdata('messages', ['Proposição adicionada com sucesso']);
        redirect('/', 'refresh');
    }


    //TODO: mover para outra classe os métodos privados
    private function obter_proposicao_camara($id)
    {
        $xml = $this->chama_web_service('ObterProposicaoPorID?IdProp='.$id);
        $this->load->model('Proposicao_model');
        $proposicao = $this->Proposicao_model->get_from_xml_camara($xml);
        return $proposicao;
    }


    private function pesquisar_proposicao_camara($sigla, $numero, $ano)
    {
        $xml = $this->chama_web_service('ObterProposicao?tipo='.$sigla.'&numero='.$numero.'&ano='.$ano);
        $this->load->model('Proposicao_model');
        $proposicoes = $this->Proposicao_model->list_from_xml_camara($xml);

        return  $proposicoes;
    }


    private function chama_web_service($path)
    {
        $url = 'http://www.camara.gov.br/SitCamaraWS/Proposicoes.asmx/'.$path;
        $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

        $options = array(
            CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
            CURLOPT_POST           =>false,        //set to GET
            CURLOPT_USERAGENT      => $user_agent, //set user agent
            CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
            CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        return $content;
    }

}

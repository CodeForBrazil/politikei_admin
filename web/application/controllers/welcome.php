<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Welcome extends MY_Controller
{

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        if (isset($_GET['from'])) {
            $this->set_data('open_modal', 'login');
        }

        if (!$this->check_user(null,FALSE)) {
            $this->load->view('welcome/home', $this->get_data());
            return;
        }

        $this->load->model('Proposicao_model');
        $proposicoes = $this->Proposicao_model->get_all();
        
        $user = $this->get_currentuser();
        $admin = $user->is(User_model::ROLE_ADMIN);
        
        $this->set_data('proposicoes',$proposicoes);
        $this->set_data('admin',$admin);

        $this->load->view('welcome/index', $this->get_data());
    }


    public function pesquisar()
    {
        $sigla = isset($_GET['sigla']) ? trim($_GET['sigla']) : null;
        $numero = isset($_GET['numero']) ? trim($_GET['numero']) : null;
        $ano = isset($_GET['ano']) ? trim($_GET['ano']) : null;

        if($sigla == null || $ano == null || $numero == null){
            $this->load->view('welcome/pesquisar', ['proposicoes' => [], 'sigla' => $sigla, 'numero' => $numero, 'ano' => $ano]);
            return;
        }

        $proposicoes = $this->pesquisar_proposicao_camara($sigla, $numero, $ano);

        $this->load->view('welcome/pesquisar', ['sigla' => $sigla, 'numero' => $numero, 'ano' => $ano, 'proposicoes' => $proposicoes]);
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
            redirect('/welcome/pesquisar?sigla='.$sigla.'&numero='.$numero.'&ano='.$ano, 'refresh');
        }

        $proposicao = $this->obter_proposicao_camara($idProposicao);

        $id = $proposicao->insert();

        $this->session->set_flashdata('messages', ['Proposição adicionada com sucesso']);
        redirect('/', 'refresh');
    }


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


    /**
     * Page displaying the current theme.
     */
    public function theme()
    {
        $this->load->view('welcome/theme');
    }

    /**
     * Page with todo list.
     */
    public function todo()
    {
        $this->load->view('welcome/todo');
    }

    /**
     * Sign out action.
     *
     * @return void
     */
    public function out()
    {
        $this->session->sess_destroy();
        redirect('/');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

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
		
		if ($this->check_user()) {
			$url = "http://www.camara.gov.br/SitCamaraWS/Proposicoes.asmx/ListarProposicoes?sigla=PL&numero=&ano=2011&datApresentacaoIni=14/11/2011&datApresentacaoFim=16/11/2011&parteNomeAutor=&idTipoAutor=&siglaPartidoAutor=&siglaUFAutor=&generoAutor=&codEstado=&codOrgaoEstado=&emTramitacao=";
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
		
			$this->set_data('proposicoes', $content);
		}
		

        $this->load->view('welcome/home', $this->get_data());
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

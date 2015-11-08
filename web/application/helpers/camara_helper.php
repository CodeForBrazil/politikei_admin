<?php
if ( ! defined('BASEPATH'))
{
    exit('No direct script access allowed');
}

function obter_proposicao_camara($id)
{
    $xml = chama_web_service('ObterProposicaoPorID?IdProp='.$id);
    $proposicao = get_from_xml_camara($xml);
    return $proposicao;
}

function pesquisar_proposicao_camara($sigla, $numero, $ano)
{
    $xml = chama_web_service('ObterProposicao?tipo='.$sigla.'&numero='.$numero.'&ano='.$ano);
    $proposicoes = list_from_xml_camara($xml);
    return  $proposicoes;
}

function chama_web_service($path)
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


function list_from_xml_camara($content)
{
    $models = [];
    if($content == null) 
    {
        return $models;
    }

    $ci = get_instance();   
    $ci->load->model('Proposicao_model');
    $xml = new SimpleXMLElement($content);
    foreach ($xml->xpath('//proposicao') as $item) {
        $model = new $ci->Proposicao_model;
        $model->nome = (string) $item->nomeProposicao;
        $model->ementa = (string) $item->Ementa;
        $model->camara_id = (int) $item->idProposicao;
        $model->situacao = Proposicao_model::STATUS_DISPONIVEL;

        array_push($models, $model);
    }
    
    return $models;
}

function get_from_xml_camara($content)
{
    $models = list_from_xml_camara($content);
    if(empty($models))
    {
        return null;
    }

    return array_pop($models);
}

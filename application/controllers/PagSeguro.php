<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PagSeguro extends CI_Controller {

    public function index(){
        return $this->load->view('PagSeguro/index');
    }

	public function session()
	{
		$url = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions?email=seuemail&token=seutoken";
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_HTTPHEADER,array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8"));
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        $response=curl_exec($curl);
        curl_close($curl);

        $xml=simplexml_load_string($response);
        echo json_encode($xml);
	}
}

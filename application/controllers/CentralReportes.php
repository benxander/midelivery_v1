<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CentralReportes extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//cache
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
		$this->sessionVP = @$this->session->userdata('sess_vp_'.substr(base_url(),-8,7));
		$this->load->library('fpdfext');
	}

	function imprimir_qr()
	{
		$allInputs = json_decode(trim($this->input->raw_input_stream),true);

		$this->pdf = new Fpdfext();

		$this->pdf->AddPage('P','A4');
		$xTotal = $this->pdf->GetPageWidth();
		$yTotal = $this->pdf->GetPageHeight();
		$margin = 5;
		$tamaño = 100;
		$this->pdf->SetMargins($margin,$margin,($xTotal/2)+$margin);
	
		$this->pdf->SetFont('Arial','',12);
		$this->pdf->Ln(10);
		$this->pdf->SetFont('Arial','B',10);
		$this->pdf->Cell(18,4,utf8_decode($this->sessionVP['empresa']),0,0,'L');
		$this->pdf->Ln(10);

		$this->pdf->Image(base_url().'/inicio/qr_code/'.$this->sessionVP['nombre_negocio'],(($xTotal-$tamaño)/2), $this->pdf->GetY(),$tamaño,$tamaño,'png');

		$arrData['message'] = 'ERROR';
		$arrData['flag'] = 0;
		$timestamp = date('YmdHis');
		if($this->pdf->Output( 'F','assets/pdfTemporales/tempPDF_'. $timestamp .'.pdf' )){
			$arrData['message'] = 'OK';
			$arrData['flag'] = 1;
		}
		$arrData = array(
			'urlTempPDF'=> base_url().'assets/pdfTemporales/tempPDF_'. $timestamp .'.pdf'
		);
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($arrData));
	}
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Fpdfext extends FPDF { 
      public function __construct() {
        parent::__construct();
      }
      public function setTituloAbr($tituloAbr){
        $this->tituloAbr = $tituloAbr;
      }
      public function getTituloAbr()
      {
        return $this->tituloAbr;
      }
      public function setTitulo($title){
        $this->title = $title;
      }
      public function getTitulo()
      {
        return $this->title;
      }
      public function setSede($sede){
        $this->sede = $sede;
      }
      public function setFirmaLaboratorio($firmaLaboratorio){
        $this->firmaLaboratorio = $firmaLaboratorio;
      }
      public function getFirmaLaboratorio(){
        return $this->firmaLaboratorio;
      }

      public function SetWidths($w)
      {
          //Set the array of column widths
          $this->widths=$w;
      }
      public function GetWidths()
      {
          //Set the array of column widths
          return $this->widths;
      }
      public function SetAligns($a)
      {
          //Set the array of column alignments
          $this->aligns=$a;
      }
      public function GetAligns()
      {
          //Set the array of column widths
          return $this->aligns;
      }

      public function Row(
        $data,
        $fill=FALSE,
        $border=0,
        $arrBolds=FALSE,
        $heigthCell=FALSE,
        $arrTextColor=FALSE,
        $arrBGColor=FALSE,
        $arrImage=FALSE,
        $bug=FALSE,
        $fontSize=FALSE)
      {
          //Calculate the height of the row
          //var_dump($heigthCell); exit();
          if(empty($fontSize)){
            $fontSize = 7;
          }
          if( empty($heigthCell) ){
            $heigthCell = 5;
          }
          $nb=0;
          for($i=0;$i<count($data);$i++)
              $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
          $h=($heigthCell)*$nb;
          //Issue a page break first if needed
          $this->CheckPageBreak($h);
          //Draw the cells of the row
          for($i=0;$i<count($data);$i++)
          {
              $w=$this->widths[$i];
              $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
              //Save the current position
              $x=$this->GetX();
              $y=$this->GetY();
              //Draw the border
              // $this->Rect($x,$y,$w,$h);
              //Print the text
              if( $arrBolds ){
                if( $arrBolds[$i] == 'B'){
                  $this->SetFont('Arial','B',$fontSize+1);
                }else{
                  $this->SetFont('Arial','',$fontSize);
                }
              }
              if( $arrTextColor ){
                if( $arrTextColor[$i] == 'red'){
                  $this->SetTextColor(225,22,22);
                }elseif( $arrTextColor[$i] == 'green'){
                  $this->SetTextColor(12,162,10);
                }else{
                  $this->SetTextColor(0);
                }
              }
              if( $arrBGColor ){
                $fill=TRUE;
                if( $arrBGColor[$i] == 'p1'){
                  $this->SetFillColor(130);
                }elseif( $arrBGColor[$i] == 'p2'){
                  $this->SetFillColor(160);
                }elseif( $arrBGColor[$i] == 'p3'){
                  $this->SetFillColor(190);
                }elseif( $arrBGColor[$i] == 'p4'){
                  $this->SetFillColor(220);
                }elseif( $arrBGColor[$i] == 'p5'){
                  $this->SetFillColor(240);
                }else{
                  $fill=FALSE;
                  $this->SetFillColor(255);
                }
              }
              $textoCell = $data[$i];
              if( !empty($arrImage[$i]) ){
                // var_dump($textoCell); exit();
                // $textoCell = $this->Image('assets/img/dinamic/empresa/'.$textoCell,2,2,50);
                //$
                if( empty($textoCell) || !file_exists('assets/img/dinamic/empleado/'.$textoCell) ){
                  $textoCell = 'noimage.jpg';
                }
                $textoCell = $this->Image('assets/img/dinamic/empleado/'.$textoCell,($x + 6),($y + 1),10,10);
                //$fill= FALSE;
              }
              // if( empty($heigthCell) ){
              //   $heigthCell = 5;
              // }
              if( !empty($fontSize) ){

              }
              $this->SetFont('Arial','',$fontSize);
              $this->MultiCell($w,$heigthCell,$textoCell,$border,$a,$fill);
              //Put the position to the right of the cell
              $this->SetXY($x+$w,($y));
              // var_dump($i);
          }// exit();
          //Go to the next line
          if($bug){
            $h = $heigthCell;
          }
          $this->Ln($h);
      }

      /* CABECERA LABORATORIO */
      public function setPaciente($paciente){
        $this->paciente = $paciente;
      }
      public function getPaciente()
      {
        return $this->paciente;
      }
      public function setFechaRecepcion($fechaRecepcion){
        $this->fechaRecepcion = $fechaRecepcion;
      }
      public function getFechaRecepcion()
      {
        return $this->fechaRecepcion;
      }
      public function setEdadPaciente($edadPaciente){
        $this->edadPaciente = $edadPaciente;
      }
      public function getEdadPaciente()
      {
        return $this->edadPaciente;
      }
      public function setSexoPaciente($sexoPaciente){
        $this->sexoPaciente = $sexoPaciente;
      }
      public function getSexoPaciente()
      {
        return $this->sexoPaciente;
      }
      public function setNumeroExamen($numeroExamen){
        $this->numeroExamen = $numeroExamen;
      }
      public function getNumeroExamen()
      {
        return $this->numeroExamen;
      }
      public function setNumeroHistoria($numeroHistoria){
        $this->numeroHistoria = $numeroHistoria;
      }
      public function getNumeroHistoria()
      {
        return $this->numeroHistoria;
      }

      public function CheckPageBreak($h)
      {
          //If the height h would cause an overflow, add a new page immediately
          if($this->GetY()+$h>$this->PageBreakTrigger)
              $this->AddPage($this->CurOrientation);
      }

      public function NbLines($w,$txt)
      {
          //Computes the number of lines a MultiCell of width w will take
          $cw=&$this->CurrentFont['cw'];
          if($w==0)
              $w=$this->w-$this->rMargin-$this->x;
          $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
          $s=str_replace("\r",'',$txt);
          $nb=strlen($s);
          if($nb>0 and $s[$nb-1]=="\n")
              $nb--;
          $sep=-1;
          $i=0;
          $j=0;
          $l=0;
          $nl=1;
          while($i<$nb)
          {
              $c=$s[$i];
              if($c=="\n")
              {
                  $i++;
                  $sep=-1;
                  $j=$i;
                  $l=0;
                  $nl++;
                  continue;
              }
              if($c==' ')
                  $sep=$i;
              $l+=$cw[$c];
              if($l>$wmax)
              {
                  if($sep==-1)
                  {
                      if($i==$j)
                          $i++;
                  }
                  else
                      $i=$sep+1;
                  $sep=-1;
                  $j=$i;
                  $l=0;
                  $nl++;
              }
              else
                  $i++;
          }
          return $nl;
      }
      
      //Page header
      public function Header(){
        $this->SetAutoPageBreak(TRUE,35);
        if( !empty($this->tituloAbr) && $this->tituloAbr  == 'LAB-RL' ){ // y_final_izquierda
          if( $this->sede == 1 ){
            $this->Image(base_url('assets/img/dinamic/email/ves.jpg'),'0','0','200','300','JPG');
          }elseif( $this->sede == 3 ){
            $this->Image(base_url('assets/img/dinamic/email/lurin.jpg'),'0','0','200','300','JPG');
          }elseif( $this->sede == 4 ){
            $this->Image(base_url('assets/img/dinamic/email/sjl.jpg'),'0','0','200','300','JPG');
          }else{
            // $this->Image(base_url('assets/img/dinamic/email/ves.jpg'),'0','0','200','300','JPG');

          }
          $this->SetFillColor(234,236,239);
          $this->SetMargins(8,8,6);
          $this->Ln(28);
          $this->SetFont('Arial','B',10);
          $this->Cell(30,6,'NOMBRES: ','LT','','',1);
          $this->Cell(100,6,strtoupper($this->getPaciente()),'T','','',1);
          $this->SetFont('Arial','B',10);
          $this->Cell(18,6,'FECHA: ','T','','',1);
          $this->SetFont('Arial','',10);
          $this->Cell( 33,6,$this->getFechaRecepcion() ,'T','','',1);
          $this->SetFont('Arial','I',8);
          $this->Cell( 15,6,'Pag. '.$this->PageNo().'/{nb}' ,'TR','','C',1);
          $this->Ln();
          $this->SetFont('Arial','B',10);
          $this->Cell(30,6,'EDAD: ','L','','',1);
          $this->SetFont('Arial','',10);
          $this->Cell(30,6,@utf8_decode($this->getEdadPaciente()),'','','',1);
          $this->SetFont('Arial','B',10);
          $this->Cell(15,6,'SEXO: ','','','',1);
          $this->SetFont('Arial','',10);
          $this->Cell(55,6,$this->getSexoPaciente(),'','','',1);
          $this->SetFont('Arial','B',10);
          $this->Cell(18,6,utf8_decode('Nº EXA.: '),'','','',1);
          $this->SetFont('Arial','',10);
          $this->Cell(48,6,$this->getNumeroExamen(),'R','','',1);
          $this->Ln();
          $this->SetFont('Arial','B',10);
          $this->Cell(130,6,'MEDICO: ','L','','',1);
          $this->SetFont('Arial','B',10);
          $this->Cell(18,6,utf8_decode('H.C.: '),'','','',1);
          $this->SetFont('Arial','',10);
          $this->Cell(48,6,$this->getNumeroHistoria(),'R','','',1);
          //$this->Cell(40,6,'');
          $this->Ln();
          $this->SetFont('Arial','B',10);
          $this->Cell(30,6,'PROCEDENCIA: ','LB','','',1);
          $this->SetFont('Arial','',10);
          $this->Cell(100,6,'HOSPITAL VILLA SALUD','B','','',1);
          $this->SetFont('Arial','B',10);
          $this->Cell(18,6,utf8_decode('F. IMP.:'),'B','','',1);
          $this->SetFont('Arial','',10);
          $this->Cell(48,6,strtoupper(date('d/m/Y     H:i:s a')),'BR','','',1);
          $this->Ln(8);
          $arrAligns = array('L', 'L', 'L', 'L');
          $arrAlignsHeader = array('C', 'L', 'L', 'L');
          $this->SetWidths(array(58, 56, 57, 25));
          $this->SetAligns($arrAligns);
          $wDetalle = $this->GetWidths();
          $headerDetalle = array(
                'EXAMEN',
                'RESULTADO',
                'VALOR NORMAL',
                'METODO'
          );
          $this->SetFont('Arial','B',8);
          $this->Cell(0,0,'','B');
          $this->Ln();
          $cantHeaderDetalle = count($headerDetalle);
          for($i=0;$i<$cantHeaderDetalle;$i++){
            $bordeHeader = '';
            if($i == 3){
              $bordeHeader = 'R';
            }
            if($i == 0){
              $bordeHeader = 'L';
            }
            // $this->SetFillColor(214,225,242);

            $this->Cell($wDetalle[$i],7,$headerDetalle[$i],$bordeHeader,0,$arrAlignsHeader[$i],1);
          }
          $this->Ln();
          $this->Cell(0,0,'','T');
          $this->Ln(2);
        }
      }
      public function Footer(){
        if( !empty($this->tituloAbr) && $this->tituloAbr  == 'LAB-RL' ){
          // $this->SetY(-54);
          $getFirmaLaboratorio = $this->getFirmaLaboratorio();
          if( !empty($getFirmaLaboratorio) ){
            // $this->Cell(62,10,$this->Image($this->getFirmaLaboratorio(),168,260,45,39),0,0,'C');
            $this->Cell(62,10,$this->Image($this->getFirmaLaboratorio(),115,240,40,34),0,0,'C');
          }
        }
      }     


      /**
       * MultiCell alineado como un CELL, uno al lado del otro.
       * Retorna el numero de lineas que produjo el multicell
       *
       * @Creado: 14/03/2019
       * @author Ing. Ruben Guevara <rguevarac@hotmail.es>
       * @param float $w <WIDTH>
       * @param float $h <HEIGHT>
       * @param string $txt <TEXTO>
       * @param mixed $border <SI BORDER>
       * @param int $ln <SI SALTO DE LINEA>
       * @param string $align 
       * @param boolean $fill 
       * @return int $nl <numero de lineas del multicell>
       */
      public function MultiAlignCell($w, $h, $txt, $border=0, $ln=0, $align='J', $fill=false) 
      { 
          // Store reset values for (x,y) positions 
          $x = $this->GetX() + $w; 
          $y = $this->GetY(); 

          // Make a call to FPDF's MultiCell 
          // Output text with automatic or explicit line breaks
          if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
          $cw = &$this->CurrentFont['cw'];
          if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
          $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
          $s = str_replace("\r",'',$txt);
          $nb = strlen($s);
          $num_lineas = $nb;
          if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
          $b = 0;
          if($border)
          {
            if($border==1)
            {
              $border = 'LTRB';
              $b = 'LRT';
              $b2 = 'LR';
            }
            else
            {
              $b2 = '';
              if(strpos($border,'L')!==false)
                $b2 .= 'L';
              if(strpos($border,'R')!==false)
                $b2 .= 'R';
              $b = (strpos($border,'T')!==false) ? $b2.'T' : $b2;
            }
          }
          $sep = -1;
          $i = 0;
          $j = 0;
          $l = 0;
          $ns = 0;
          $nl = 1;
          while($i<$nb)
          {
            // Get next character
            $c = $s[$i];
            if($c=="\n")
            {
              // Explicit line break
              if($this->ws>0)
              {
                $this->ws = 0;
                $this->_out('0 Tw');
              }
              $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
              $i++;
              $sep = -1;
              $j = $i;
              $l = 0;
              $ns = 0;
              $nl++;
              if($border && $nl==2)
                $b = $b2;
              continue;
            }
            if($c==' ')
            {
              $sep = $i;
              $ls = $l;
              $ns++;
            }
            $l += $cw[$c];
            if($l>$wmax)
            {
              // Automatic line break
              if($sep==-1)
              {
                if($i==$j)
                  $i++;
                if($this->ws>0)
                {
                  $this->ws = 0;
                  $this->_out('0 Tw');
                }
                $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
              }
              else
              {
                if($align=='J')
                {
                  $this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                  $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                }
                $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                $i = $sep+1;
              }
              $sep = -1;
              $j = $i;
              $l = 0;
              $ns = 0;
              $nl++;
              if($border && $nl==2)
                $b = $b2;
            }
            else
              $i++;
          }
          // Last chunk
          if($this->ws>0)
          {
            $this->ws = 0;
            $this->_out('0 Tw');
          }
          if($border && strpos($border,'B')!==false)
            $b .= 'B';
          $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
          $this->x = $this->lMargin;

          // Reset the line position to the right, like in Cell 
          if($ln==0) 
          { 
            $this->SetXY($x,$y); 
          }
        return $nl;
      } 
    }

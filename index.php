<?php require 'views/header.php'; ?>
<?php	

require 'config/config.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $cedula = $_POST['cedula'];
    $cedula = limpiarDatos($cedula);

     $errores = '';

    if(empty($cedula)) {
         $errores .= '<li>Por Favor rellena todos los Datos Correctamente</li>';
     }

          $conexion = conexion($bd_config);
        if(!$conexion) {
    header('Location:error.php');
    }

    $statement = $conexion->prepare('SELECT * FROM web WHERE Cedula = :cedula ORDER BY FechaCambio ASC');
    $statement->execute(array(':cedula'=>$cedula));
     
    $resultado = $statement->fetchAll();

   ?>

<?php
include_once('fpdf/fpdf.php'); 
class PDF extends FPDF 
{ 
function header() 
{ 
$this->Image('img/logomini.png',16,8,33); 
$this->Image('img/logomini.png',245,8,33); 		
$this->SetFont('Arial','',14); 
$this->SetTextColor(0,0,0);
$this->Cell(50); 
$this->Cell(160,5,'Informe de Consulta Estatus de Servicio',0,0,'C'); 
$this->Ln(); 
$this->Cell(255,5,'Cedula de Cliente:  '.$_POST['cedula'],0,0,'C'); 
$this->Ln(15); 

} 
function Footer() 
{ 
$this->SetY(-15); 

$this->SetTextColor(0,0,0);
$this->SetFont('Arial','',10); 
$this->Cell(283,6,'Page '.$this->PageNo().'/{nb}',0,0,'C'); 
$this->Ln(); 
$this->Cell(0,6,date('d/m/Y'),0,1,'C'); 
} 
} 
$pdf=new PDF('L'); 
$pdf->SetFont('Arial','',10); 
$pdf->AliasNbPages(); 
$pdf->AddPage(); 
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(28,8,'Solicitud',1,0,'C'); 
$pdf->Cell(31,8,'Serial',1,0,'C'); 
$pdf->Cell(26,8,'Marca',1,0,'C'); 
$pdf->Cell(26,8,'Modelo',1,0,'C'); 
$pdf->Cell(26,8,'Estatus',1,0,'C'); 
$pdf->Cell(51,8,'Departamento',1,0,'C'); 
$pdf->Cell(39,8,'Fecha de Cambio',1,0,'C'); 
$pdf->Cell(39,8,'Hora de Cambio',1,0,'C'); 
$pdf->Ln(); 
foreach ($resultado as $consulta) {
	$IDepartamento = $consulta["IdDepartamento"];
	$IdEstado = $consulta["IdEstado"];
		if ($IdEstado=="Recibida")
		{
$pdf->SetFont('Arial','',10); 
$pdf->SetTextColor(255,255,255);
$pdf->SetDrawColor(0,0,0);
$pdf->SetFillColor(227,142,21);
$pdf->Cell(28,6,$consulta["IdSolicitud"],1,0,'C','true'); 
$pdf->Cell(31,6,$consulta["Serial"],1,0,'C','true'); 
$pdf->Cell(26,6,$consulta["Marca"],1,0,'C','true'); 
$pdf->Cell(26,6,$consulta["Modelo"],1,0,'C','true'); 
$pdf->Cell(26,6,$consulta["IdEstado"],1,0,'C','true'); 
$pdf->Cell(51,6,$consulta["IdDepartamento"],1,0,'C','true'); 
$pdf->Cell(39,6,$consulta["FechaCambio"],1,0,'C','true'); 
$pdf->Cell(39,6,$consulta["HoraCambio"],1,0,'C','true');
$pdf->Ln();  
		}
		if ($IdEstado=="Asignada")
		{
$pdf->SetFont('Arial','',10); 
$pdf->SetTextColor(255,255,255);
$pdf->SetDrawColor(0,0,0);
$pdf->SetFillColor(14,125,30);
$pdf->Cell(28,6,$consulta["IdSolicitud"],1,0,'C','true'); 
$pdf->Cell(31,6,$consulta["Serial"],1,0,'C','true'); 
$pdf->Cell(26,6,$consulta["Marca"],1,0,'C','true'); 
$pdf->Cell(26,6,$consulta["Modelo"],1,0,'C','true'); 
$pdf->Cell(26,6,$consulta["IdEstado"],1,0,'C','true'); 
$pdf->Cell(51,6,$consulta["IdDepartamento"],1,0,'C','true'); 
$pdf->Cell(39,6,$consulta["FechaCambio"],1,0,'C','true'); 
$pdf->Cell(39,6,$consulta["HoraCambio"],1,0,'C','true'); 
$pdf->Ln(); 
		}
		if ($IdEstado=="Reparada")
		{
$pdf->SetFont('Arial','',10); 
$pdf->SetTextColor(255,255,255);
$pdf->SetDrawColor(0,0,0);
$pdf->SetFillColor(21,43,171);
$pdf->Cell(28,6,$consulta["IdSolicitud"],1,0,'C','true'); 
$pdf->Cell(31,6,$consulta["Serial"],1,0,'C','true'); 
$pdf->Cell(26,6,$consulta["Marca"],1,0,'C','true'); 
$pdf->Cell(26,6,$consulta["Modelo"],1,0,'C','true'); 
$pdf->Cell(26,6,$consulta["IdEstado"],1,0,'C','true'); 
$pdf->Cell(51,6,$consulta["IdDepartamento"],1,0,'C','true'); 
$pdf->Cell(39,6,$consulta["FechaCambio"],1,0,'C','true'); 
$pdf->Cell(39,6,$consulta["HoraCambio"],1,0,'C','true'); 
$pdf->Ln(); 
		}
		if ($IdEstado=="Ha Salido" and $IDepartamento=="Entrega de Equipos")
		{
$pdf->SetFont('Arial','',10); 
$pdf->SetTextColor(255,255,255);
$pdf->SetDrawColor(0,0,0);
$pdf->SetFillColor(122,37,11);
$pdf->Cell(28,6,$consulta["IdSolicitud"],1,0,'C','true'); 
$pdf->Cell(31,6,$consulta["Serial"],1,0,'C','true'); 
$pdf->Cell(26,6,$consulta["Marca"],1,0,'C','true'); 
$pdf->Cell(26,6,$consulta["Modelo"],1,0,'C','true'); 
$pdf->Cell(26,6,$consulta["IdEstado"],1,0,'C','true'); 
$pdf->Cell(51,6,$consulta["IdDepartamento"],1,0,'C','true'); 
$pdf->Cell(39,6,$consulta["FechaCambio"],1,0,'C','true'); 
$pdf->Cell(39,6,$consulta["HoraCambio"],1,0,'C','true'); 
$pdf->Ln(); 
		}
} 
$pdf->Output(); 

?>

 

<?php

    }else {
        $error =" Hubo un error en la Consulta";
    }


require 'views/index.view.php';


?>


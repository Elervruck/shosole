<?php
// Se incluye la clase para generar archivos PDF
require_once('../lib/fpdf185/fpdf.php');


class Report extends FPDF
{
    const CLIENTE_URL = 'https://localhost/shosole/views/dashboard/';

    private $title = null;

    public function startReport($title){
        ini_set('date.timezone', 'America/El_Salvador');
        session_start();

        if(isset($_SESSION['id_usuario'])){
            $this->title = $title;
            $this->setTitle('Dashoard - Report', true);
            $this->setMargins(15, 15, 15);
            $this->addPage('p', 'letter');
            $this->aliasNbPages();
        } else {
            header('location:' . self::CLIENTE_URL);
        }
    }    

    public function encodeString($string)
    {
        return mb_convert_encoding($string, 'ISO-8859-1', 'utf-8');
    }

    public function header()
    {
        // Se establece el logo.
        $this->image('../../resources/img/logo_login.png', 15, 15, 20);
        // Se ubica el título.
        $this->cell(20);
        $this->setFont('Arial', 'B', 15);
        $this->cell(166, 10, $this->encodeString($this->title), 0, 1, 'C');
        // Se ubica la fecha y hora del servidor.
        $this->cell(20);
        $this->setFont('Arial', '', 10);
        $this->cell(166, 10, 'Fecha/Hora: ' . date('d-m-Y H:i:s'), 0, 1, 'C');
        // Se agrega un salto de línea para mostrar el contenido principal del documento.
        $this->ln(10);
    }

    public function footer()
    {
        // Se establece la posición para el número de página (a 15 milímetros del final).
        $this->setY(-15);
        // Se establece la fuente para el número de página.
        $this->setFont('Arial', 'I', 8);
        // Se imprime una celda con el número de página.
        $this->cell(0, 10, $this->encodeString('Página ') . $this->pageNo() . '/{nb}', 0, 0, 'C');
    }
}
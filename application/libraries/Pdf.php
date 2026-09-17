<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf
{
    private function tcpdf()
    {
        $path = '/Applications/XAMPP/xamppfiles/phpmyadmin/vendor/tecnickcom/tcpdf/tcpdf.php';
        if (!is_file($path)) show_error('Library PDF TCPDF tidak ditemukan pada instalasi XAMPP.', 500);
        require_once $path;
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Eni Muara Bakau');
        $pdf->SetTitle('Timesheet');
        $pdf->SetMargins(14, 12, 14);
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetFont('helvetica', '', 10);
        return $pdf;
    }

    public function timesheet($employee, $activities, $filters, $filename)
    {
        $pdf = $this->tcpdf();
        $pdf->AddPage();
        $left = 14; $right = 196; $width = 182;
        $pdf->Image(FCPATH . 'assets/images/pdf-template/id-survey.jpg', $left, 14, 48, 14, 'JPG');
        $pdf->Image(FCPATH . 'assets/images/pdf-template/surveyor-indonesia.jpg', 163, 10, 30, 23, 'JPG');

        $pdf->SetY(38);
        $pdf->SetFont('helvetica', '', 14);
        $pdf->Cell($width, 7, 'TIMESHEET', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->MultiCell($width, 11, "Provision of QHSSE Management System and Contractor HSE Management System Services\nEni Muara Bakau B.V.", 0, 'C', false, 1);

        $pdf->Ln(7);
        $identity = array(
            array('Employee Name', $employee['nama']),
            array('Position', $employee['jabatan']),
            array('Period', date('d/m/Y', strtotime($filters['start'])) . ' until ' . date('d/m/Y', strtotime($filters['end'])))
        );
        foreach ($identity as $row) {
            $pdf->Cell(50, 5, $row[0], 0, 0);
            $pdf->Cell(5, 5, ':', 0, 0, 'C');
            $pdf->Cell(127, 5, $row[1], 0, 1);
        }

        $pdf->Ln(9);
        $this->table_header($pdf);
        if (!$activities) {
            $pdf->Cell(182, 8, 'No approved activities within this period.', 1, 1, 'C');
        }
        foreach ($activities as $activity) {
            $date = date('d-m-Y', strtotime($activity['tanggal']));
            $status = $activity['jenis'];
            $text = '- ' . str_replace("\n", "\n- ", $activity['kegiatan']);
            $height = max(10, $pdf->getStringHeight(88, $text) + 3);
            if ($pdf->GetY() + $height > 255) {
                $pdf->AddPage();
                $this->table_header($pdf);
            }
            $y = $pdf->GetY();
            $pdf->MultiCell(44, $height, $date, 1, 'C', false, 0, $left, $y, true, 0, false, true, $height, 'M');
            $pdf->MultiCell(44, $height, $status, 1, 'C', false, 0, $left + 44, $y, true, 0, false, true, $height, 'M');
            $pdf->MultiCell(94, $height, $text, 1, 'L', false, 1, $left + 88, $y, true, 0, false, true, $height, 'T');
        }

        $signature_y = max($pdf->GetY() + 26, 242);
        if ($signature_y > 267) { $pdf->AddPage(); $signature_y = 245; }
        $pdf->SetXY($left, $signature_y);
        $pdf->Cell(91, 5, 'Employee,', 0, 0, 'C');
        $pdf->Cell(91, 5, 'Mengetahui,', 0, 1, 'C');
        $pdf->Rect(31, $signature_y + 12, 33, 33);
        $pdf->Rect(146, $signature_y + 12, 33, 33);
        $pdf->Output($filename, 'D');
    }

    private function table_header($pdf)
    {
        $pdf->SetFont('helvetica', '', 11);
        $pdf->Cell(44, 8, 'DATE', 1, 0, 'C');
        $pdf->Cell(44, 8, 'STATUS', 1, 0, 'C');
        $pdf->Cell(94, 8, 'ACTIVITY', 1, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
    }
}

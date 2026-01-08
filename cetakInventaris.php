<?php
require 'koneksi.php';
require __DIR__ . '/fpdf186/fpdf.php'; 

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'LAPORAN INVENTARIS LABORATORIUM', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Data Aset Komputer & Peralatan', 0, 1, 'C');
        $this->Ln(10); // Jarak setelah header
        
        // Header Tabel 
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(230, 230, 230);
        $this->Cell(10, 10, 'NO', 1, 0, 'C', true);
        $this->Cell(35, 10, 'KODE', 1, 0, 'C', true);
        $this->Cell(60, 10, 'NAMA BARANG', 1, 0, 'C', true);
        $this->Cell(30, 10, 'KATEGORI', 1, 0, 'C', true);
        $this->Cell(30, 10, 'TGL BELI', 1, 0, 'C', true);
        $this->Cell(30, 10, 'KONDISI', 1, 0, 'C', true);
        $this->Cell(80, 10, 'DESKRIPSI', 1, 1, 'C', true);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . ' - LabTrack System', 0, 0, 'C');
    }

    // --- MENGHITUNG JUMLAH BARIS SECARA AKURAT ---
    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++; $sep = -1; $j = $i; $l = 0; $nl++;
                continue;
            }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) $i++;
                } else $i = $sep + 1;
                $sep = -1; $j = $i; $l = 0; $nl++;
            } else $i++;
        }
        return $nl;
    }
}

$sql = "SELECT * FROM barang ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$pdf = new PDF('L', 'mm', 'A4'); 
$pdf->SetAutoPageBreak(false); 
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$no = 1;
$lebar_deskripsi = 80;

while ($row = mysqli_fetch_assoc($result)) {
    $deskripsi = $row['deskripsi'];
    
    $jumlah_baris = $pdf->NbLines($lebar_deskripsi, $deskripsi);
    
    $h = 5 * $jumlah_baris;
    
    if($h < 10) $h = 10;

    if ($pdf->GetY() + $h > 180) {
        $pdf->AddPage(); 
    }

    $pdf->Cell(10, $h, $no++, 1, 0, 'C');
    $pdf->Cell(35, $h, $row['kode_barang'], 1, 0);
    $pdf->Cell(60, $h, substr($row['nama_barang'], 0, 35), 1, 0); // Potong nama jika kepanjangan
    $pdf->Cell(30, $h, $row['kategori'], 1, 0);
    $pdf->Cell(30, $h, $row['tgl_beli'], 1, 0, 'C');
    $pdf->Cell(30, $h, $row['kondisi'], 1, 0);
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    
    $pdf->Rect($x, $y, $lebar_deskripsi, $h);
    $pdf->MultiCell($lebar_deskripsi, 5, $deskripsi, 0, 'L');
    $pdf->SetXY(10, $y + $h);
}

$pdf->Output();
?>
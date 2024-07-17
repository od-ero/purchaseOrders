<?php

namespace App;

use setasign\Fpdi\Fpdi;
use Carbon\Carbon;
class OrderPDF
{
    /**
     * Create a new class instance.
     */
    // public $pDFDatas;
    // public function __construct($pDFDatas)
    // {
    //     $this->$pDFDatas = $pDFDatas; 
    // }

    public  static function createPDF($pDFDatas, $batch_details)
    {
       
        $pdf = new Fpdi();

        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(0, 10, 'Products Data', 0, 1, 'C');
        $pdf->Ln(10);
        $yPos = $pdf->GetY();
        $xPos = $pdf->GetX();
        $pdf->MultiCell(90, 5,'Supplier :'. $batch_details['supplier_name'], 0, 'L');
        $pdf->SetXY($xPos + 130, $yPos);
        $pdf->MultiCell(60, 5,'Order Number: '. $batch_details['order_no'], 0, 'R');
        $pdf->Ln(10);
        $pdf->SetFont('Times', 'B', 12);
        $cellHeight = 15; 
        $yPos = $pdf->GetY();
        $xPos = $pdf->GetX();
        $pdf->Cell(15, $cellHeight, '#', 1, 0, 'C', 0);
        $pdf->Cell(30, $cellHeight, 'Quantity', 1, 0, 'C', 0);
        $pdf->Cell(70, $cellHeight, 'Product Name', 1, 0, 'C', 0);
        $pdf->MultiCell(40, $cellHeight, "Price per quantity", 1, 'C');
        $pdf->SetXY($xPos + 155, $yPos);
        $pdf->Cell(35, $cellHeight, 'Sub total', 1, 0, 'C', 0);

        $pdf->Ln($cellHeight); 
      
        $counter = 1;
        $total = 0;
        $product_name_cell_width = 70;
        $lineHeight = 10; 


        $pdf->SetFont('Times', '', 12);
        foreach ($pDFDatas as $product) {
            $product_name_length = max(1, ceil($pdf->GetStringWidth($product['product_name']) / $product_name_cell_width));
            
                $adjustedCellHeight = $product_name_length * $lineHeight;
                $product_name_cell_heigth = $lineHeight;
            $xPos = $pdf->GetX();
            $yPos = $pdf->GetY();
            
            $pdf->Cell(15, $adjustedCellHeight, $counter, 1, 0, 'C');
            $pdf->Cell(30, $adjustedCellHeight, $product['quantity'], 1, 0, 'C');
            $pdf->MultiCell(70, $product_name_cell_heigth, $product['product_name'], 1,'L');
            
            $pdf->SetXY($xPos + 115, $yPos); 
           
            $pdf->Cell(40, $adjustedCellHeight, number_format($product['price_quantity'], 2), 1, 0, 'R');
        
           
            $pdf->Cell(35, $adjustedCellHeight, number_format($product['quantity'] * $product['price_quantity'], 2), 1, 0, 'R');
        
           
            $pdf->Ln($adjustedCellHeight);
        
            $counter++;
            $total += $product['quantity'] * $product['price_quantity'];
        }
        

        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(115, 15, '', 0);
        $pdf->Cell(40, 15, 'Total (Kshs)', 1);
        $pdf->Cell(35, 15, number_format($total, 2), 1, 0, 'R');
        $pdf->Ln();
        
        $pdf->Ln(10);

       
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(0, 10, 'Official Stamp And Signature', 0, 1, 'L');

       
        $stampPath = public_path('images/stamp.png');
        $pdf->Image($stampPath, 10, $pdf->GetY(), 50); 

       
        $signaturePath = public_path('images/signature.png'); 
        $pdf->Image($signaturePath, 15, $pdf->GetY()+5, 40);
        
        $pdf->SetY($pdf->GetY() + 30); 
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0, 10, 'Date: ' . Carbon::now()->toFormattedDateString(), 0, 1, 'L');

        $pdfContent = $pdf->Output('S');
       
        return base64_encode($pdfContent);
       
        
    }


}

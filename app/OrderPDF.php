<?php

namespace App;

use setasign\Fpdi\Fpdi;
use Carbon\Carbon;

use App\Models\BusinessDetail;
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
        $business_details = BusinessDetail::find(1);
        $pdf = new Fpdi();

        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 10,  $business_details['company_name'], 0, 1, 'C',0);
        //$pdf->Ln(10);
        $pdf->SetFont('Times', '', 13);
        $pdf->Cell(0,8, $business_details['head_1'], 0, 1, 'C',0);
        //$pdf->Ln(10);
        $pdf->SetFont('Times', '', 13);
        $pdf->Cell(0, 8, $business_details['head_2'], 0, 1, 'C',0);
       // $pdf->Ln(10);
        $pdf->SetFont('Times', '', 13);
        $pdf->Cell(0, 8, $business_details['head_3'], 0, 1, 'C',0);
        $pdf->SetFont('Times', '', 13);
         $pdf->Cell(0, 8, 'Pin:  ' .$business_details['kra_pin'], 0, 1, 'C',0);
        //$pdf->Ln(10);
        $yPos = $pdf->GetY();
        $xPos = $pdf->GetX();
        $supLength = 140;
         $pdf->Line($xPos, $yPos,  $xPos+190, $yPos);
       //  $pdf->Rect($xPos, $yPos+2,  $xPos + $supLength, 30 , 'D');
        $pdf->SetFont('Times', '', 10);
        $pdf->SetXY($xPos, $yPos+5);
        $pdf->MultiCell($supLength+10, 5, $batch_details['supplier_name'], 0, 'L');
        $pdf->SetXY($xPos, $yPos+12);
        $pdf->MultiCell($supLength, 5,'Supplier Code: '. $batch_details['supplier_number'], 0, 'L');
        $pdf->SetXY($xPos, $yPos+18);
        $pdf->MultiCell($supLength, 5, 'Phone: ' .$batch_details['supplier_phone'], 0, 'L');
        $pdf->SetXY($xPos, $yPos+24);
        $pdf->MultiCell($supLength, 5, 'Pin: ' .$batch_details['supplier_kra_pin'], 0, 'L');
        $ordersXpos= $xPos + 140;
       // $pdf->Rect($ordersXpos, $yPos+2, 50, 30 , 'D');
        $pdf->SetXY($ordersXpos, $yPos+8);
        $pdf->MultiCell(50, 5,'Order No: '. $batch_details['order_no'], 0, 'R');
        $pdf->SetXY($ordersXpos, $yPos+16);
        $pdf->MultiCell(50, 5,'Date : ' .Carbon::parse($batch_details['created_at'])->isoFormat('DD/MM/YYYY HH:mm'), 0, 'R');
        $pdf->SetXY($ordersXpos, $yPos+24);
        $pdf->MultiCell(50, 5,'Printed At: '. Carbon::now()->isoFormat('DD/MM/YYYY HH:mm'), 0, 'R');
        $pdf->SetXY($xPos, $yPos+35);
        $pdf->SetFont('Times', 'B', 10);
        $cellHeight = 8; 
        $yPos = $pdf->GetY();
        $xPos = $pdf->GetX();
        $pdf->Cell(15, $cellHeight, '#', 'TLB', 0, 'C', 0);
        $pdf->Cell(105, $cellHeight, 'Product Name', 'TLB', 0, 'C', 0);
        $pdf->Cell(20, $cellHeight, 'Quantity', 'TLB', 0, 'C', 0);
        $pdf->Cell(25, $cellHeight, "Price", 'TLB', 0, 'C', 0);
        $pdf->Cell(25, $cellHeight, 'Sub total', 1,1, 'C', 0);
      
        $counter = 1;
        $total = 0;
        $product_name_cell_width = 105;
        $lineHeight = 6; 


        $pdf->SetFont('Times', '', 8);
        foreach ($pDFDatas as $product) {
            // Track the current page number
            $currentPage = $pdf->PageNo();
        
            // Calculate the required cell height
            $product_name_length = max(1, ceil($pdf->GetStringWidth($product['product_name']) / $product_name_cell_width));
            $adjustedCellHeight = $product_name_length * $lineHeight;
        
            // Check if a new page has been added after setting the cell heights
            $pdf->Cell(15, $adjustedCellHeight, $counter, 'LB', 0, 'C');
            $pdf->Cell(105, $adjustedCellHeight, ' ' . $product['product_name'], 'LB', 0, 'L');
            $pdf->Cell(20, $adjustedCellHeight, ' ' . $product['quantity'], 'LB', 0, 'L');
            $pdf->Cell(25, $adjustedCellHeight, number_format($product['price_quantity'], 0) . ' ', 'LB', 0, 'R');
            $pdf->Cell(25, $adjustedCellHeight, number_format($product['quantity'] * $product['price_quantity'], 0), 'LBR', 0, 'R');
        
            // Move to the next line
            $pdf->Ln($adjustedCellHeight);
        
            // Check if a new page has been created after writing the row
            if ($pdf->PageNo() > $currentPage) {
                $yPos = $pdf->GetY();
            $xPos = $pdf->GetX();
           
            $pdf->Line($xPos, $yPos - $adjustedCellHeight,  $xPos+190, $yPos - $adjustedCellHeight);
            }
        
            $counter++;
            $total += $product['quantity'] * $product['price_quantity'];
        }
        

        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(140, 8, '', 0);
        $pdf->Cell(25, 8, 'Total (Kshs)', 'LB');
        $pdf->Cell(25, 8, number_format($total, 0), 'LBR', 0, 'R');
       
        
        $pdf->Ln(8);

       
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(0, 10, 'Stamp / Signature:', 0, 1, 'L');

       
        $stampPath = public_path('images/scanned_stamp.png');
        $pdf->Image($stampPath, 10, $pdf->GetY(), 50); 

       
        $signaturePath = public_path('images/scanned_signature.png'); 
        $pdf->Image($signaturePath, 60, $pdf->GetY(), 20);
        
        $pdf->SetY($pdf->GetY() + 23); 
        $pdf->SetFont('Times', '', 10);
       // $current_date =  Carbon::now()->isoFormat('ddd MMM Do YYYY h:mm a');
        $pdf->Cell(0, 10, $business_details['signatory_name'], 0, 1, 'L');

        $pdfContent = $pdf->Output('S');
       
        return $pdfContent;
       
        
    }
    

    public  static function noCostPDF($pDFDatas, $batch_details)
    {
       
        $business_details = BusinessDetail::find(1);
        $pdf = new Fpdi();

        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 10,  $business_details['company_name'], 0, 1, 'C',0);
        //$pdf->Ln(10);
        $pdf->SetFont('Times', '', 13);
        $pdf->Cell(0,8, $business_details['head_1'], 0, 1, 'C',0);
        //$pdf->Ln(10);
        $pdf->SetFont('Times', '', 13);
        $pdf->Cell(0, 8, $business_details['head_2'], 0, 1, 'C',0);
       // $pdf->Ln(10);
        $pdf->SetFont('Times', '', 13);
        $pdf->Cell(0, 8, $business_details['head_3'], 0, 1, 'C',0);
        $pdf->SetFont('Times', '', 13);
         $pdf->Cell(0, 8, 'Pin:  ' .$business_details['kra_pin'], 0, 1, 'C',0);
        //$pdf->Ln(10);
        $yPos = $pdf->GetY();
        $xPos = $pdf->GetX();
        $supLength = 140;
         $pdf->Line($xPos, $yPos,  $xPos+190, $yPos);
       //  $pdf->Rect($xPos, $yPos+2,  $xPos + $supLength, 30 , 'D');
        $pdf->SetFont('Times', '', 10);
        $pdf->SetXY($xPos, $yPos+5);
        $pdf->MultiCell($supLength+10, 5, $batch_details['supplier_name'], 0, 'L');
        $pdf->SetXY($xPos, $yPos+12);
        $pdf->MultiCell($supLength, 5,'Supplier Code: '. $batch_details['supplier_number'], 0, 'L');
        $pdf->SetXY($xPos, $yPos+18);
        $pdf->MultiCell($supLength, 5, 'Phone: ' .$batch_details['supplier_phone'], 0, 'L');
        $pdf->SetXY($xPos, $yPos+24);
        $pdf->MultiCell($supLength, 5, 'Pin: ' .$batch_details['supplier_kra_pin'], 0, 'L');
        $ordersXpos= $xPos + 140;
       // $pdf->Rect($ordersXpos, $yPos+2, 50, 30 , 'D');
        $pdf->SetXY($ordersXpos, $yPos+8);
        $pdf->MultiCell(50, 5,'Order No: '. $batch_details['order_no'], 0, 'R');
        $pdf->SetXY($ordersXpos, $yPos+16);
        $pdf->MultiCell(50, 5,'Date : ' .Carbon::parse($batch_details['created_at'])->isoFormat('DD/MM/YYYY HH:mm'), 0, 'R');
        $pdf->SetXY($ordersXpos, $yPos+24);
        $pdf->MultiCell(50, 5,'Printed At: '. Carbon::now()->isoFormat('DD/MM/YYYY HH:mm'), 0, 'R');
        $pdf->SetXY($xPos, $yPos+35);
        $pdf->SetFont('Times', 'B', 10);
        $cellHeight = 8; 
        $yPos = $pdf->GetY();
        $xPos = $pdf->GetX();
        $pdf->Cell(20, $cellHeight, '#', 'TLB', 0, 'C', 0);
        $pdf->Cell(140, $cellHeight, 'Product Name', 'TLB', 0, 'C', 0);
        $pdf->Cell(30, $cellHeight, 'Quantity',1, 1, 'C', 0);
        $counter = 1;
        $total = 0;
        $product_name_cell_width = 140;
        $lineHeight = 6; 


        $pdf->SetFont('Times', '', 8);
        foreach ($pDFDatas as $product) {
            $currentPage = $pdf->PageNo();
            $product_name_length = max(1, ceil($pdf->GetStringWidth($product['product_name']) / $product_name_cell_width));
            
            $adjustedCellHeight = $product_name_length * $lineHeight;
            $product_name_cell_heigth = $lineHeight;

            $xPos = $pdf->GetX();
            $yPos = $pdf->GetY();
            
            $pdf->Cell(20, $adjustedCellHeight, $counter, 'LB', 0, 'C');
             $pdf->Cell(140, $adjustedCellHeight, ' ' . $product['product_name'], 'LB', 0, 'L');
            
            $pdf->Cell(30, $adjustedCellHeight,' '.  $product['quantity'], 'LBR', 0, 'L');
        
           
            $pdf->Ln($adjustedCellHeight);
            if ($pdf->PageNo() > $currentPage) {
                $yPos = $pdf->GetY();
            $xPos = $pdf->GetX();
           
            $pdf->Line($xPos, $yPos - $adjustedCellHeight,  $xPos+190, $yPos - $adjustedCellHeight);
            }
        
            $counter++;
        }
        

        
        
        $pdf->Ln(10);

       
        $pdf->SetFont('Times', 'B', 10);
        $pdf->Cell(0, 10, 'Stamp / Signature:', 0, 1, 'L');

       
        $stampPath = public_path('images/scanned_stamp.png');
        $pdf->Image($stampPath, 10, $pdf->GetY(), 50); 

       
        $signaturePath = public_path('images/scanned_signature.png'); 
        $pdf->Image($signaturePath, 60, $pdf->GetY(), 20);
        
        $pdf->SetY($pdf->GetY() + 23); 
        $pdf->SetFont('Times', '', 10);
       // $current_date =  Carbon::now()->isoFormat('ddd MMM Do YYYY h:mm a');
        $pdf->Cell(0, 10, $business_details['signatory_name'], 0, 1, 'L');

        $pdfContent = $pdf->Output('S');
       
        return $pdfContent;
       
       
    }


}

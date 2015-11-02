<?php
header("Content-type: application/vnd.ms-excel"); 
header('Content-Disposition: attachment; filename="PgeFaktury' . date('Y-m-d_H_i_s') . '.xml"');
header('Cache-Control: max-age=0');
//$this->response->type('application/vnd.ms-excel');
header('Cache-control: no-cache, pre-check=0, post-check=0');
header('Cache-control: private');
header('Pragma: private');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // any date in the past

?><?xml version="1.0" encoding="Windows-1250"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>Ewelinka</Author>
  <LastAuthor>Morawiec</LastAuthor>
  <Created><?php echo date('y-m-d'); ?></Created>
  <LastSaved><?php echo date('y-m-d'); ?></LastSaved>
  <Version>14.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>10035</WindowHeight>
  <WindowWidth>21075</WindowWidth>
  <WindowTopX>120</WindowTopX>
  <WindowTopY>75</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s63">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="14" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s64">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="12" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s65">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s68">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FF0000"/>
  </Style>
  <Style ss:ID="s69">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FF0000"/>
  </Style>
  <Style ss:ID="s71">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#00B050"/>
  </Style>
  <Style ss:ID="s72">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11"/>
  </Style>
   <Style ss:ID="s16">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s17">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="16" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s18">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="12" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s19">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="14" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Sheet1">
  <Table ss:DefaultColumnWidth="90" x:FullColumns="1"
   x:FullRows="1" ss:DefaultRowHeight="15">
   <?php 
        require_once realpath(dirname(realpath(__FILE__)) . '/excelBody.php');
   ?>
   

  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
   </PageSetup>
   <Unsynced/>
   <Print>
    <ValidPrinterInfo/>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>




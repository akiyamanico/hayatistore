<?php
include "jpgraph/src/jpgraph.php";
include "jpgraph/src/jpgraph_scatter.php";	
	
include "titik.php";

include "centroid.php";
 
$graph = new Graph(1300,660);
$graph->SetScale("linlin");
 
$graph->img->SetMargin(50,40,50,100);         
$graph->xgrid->Show(true,false);
$graph->SetShadow();
 
$graph->title->Set("Hijau = C1 dan C2\nMerah : Kurang Laris\nBiru  : Laris");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$sp2 = new ScatterPlot($datay,$datax);
$sp3 = new ScatterPlot($datay2,$datax2);
$sp3->mark->SetFillColor("red");

$sp1 = new ScatterPlot($daty,$datx);
$sp1->mark->SetFillColor("green");
$sp1->mark->SetWidth(8);

//$sp1->value->Show();
//$sp3->value->Show();
//$sp2->value->Show();

//$graph->title->Set("Test of bar gradient fill");
$graph->xaxis->title->Set("Titik-X");
$graph->yaxis->title->Set("Titik-Y");
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->xaxis->title->SetFont(FF_ARIAL,FS_BOLD,12);
 
$graph->Add($sp3);
$graph->Add($sp2);
$graph->Add($sp1);


$graph->Stroke();
?>
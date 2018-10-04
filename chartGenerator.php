<?php

/* pChart library inclusions */ 
include("libs/pchart/class/pData.class.php"); 
include("libs/pchart/class/pDraw.class.php"); 
include("libs/pchart/class/pImage.class.php"); 

class ChartGenerator
{
    public function generate($rates, $drawCountLimit, $outputPath) {
        $chartDates = [];
        $chartPoints = [];
        $drawCount = 0;

        foreach($rates as $r) {
            array_unshift($chartPoints, $r->rate);
            array_unshift($chartDates, mb_substr($r->date, 5));
            $drawCount++;
            if($drawCount >= $drawCountLimit) {
                break;
            }
        }
        /* Create and populate the pData object */ 
        $chartData = new pData();
        $chartData->addPoints($chartPoints, 'Rate');
        $chartData->setPalette("Rate", array("R"=>220,"G"=>60,"B"=>20));
        $chartData->addPoints($chartDates,"Labels"); 
        $chartData->setSerieDescription("Labels","Dates"); 
        $chartData->setAbscissa("Labels"); 

        /* Create the pChart object */ 
        $chartPicture = new pImage(1024,480,$chartData); 

        /* Turn of Antialiasing */ 
        $chartPicture ->Antialias = FALSE; 

        /* Add a border to the picture */ 
//        $chartPicture->drawRectangle(0,0,699,229,array("R"=>0,"G"=>0,"B"=>0)); 

        /* Write the chart title */  
        //$chartPicture->drawText(150,35,"",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE)); 

        /* Define the chart area */ 
        $chartPicture->setGraphArea(60,40,950,420); 

        /* Draw the scale */ 
        $scaleSettings = array("XMargin"=>20,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
        $chartPicture->drawScale($scaleSettings); 

        /* Turn on Antialiasing */ 
        $chartPicture->Antialias = TRUE; 
        /* Draw the line chart */ 
        $chartPicture->drawLineChart(array("DisplayValues"=>TRUE,"DisplayColor"=>array("R"=>0,"G"=>0,"B"=>0))); 
        $chartPicture->drawPlotChart(array("PlotBorder"=>TRUE,"BorderSize"=>1,"Surrounding"=>-60,"BorderAlpha"=>80)); 

        /* Write the chart legend */ 
//        $chartPicture->drawLegend(540,20,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

        /* Render the picture (choose the best way) */ 
        $chartPicture->autoOutput($outputPath); 
    }
}

?>


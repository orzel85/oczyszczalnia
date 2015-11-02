<?php

class lib_EnergyForSpreadSheet {
    
    private $sheetArray;
    
    private $callendarWithUsageDaySimulation = array();
    
    private $monthlyUsageCallendar = array();
    
    private $spreadSheetTitle;
    
    public function __construct($sheetArray) {
        $this->sheetArray = $sheetArray;
        $this->startLogic();
    }
    
    public function setTitle($title) {
        $this->spreadSheetTitle = $title;
    }
    
    public function getTitle() {
        return $this->spreadSheetTitle;
    }
    
    public function startLogic() {
        foreach($this->sheetArray as $timeAndKWUsage) {
            for($i = 1 ; $i <= $timeAndKWUsage['numberOfDays'] ; $i++) {
                $timestampOfCurrentDate = strtotime($timeAndKWUsage['dateFrom']) + $i * 24 * 3600;
                $this->callendarWithUsageDaySimulation[ date("Y", $timestampOfCurrentDate) ][ date("m", $timestampOfCurrentDate) ][ date("d", $timestampOfCurrentDate) ] = $timeAndKWUsage['energyUsagePerDay'];
            }
        }
    }
    
    public function getMonthlyUsage() {
        $return = array();
        foreach($this->monthlyUsageCallendar as $year => $monthsUsage) {
            foreach($monthsUsage as $month => $usage) {
                $return[$year .'-'. $month] = $usage['averageUsage'];
            }
        }
        return $return;
    }
    
    public function printMonthlyAverageUsage() {
        $averageUsage = $this->getMonthlyUsage();
        echo "<br />============================================================"
        . "<br /><h3>". $this->spreadSheetTitle ."</h3>";
        foreach($averageUsage as $date => $avgUsage) {
            echo "<br />". $date ." :: ". $avgUsage;
        }
        echo "<br />";
    }
    
    public function calculateUsagePerMonth() {
        $this->createMonthlySimulation();
        $this->calculateUsage();
//        var_dump('+++++++++++++++++++++++++++++');
//        var_dump($this->monthlyUsageCallendar);
    }
    
    private function calculateUsage() {
        foreach($this->monthlyUsageCallendar as $year => $monthsUsage) {
            foreach($monthsUsage as $month => $usage) {
                $this->monthlyUsageCallendar[$year][$month]['averageUsage'] = $usage['usage'] / $usage['numberOfDays'];
            }
        }
    }
    
    private function createMonthlySimulation() {
        foreach($this->callendarWithUsageDaySimulation as $year => $monthsDaysUsage) {
            foreach($monthsDaysUsage as $month => $daysUsage) {
                foreach($daysUsage as $day => $usage) {
                    if(!isset($this->monthlyUsageCallendar[$year][$month]['usage'])) {
                        $this->monthlyUsageCallendar[$year][$month]['usage'] = 0;
                    }
                    if(!isset($this->monthlyUsageCallendar[$year][$month]['numberOfDays'])) {
                        $this->monthlyUsageCallendar[$year][$month]['numberOfDays'] = 0;
                    }
                    $this->monthlyUsageCallendar[$year][$month]['usage'] += $usage;
                    $this->monthlyUsageCallendar[$year][$month]['numberOfDays']++;
                }
            }
        }
    }
}
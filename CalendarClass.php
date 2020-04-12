<!--
 * Author: Brayden Schoenau
 *
 * Created April 11 2020
 *   
 * Calendar class created with PHP - OOP
 * - uses css for some very basic styling and Javascript for browser event effects
 *
-->
<?php

class Calendar {

    // stores the current year - does not change throughout 
    private $originalYear = 0;

    private $currentMonth = 1;
    private $currentYear = 1;

    private $year = 1;
    private $month = 1;
    private $today = 1;

    private $daysInMonth = 0;
    private $firstDayOfMonth = null;

    // array for labels - do not change order
    private $daysOfTheWeek = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

    // counters 
    private $counter = 1;
    private $dayOffset = 0;
    private $day = 0;

    // used as a reference to the current day at time of use
    private $weekDay = 0;

    private $output = null;


    private function set_original_year() {
        $this->originalYear = date("Y"); // never changes from the current year
    }

    private function get_original_year() {
        return $this->originalYear;
    }

    private function set_year() {
        $this->year = date("Y");
    }

    private function get_year() {
        return $this->year;
    }

    private function set_month() {
        $this->month = date("n");
    }

    private function get_month() {
        return $this->month;
    }

    private function set_day() {
        $this->day = date('d')-1;
    }

    private function get_day() {
        return $this->day;
    }

    private function set_current_year($year) {
        $this->currentYear = $year;
    }

    private function get_current_year() {
        return $this->currentYear;
    }

    private function set_current_month($month) {
        $this->currentMonth = $month;
    }

    private function get_current_month() {
        return $this->currentMonth;
    }

    private function set_days_in_month($currentMonth, $currentYear) {
        $this->daysInMonth = cal_days_in_month(CAL_GREGORIAN,$currentMonth,$currentYear);
    }

    private function get_days_in_month() {
        return $this->daysInMonth;
    }

    private function set_first_day_of_month($currentYear, $currentMonth) {
        $this->firstDayOfMonth = date('N',strtotime($currentYear.'-'.$currentMonth.'-01'));
    }

    private function get_first_day_of_month() {
        return $this->firstDayOfMonth;
    }








    private function create_navigation($currentMonth, $currentYear, $originalYear, $month) {

        // used when changing to the next or last month does not change the year e.g. going from January to December of same year
        if($currentMonth < 12 && $currentMonth > 1) {
            $nextMonth = ($currentMonth + 1);
            $lastMonth = ($currentMonth - 1);
            $this->output = "<div id='calendarPage' align='middle'>
            <a class='text-large' href=\"?month=".($lastMonth)."\">&lt Previous Month  |</a>
            <a class='text-large' href=\"?month=".($month)."&year=".($originalYear)."\">  Back to Current Month</a>
            <a class='text-large' href=\"?month=".($nextMonth)."\">  |  Next Month &gt</a>";
        }
        // used when changing to the previous year e.g. january 2020 should go to december of 2019
        if($currentMonth <= 1) {
            $lastYear = ($currentYear - 1);
            $lastMonth = (12);
            $nextMonth = ($currentMonth + 1);
            $this->output = "<div id='calendarPage' align='middle'>
            <a class='text-large' href=\"?month=".($lastMonth)."&year=".($lastYear)."\">&lt Previous Month  |</a>
            <a class='text-large' href=\"?month=".($month)."&year=".($originalYear)."\">Back to Current Month</a>
            <a class='text-large' href=\"?month=".($nextMonth)."\">  |  Next Month &gt</a>";
        }
        // used when changing to the next year e.g. December 2020 should go to January of 2021
        if($currentMonth >= 12) {
            $nextYear = ($currentYear + 1);
            $nextMonth = (1);
            $lastMonth = ($currentMonth - 1);
            $this->output = "<div id='calendarPage' align='middle'>
            <a class='text-large' href=\"?month=".($lastMonth)."\">&lt Previous Month  |</a>
            <a class='text-large' href=\"?month=".($month)."&year=".($originalYear)."\">Back to Current Month</a>
            <a class='text-large' href=\"?month=".($nextMonth)."&year=".($nextYear)."\">  |  Next Month &gt</a>";
        }
    }

    // $firstDayOfMonth, $daysInMonth, $dayOffset, $counter, $currentDay, $month, $currentMonth, $day, $daysOfTheWeek
    public function show() {

        $this->set_original_year();
        $this->set_year();
        $this->set_day();
        // $this->set_original_year();

        // $this->get_original_year();

        // defualt variables !! important
        $this->set_year();
        $this->set_month();

        // change throughout session
        $this->set_current_month($this->get_month());
        $this->set_current_year($this->get_year());
        
        // get the current month from the session
        if(isset($_GET['month']) && trim($_GET['month']) != "") {
            $this->currentMonth = $_GET['month'];
        } 
        // if not set the year equal to the current year
        else {
            $this->set_year();
        }
        // get the current year from the url  
        if(isset($_GET['year']) && trim($_GET['year']) != "") {
            $this->currentYear = $_GET['year'];
            // $_SESSION["year"] = $this->get_current_year();
        }   

        $this->set_days_in_month($this->get_current_month(), $this->get_current_year());
        $this->set_first_day_of_month($this->get_current_year(), $this->get_current_month());
        $this->create_navigation($this->get_current_month(), $this->get_current_year(), $this->get_original_year(), $this->get_month());



        // create the table headers
        $this->output .= "<table>
        <caption class='title'>".date('Y M',strtotime($this->get_current_year().'-'.$this->get_current_month().'-1'))."</caption>";


        $this->output .= "<tbody id='tableBody'>
            <tr id='calendarHeaders'>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Saturday</th>
                <th>Sunday</th>
            </tr>
            <tr>";

           // loop to create calendar  with enough space to create an offset 
           for ($i=1; $i < 43; $i++) {  
                // if the current day is between the first and last day of the month 
                // echo "<div> ". $this->get_first_day_of_month($this->get_current_month()) ."</div>"; 
                if($i >= $this->get_first_day_of_month($this->get_current_month()) && $i <= ($this->get_days_in_month() + $this->dayOffset)) {
                    $style = '';
            
                    // style the current day if on current month
                    if ($this->counter == $this->get_day() & $this->get_month() == $this->get_current_month()) {
                        $style = 'background-color: #70d26d';
                    }
                    else {
                        $style = 'background-color: white';
                    }
            
                    // add table data to output
                    $this->output .= "<td id='". $this->counter ."' class='". $this->daysOfTheWeek[$this->weekDay] ."' style='". $style ."'>".$this->counter . "<br /></td>";
            
                    // increase counters
                    $this->counter++;
                    $this->weekDay++;
                }
                // if the table data should be empty (eg before or after the first and last day of the month)
                else {
                    $this->output .= "<td class='". $this->daysOfTheWeek[$this->weekDay] ."'></td>";
                    $this->weekDay++;
                    $this->dayOffset++;
                }
                // if the current date is greater than length of week create new table row
                if($i > 0 & $i % 7 == 0) {
                    $this->weekDay = 0;
                    if($i < 36 && $i <= ($this->get_days_in_month() + $this->dayOffset)) {
                    $this->output .= "</tr>";
                    }
                }
                //reset counter
                if ($this->counter > $this->get_days_in_month()) {
                    $this->counter = 1;
                }
        
            }
    
        // close table element
        $this->output .= "</tbody>
                    </table>
                    </div>";
    
        // display the calendar
        return $this->output;


    }



}

?>
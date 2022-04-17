<?php
include "includes/head.php";
require "templates/Calendar.php";
?>

<style>
.card th, .card td{
    width:14%;
    vertical-align: top;
}
[title="today"]{
    background-color: lightpink;
}
[title="meeting"]{
    background-color: transparent;
    border: none;
    color: blue;
    text-decoration: underline;
}
div.months{
    display:none;
}
</style>

<!-- Displays the coursemanager main content -->
<div class=content>

<h1>Meetings</h1>
<p></p>
<hr>
<p></p>
<a href="add_meeting.php">Create a Meeting</a>
<p></p>
<hr>
<p></p>

<?php
// Display success message when adding meeting
if (isset($_SESSION['message'])){
  echo "<font color='blue'>".$_SESSION['message']."</font><br><br>";
  unset($_SESSION['message']);
}
?>

<div class="card">
  <div class="months"></div>
  <table class="calendar-table" id="calendar" style="width:70%;height:50%">
    <thead>
      <tr>
        <td align="middle"><div class="month-left"><--</div></td>
        <td colspan="5" align="middle"><span class="monthTitle" id="monthTitle"></span><span class="big-year" id="yearNum"></span></td>
        <td align="middle"><div class="month-right">--></div></td>
      </tr>
      <tr>
        <th class="days-of-week">Sun</th>
        <th class="days-of-week">Mon</th>
        <th class="days-of-week">Tue</th>
        <th class="days-of-week">Wed</th>
        <th class="days-of-week">Thu</th>
        <th class="days-of-week">Fri</th>
        <th class="days-of-week">Sat</th>
      </tr>
    </thead>
    <tbody id="calendar-body">
    </tbody>
  </table>
</div>

<?php
// Get meeting info for the user 
$meeting_info = array();
$data = $link->query("SELECT m.meeting_id, m.title, m.date, m.end_time FROM meetings m JOIN rtc55314.groups g ON g.group_id=m.group_id JOIN group_users gu ON g.group_id=gu.group_id WHERE gu.user_id=" . $_SESSION['id'] . " AND g.section_id=" . $_SESSION['section_id']);

if($data -> num_rows>0){
    while($row = mysqli_fetch_array($data,MYSQLI_NUM)){
        $info = array();
        $meeting_id = $row[0];
        $title = $row[1];
        $date = $row[2];
        $end_time = $row[3];
        // Format date to match calendar id
        $fdate = str_replace("-", "", substr($date, 0, strpos($date, ' ')));
        $time = substr($date, strpos($date, ' ')+1);
        array_push($info, $meeting_id, $title, $fdate, $time, $end_time);
        array_push($meeting_info, $info);
    }
}

$json_meeting_info = json_encode($meeting_info);
?>

<script>
var meeting_info = <?php echo $json_meeting_info ?>;
let today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
let allMonths = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
let yearNum = document.getElementById("yearNum");

function renderMonths(){
    allMonths.forEach(function(month, i){
        let months = document.querySelector('.months')
        let monthSpan = document.createElement('span')
  
        monthSpan.className = 'each-month'
        monthSpan.id = i+1
        monthSpan.innerHTML =` ${month} `
        months.append(monthSpan)

        monthSpan.addEventListener('click', function(e){
            if(document.querySelector('.hidden-p')){
                let sel = document.querySelector('.selected')
                sel.className = "each-month"
            }
            e.target.className = 'selected'
            let newp = document.createElement('p')
            newp.className = 'hidden-p'
            newp.hidden = true
            monthSpan.append(newp)
        })

        document.addEventListener('click', function(e){
            if(e.target.className === 'selected'){
                e.preventDefault()
                currentMonth = e.target.id-1
                currentYear = currentYear
                renderCalendar(currentMonth, currentYear)
            }
        })
    })
}

function renderCalendar(month, year) {
    let firstDayOfTheMonth = (new Date(year, month)).getDay();
    let daysInMonth = 32 - new Date(year, month, 32).getDate();

    let calendarTable = document.getElementById("calendar-body");
    calendarTable.innerHTML = "";
    yearNum.innerHTML = `${year}`;
    monthTitle.innerHTML = `${allMonths[currentMonth].concat(" ")}`;

    let date = 1;
    for (let i = 0; i < 6; i++) {
        let week = document.createElement("tr");

        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDayOfTheMonth) {
                let day = document.createElement("td");
                let dateNum = document.createTextNode("");
                day.appendChild(dateNum);
                week.appendChild(day);
            } else if (date > daysInMonth) {
                break;
            } else {
                let day = document.createElement("td");
                let dateNum = document.createTextNode(date);
                if (date === today.getDate() && year === today.getFullYear() && month === today.getMonth()) {
                    day.title = "today";
                } 
                day.id = `${year}${String(month+1).padStart(2, '0')}${String(dateNum.textContent).padStart(2, '0')}`
                day.appendChild(dateNum)
                day.appendChild(document.createElement("br"))
                day.appendChild(document.createElement("br"))
                for (let k = 0; k < meeting_info.length; k++) {
                    if (meeting_info[k][2].localeCompare(day.id) === 0) {
                        var dateNum2 = document.createElement("form");
                        dateNum2.method = 'post';
                        dateNum2.action = 'includes/meeting_select.php';

                        var hidden = document.createElement("input");
                        hidden.type = "hidden";
                        hidden.name = "meeting_id";
                        hidden.value = meeting_info[k][0];
                        dateNum2.appendChild(hidden);

                        var button = document.createElement("button");
                        button.innerHTML = meeting_info[k][1].concat(" (@", meeting_info[k][3], "-", meeting_info[k][4], ")");
                        button.title = "meeting";
                        button.type = "submit";
                        button.name = "submit";
                        dateNum2.appendChild(button);
                        day.appendChild(dateNum2);
                    }
                }
                week.appendChild(day);
                date++;
                
                day.className = 'dates'
            }
        }
        calendarTable.appendChild(week);
    }
    calendarTable.addEventListener('click', function(e){
        let hiddenTwo = document.querySelector('.hidden-p2')
        if(hiddenTwo){
        let sel = document.querySelector('.selected-day')
        sel.className = "dates"
        }
        e.target.className = 'selected-day'
        sp.id = e.target.id
        let newpp = document.createElement('p')
        newpp.className = 'hidden-p2'
        newpp.hidden = true
        calendarTable.append(newpp)
    });
}

function nextYear() {
    document.addEventListener('click', function(e){
        if(e.target.className === 'triangle-right'){
            e.preventDefault()
            currentYear = currentYear+1
            currentMonth = currentMonth;
            renderCalendar(currentMonth, currentYear);     
        } 
    })
}

function previousYear() {
    document.addEventListener('click', function(e){
        if(e.target.className === 'triangle-left'){
            e.preventDefault()
            currentYear = currentYear-1;
            currentMonth = currentMonth;
            renderCalendar(currentMonth, currentYear);
        }
    })
}

function previousMonth() {
    document.addEventListener('click', function(e){
        if(e.target.className === 'month-left'){
            e.preventDefault()
            currentYear = currentYear;
            if(currentMonth == 0){
                currentMonth = 11;
                currentYear = currentYear - 1;
            }
            else{
                currentMonth = currentMonth - 1;
            }
            renderCalendar(currentMonth, currentYear);
        }
    })
}

function nextMonth() {
    document.addEventListener('click', function(e){
        if(e.target.className === 'month-right'){
            e.preventDefault()
            currentYear = currentYear;
            if(currentMonth == 11){
                currentMonth = 0;
                currentYear = currentYear + 1;
            }
            else{
                currentMonth = currentMonth + 1;
            }
            renderCalendar(currentMonth, currentYear);
        }
    })
}

renderMonths()
renderCalendar(currentMonth, currentYear);
nextYear()
previousYear()
previousMonth()
nextMonth()
</script>
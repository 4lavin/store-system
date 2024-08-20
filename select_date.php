<?php
include "header.php";
// Function call with passing the start date and end date
$week = array("Sunday", "Monday", "Tuesday", "Wedneday", "Thursday", "Friday", "Saturday");
$Date = array('2024-01-01', '2024-02-01'); ?>

<div class="d-flex">
    <?php foreach ($Date as $k) {
        $days_a_month = date("t", strtotime($k));
        $week_day = date("N", strtotime($k));
        $days = array_fill(0, $week_day, "");
        for ($i = 1; $i <= $days_a_month; $i++) {
            $days[] = $i;
        }
        $chunk = array_chunk($days, 7); ?>
        <table>
            <thead>
                <tr>
                    <td>Sunday</td>
                    <td>Monday</td>
                    <td>Tuesday</td>
                    <td>Wednesday</td>
                    <td>Thursday</td>
                    <td>Friday</td>
                    <td>Saturday</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chunk as $week) { ?>
                    <tr>
                        <?php foreach ($week as $day) { ?>
                            <td><?php echo $day ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>

<!-- 
$days_a_month = date("t", strtotime($Date));
$week_day = date("N", strtotime($Date));
$days = array_fill(0, $week_day, "");
for ($i = 1; $i <= $days_a_month; $i++) {
    $days[] = $i;
}
$chunk = array_chunk($days, 7); -->
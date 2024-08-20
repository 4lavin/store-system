<?php
include "db_connect.php";
include "header.php";
$date = "2012";

$year = date('Y');

$month = date('M');
?>
<select name="date" id="date" class="form-select" onchange="selectDate()">
    <option value="">Select Date</option>
    <?php
    for ($i = 2020; $i <= $year; $i++) { ?>
        <option value="<?php echo $i ?>"><?php echo $i ?></option>
    <?php } ?>
</select>
<!-- <button type="button" onclick="btn()">click</button> -->
<table class="table table-striped table-bordered">
    <colgroup>
        <col width="14.3%">
        <col width="14.3%">
        <col width="14.3%">
        <col width="14.3%">
        <col width="14.3%">
        <col width="14.3%">
        <col width="14.3%">
    </colgroup>
    <thead>
        <!-- <tr>
            <th>S</th>
            <th>M</th>
            <th>T</th>
            <th>W</th>
            <th>TH</th>
            <th>F</th>
            <th>S</th>
        </tr> -->
    </thead>
</table>
</body>
<script>
    // function selectDate() {
    //     let year = $("#date").val();
    //     $.ajax({
    //         type: "POST",
    //         url: "select_date.php",
    //         data: { year: year },
    //         success: function (data) {
    //             console.log(data);

    //         }
    //     })

    // }
</script>

</html>
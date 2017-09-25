<?php

require_once("DB_Handler.php");
$db = new DB_Handler();
$tickets_arr = array_reverse($db->viewTraffic());
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="TikTik Web Traffic">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
</head>
<body>
<table width="100%" border="solid">
    <tr>
        <th align="center">
            <strong>Hub Access Tickets</strong>
        </th>
    </tr>
</table>

<table width="100%" border="solid">
    <tr>
        <th align="center">
            <strong>
                Hub Id
            </strong>
        </th>
        <th align="center">
            <strong>
                Customer
            </strong>
        </th>
        <th align="center">
            <strong>
                Market
            </strong>
        </th>
        <th align="center">
            <strong>
                Location
            </strong>
        </th>
        <th align="center">
            <strong>
                Job
            </strong>
        </th>
        <th align="center">
            <strong>
                Start Time
            </strong>
        </th>
        <th align="center">
            <strong>
                Date
            </strong>
        </th>
        <th align="center">
            <strong>
                Team Members
            </strong>
        </th>
        <th align="center">
            <strong>
                XOC
            </strong>
        </th>
    </tr>
<?php
$last = '';
foreach( $tickets_arr as $ticket) {
    if ($last == $ticket["hub_id"]) {
        continue;
    }
    echo "<tr>";
    echo "<td align='center'>".$ticket["hub_id"]."</td>";
    echo "<td align='center'>".$ticket["customer"]."</td>";
    echo "<td align='center'>".$ticket["market"]."</td>";
    echo "<td align='center'>".$ticket["location"]."</td>";
    echo "<td align='center'>".$ticket["job"]."</td>";
    echo "<td align='center'>".$ticket["start_time"]."</td>";
    echo "<td align='center'>".$ticket["date"]."</td>";
    echo "<td align='center'>".$ticket["team_members"]."</td>";
    echo "<td align='center'>".$ticket["xoc"]."</td>";
    echo "</tr>";
    $last = $ticket["hub_id"];
}
?>
</table>
</body>
</html>

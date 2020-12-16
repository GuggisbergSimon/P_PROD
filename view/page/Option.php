<h4>Page réservée à l'admin du site permettant d'y apporter des modifications ainsi que de nouvelles fonctionnalités</h4>
<?php
$day = date('w');
for ($i = 0; $i < 5; $i++) {
    $week_day = date('Y-m-d', strtotime('+1 days', strtotime('+'.($i-$day).' days')));
    echo '<a href="index.php?controller=home&action=DisplayDay&day=' . $week_day . '">' . date('D', strtotime($week_day)) . '</a>';
}
$week_end = date('d-m-Y', strtotime('+'.(6-$day).' days'));

//TODO remove the 3 next lines, they are for test purposes only
?>
<br>
<a href="index.php?controller=home&action=DisplayDay&day=2020-12-09">DayTest</a>
<?php

$pdo = new PDO('mysql:host=localhost;dbname=crypto', 'root', 'IOJIOjoijipodfhzeoufhozeifh584848');
if($pdo) {
    $currentTimestamp = time();
    $currentYear = date('Y', $currentTimestamp);
    $currentMonth = date('n', $currentTimestamp);
    $result = array();
    $monthIndex = 0;
    while(12 > count($result)) {
        $monthName = date('F', strtotime($currentYear . '-' . $currentMonth . '-20'));
        $query = '
            SELECT  count(*) as `count`
            FROM    `Users`
            WHERE   month(`SignUpDate`) = :month
                    AND year(`SignUpDate`) = :year';
        $cmd = $pdo->prepare($query);
        $cmd->bindValue(':month', $currentMonth);
        $cmd->bindValue(':year', $currentYear);
        if($cmd->execute()) {
            $row = $cmd->fetch(PDO::FETCH_ASSOC);
            $result[] = array(
                'Month' => (0 == $monthIndex)? 'This month': $monthName,
                'Users' => $row['count']
            );
            $monthIndex++;
        } else {
            echo json_encode(array(
                'error' => 1,
                'errorMsg' => 'Cannot select data.'
            ));

            exit();
        }

        $currentMonth = (1 == $currentMonth)? 12: $currentMonth - 1;
        $currentYear = (12 == $currentMonth)? $currentYear - 1: $currentYear;
    }
  $result = array_reverse($result);
    echo json_encode($result);
} else {
    echo json_encode(array(
        'error' => 1,
        'errorMsg' => 'Cannot connect to database.'
    ));
}

?>

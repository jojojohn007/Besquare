<?php


if (($_GET['checkifuserexists'] == 'yes')) {

    echo json_encode(array(
        'checkifuserexists' => false,
        'proceed' => ''

    ));
} else {

    echo json_encode(array('checkifuserexists' => false));
}

if (isset($_GET['proceed'])) {  //insert course details

    echo json_encode(array('jojo' => 'fasdf'));
}
<?php

function style_alerts($alertColor, $mainTitle, $mainMessage, $underMessage) {

    $message = '
        <div class="alert alert-' . $alertColor . ' alert-dismissible fade show" role="alert">
           <h4 class="alert-heading">' . $mainTitle . '</h4>
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
           </button>
           <p>' . $mainMessage . '</p>
           <hr>
           <p class="mb-0">' . $underMessage . '</p>
        </div>
    ';

    return $message;
}

function style_short_alerts($alertColor, $errorTitle, $mainMessage) {
    $message = '
        <div class="alert alert-' . $alertColor . ' alert-dismissible fade show" role="alert">
          <strong>' . $errorTitle . '</strong> ' . $mainMessage . '
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
    ';

    return $message;
}
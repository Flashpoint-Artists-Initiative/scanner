<?php

function relativeTime($date, $postfix = 'ago') {
  $diff = time() - strtotime($date);
  if ($diff < 0) {
    $diff = strtotime($date) - time();
    $postfix = 'from now';
  }
  if ($diff >= 604800) {
    $diff = round($diff/604800);
    $return = $diff." week". ($diff != 1 ? 's' : '');
  }
  elseif ($diff >= 86400) {
    $diff = round($diff/86400);
    $return = $diff." day". ($diff != 1 ? 's' : '');
  }
  elseif ($diff >= 3600) {
    $diff = round($diff/3600);
    $return = $diff." hour". ($diff != 1 ? 's' : '');
  }
  elseif ($diff >= 60) {
    $diff = round($diff/60);
    $return = $diff." minute". ($diff != 1 ? 's' : '');
  }
  elseif ($diff <= 30) {
   return "just now";
  }
  else {
    $return = $diff." second". ($diff != 1 ? 's' : '');
  }
  return "$return $postfix";
}

function timestamp($date) {
	return "<span class='time' data-toggle='tooltip' title='".date('l jS \of F Y h:i:s A',strtotime($date))."'>".relativeTime($date)."</span>";
}

function pick($list) {
  if (!is_array($list)) {
    $list = explode(',',$list);
  }
  return $list[floor(rand(0,count($list)-1))];
}

function is_admin(){
  if (isset($_SESSION['is_admin'])){
    if ($_SESSION['is_admin']){
      return true;
    }
  }
  return false;
}

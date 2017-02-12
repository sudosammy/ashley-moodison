<?php

//change page title
if (!empty($tdata['page_title'])) {
	$tdata['page_title'] = ucwords($tdata['page_title']) . ' - ' . SITE_TITLE;
} else {
	$tdata['page_title'] = SITE_TITLE;
}

$total_time = round(microtime(true) - $start_time, 4);
$smarty->assign('request_time', 'Page served in ' . $total_time . ' seconds.');

$smarty->assign($tdata);
//ss($smarty->getTemplateVars());
$smarty->display(TEMPLATE);

<?php

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

require 'common.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$page = translatePageName($page, 'en');

$file = null;
switch($page)
{

	case 'home':
	case 'about-us':
	case 'failure-analysis':
	case 'research':
	case 'analysis-metals':
	case 'analysis-metals-physical':
	case 'analysis-metals-chemical':
	case 'analysis-metals-oxidation':
	case 'analysis-polymers':
	case 'analysis-polymers-mechanical':
	case 'analysis-polymers-degradation':
	case 'analysis-polymers-chemical':
	case 'analysis-polymers-physical':
	case 'analysis-polymers-tear':
	case 'analysis-ink':
	case 'analysis-thongs':
	case 'analysis-others':
	case 'news':
	case 'jobs':
	case 'team':
	case 'products-development':

		$file = 'views/' . $page . '.phtml';

		break;

	case 'contact':

		$file = 'dynamic/' . $page . '.php';

		break;

	default:

		$file = 'views/errors/404.phtml';

}

require 'views/layout.phtml';
<?php

require_once __DIR__ . '/routes/pages.php';
require_once __DIR__ . '/routes/portfolio.php';

use Calva\RouteHelper;

$portfolioRoutes = RouteHelper::transformRoutes($portfolio, 'portfolio', 'portfolio-single');
$portfolioRoutes = RouteHelper::addPreviousNext($portfolioRoutes);

$pageRoutes = RouteHelper::transformRoutes($pages);
$pageRoutes['portfolio']['items'] = $portfolioRoutes;

RouteHelper::addRoutes($app, $pageRoutes);
RouteHelper::addRoutes($app, $portfolioRoutes);

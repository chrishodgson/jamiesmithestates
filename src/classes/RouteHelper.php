<?php

namespace Calva;

class RouteHelper
{
    public static function transformRoutes($routes, $routePrefix = '', $templateName = '')
    {
        foreach($routes as $name => $route) {
            $url = $routePrefix ? $routePrefix . '/' : '';
            $url .= isset($route['url']) ? $route['url'] : $name;
            $template = $templateName ? $templateName : $name;

            $routes[$name] = array_merge($routes[$name], [
                'url' => $url,
                'name' => $name,
                'template' => $template . '.twig',
                'label' => ucwords(str_replace('-', ' ', $name)),
                'meta_title' => $route['title'] ? $route['title'] : null,
                'meta_description' => $route['description'] ? $route['description'] : null
            ]);
        }
        return $routes;
    }


    public static function addRoutes($app, $routes)
    {
        foreach ($routes as $route) {
            $app->get('/' . $route['url'], function ($request, $response) use ($route) {
                return $this->view->render($response, $route['template'], array_merge($route, [
                    'current_route' => $request->getUri()->getPath()
                ]));
            })->setName($route['name']);
        }
    }

    public static function addPreviousNext($routes)
    {
        $keys = array_keys($routes);
        $count = 0;
        $newRoutes = [];
        foreach($routes as $key => $route) {
            $prev = $keys[$count-1];
            $next = $keys[$count+1];
            $route['prev'] = $routes[$prev]['name'];
            $route['next'] = $routes[$next]['name'];
            $newRoutes[$key] = $route;
            $count++;
        }
        return $newRoutes;
    }
}
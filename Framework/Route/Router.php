<?php

namespace Framework\Route;

class Router {
    protected $Routes = [];
    protected $FriendlyUrlPattern = "/(\:\w+|\{\w+\})/";

    function __construct (array $routes = []) {
        $routes = [
            [
                'url' => 'users'
            ],
            [
                'url' => 'users/:id'
            ],
            [
                'url' => 'order/{order_id}/:user_id'
            ],
            [
                'url' => 'orders'
            ],
            [
                'url' => 'orders/:order_id'
            ]
        ];
        $this->Routes = $routes;
        $this->mapRouteInfo();
    }

    // PUBLIC
    public function get(){}

    public function post() {}

    public function patch() {}

    public function put () {}

    // public function delete () {}

    // PRIVATES
    private function mapRouteInfo () {
        foreach ($this->Routes as $index => $route) {
            $vars           = $this->getRouteVars($route['url']);
            $varsCount      = count($vars);
            $varsPosition   = $varsCount > 0 ? $this->getVarsPosition($route['url']) : [];
            $routePieces    = explode('/', $route['url']);
            $numberOfPieces = count($routePieces);
            $this->Routes[$index]['metadata'] = [
                'route_pieces'      => $routePieces,
                'number_of_pieces'  => $numberOfPieces,
                'vars'              => $vars,
                'vars_count'        => $varsCount,
                'vars_pos'          => $varsPosition
            ];
        }
    }

    private function getRouteVars ($url) {
        $result = [];
        preg_match_all($this->FriendlyUrlPattern, $url, $result);
        return $result[0];
    }

    private function getVarsPosition ($route) {
        $route_pieces   = explode('/', $route);
        $positions      = [];
        foreach ($route_pieces as $i => $piece) {
            if (preg_match($this->FriendlyUrlPattern, $piece))
                array_push($positions, $i);
        }
        return $positions;
    }
}
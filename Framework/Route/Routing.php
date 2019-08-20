<?php

namespace Framework\Route;

class Routing extends Router {

    function __construct () {
        parent::__construct();
    }

    public function matchRoute () {
        $uri         = trim(explode('?', $_SERVER['REQUEST_URI'], 2)[0], '/');
        $uri_pieces  = explode('/', $uri);
        $matcedRoute = [];
        foreach ($this->Routes as $route) {
            $number_of_pieces = count($uri_pieces);
            // echo "Comparando {$route['url']} == {$uri} <br>";

            if (!$this->sameNumberOfPieces($number_of_pieces, $route['metadata']['number_of_pieces'])) continue;
            $haveAMatch = $this->urlMatch($uri_pieces, $route['metadata']['route_pieces'], $route['metadata']['vars_pos']);
            if ( $haveAMatch ) {
                echo "<pre>";print_r($route);echo "</pre>";
                $matcedRoute = $route;
                break;
            }
        }
        die;

        return $matcedRoute;
    }

    private function sameNumberOfPieces ($count_uri_pieces, $count_route_pieces) {
        echo "URI HAS {$count_uri_pieces} PIECES <br>";
        echo "ROUTE HAS {$count_route_pieces} PIECES <br><hr>";
        return $count_uri_pieces == $count_route_pieces;
    }

    private function urlMatch ($uri_pieces, $route_pieces, $route_var_positions) {
        $perfect_match = true;
        
        foreach ($uri_pieces as $index => $piece) {
            $isVarPiece = in_array($index, array_keys($route_pieces));
            if (!$isVarPiece) {
                echo "Uri: {$piece} - Route: {$route_pieces[$index]} <br>";
                if ($piece != $route_pieces[$index]) {
                    $perfect_match = false;
                    break;
                }
            }
            
        }
        return $perfect_match;
    }

}
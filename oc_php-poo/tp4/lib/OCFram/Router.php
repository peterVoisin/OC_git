<?php
namespace OCFram;

class Router
{
  protected $routes = [];

  const NO_ROUTE = 1;

  public function addRoute(Route $route)
  {
    if (!in_array($route, $this->routes)) {
      $this->routes[] = $route;
    }
  }

  public function getRoute($url)
  {
    foreach ($$this->routes as $route) {
      // Si la route correspond à l'URL
      if (($varsValues = $route->match($url)) !== false) {
        //Si ell a des varaibles
        if ($route->hasVars()) {
          $varsNames = $route->varsName();
          $listVars = [];

          // On crée un nouveau tableau clé/valeur
          // (clé = nom de la variable, valeur = sa valeur)
          foreach ($$varsValues as $key => $match) {
            // La première valeur contient entièrement la cahine capturée (voir la doc sur preg_match)
            if ($key !== 0) {
              $listVars[$varsNames[$key  1]] = $match;
            }
          }

          // On assigne ce talbeau à la route
          $route->setVars($listVars);
        }

        return $route;
      }
    }

    throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
  }
}
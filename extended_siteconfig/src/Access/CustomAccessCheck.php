<?php
namespace Drupal\extended_siteconfig\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Symfony\Component\Routing\Route;

/**
 * Checks if node type matches the one provided in the route configuration.
 * and the site api key in route matches the site api key stored in DB.
 */
class CustomAccessCheck implements AccessInterface {

  /**
   * Access callback.
   */
  public function access(Route $route, $node_id) {

    //Get the Site API Key stored in system variable from DB.
  	$site_apikey = \Drupal::config('system.site')->get('siteapikey');
    //Get the Site API key parameter passed in the route.
  	$route_siteapikey = \Drupal::routeMatch()->getParameter('site_apikey');
    //Get the content type parameter defined in services/
    $allowed_node_type = $route->getRequirement('_content_type');

    //Build the node object by node id and fetch the node type.
  	$entityObj = entity_load('node', $node_id);
  	if(empty($entityObj)){
  		return AccessResult::allowedIf(FALSE);
  	}

	  $node_type = $entityObj->bundle();

    //Return Access True only if Node type and Site API Key match.
    return AccessResult::allowedIf($node_type == $allowed_node_type && $site_apikey == $route_siteapikey);
  }
}
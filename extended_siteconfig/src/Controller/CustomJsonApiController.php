<?php
/**
 * @file
 * Contains \Drupal\extended_siteconfig\Controller\CustomJsonApiController.
 */

namespace Drupal\extended_siteconfig\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;

class CustomJsonApiController extends ControllerBase {

  /**
   * Callback for the custom API to return node data in JSON format.
   */
  public function renderApi($site_apikey, $node_id) {

    return new JsonResponse([
      'data' => $this->getResults($site_apikey, $node_id),
      'method' => 'GET',
    ]);
  }

  /**
   * function returning JSON data of given node id.
   */
  public function getResults($site_apikey, $node_id) {
  	$serializer = \Drupal::service('serializer');
	  $node = Node::load($node_id);
	  $data = $serializer->serialize($node, 'json', ['plugin_id' => 'entity']);
    return $data;
  }
}
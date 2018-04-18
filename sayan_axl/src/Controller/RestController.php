<?php

namespace Drupal\sayan_axl\Controller;

use Drupal\node\Entity\Node;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Drupal\node\NodeInterface;

class RestController {

  /**
   *
   * @param unknown $id
   * @return multitype:NULL
   */
  public function getContent($apikey,$id){

    $node = Node::load($id);
    $site_api_key = \Drupal::config('core.site_information')->get('siteapikey');
    if ($node instanceof  NodeInterface && $node->getType() == "page" && $apikey == $site_api_key){

      $serializer = \Drupal::service('serializer');
      $data = $serializer->serialize($node, 'json', ['plugin_id' => 'entity']);

    }else{
      $data = "Access Denied";
    }

    $response = new Response($data);
    $response->headers->set('Content-Type', 'application/json');

    return $response;

  }
}

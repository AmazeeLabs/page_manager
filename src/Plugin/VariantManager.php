<?php

/**
 * @file
 * Contains \Drupal\page_manager\Plugin\VariantManager.
 */

namespace Drupal\page_manager\Plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Manages discovery of display variant plugins.
 */
class VariantManager extends DefaultPluginManager {

  /**
   * Constructs a new VariantManager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/DisplayVariant', $namespaces, $module_handler, 'Drupal\page_manager\Annotation\DisplayVariant');

    $this->setCacheBackend($cache_backend, 'display_variant_plugins');
    // @todo Set an alter hook.
  }

}
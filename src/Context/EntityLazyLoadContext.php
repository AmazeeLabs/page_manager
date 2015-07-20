<?php

/**
 * @file
 * Contains \Drupal\page_manager\Context\EntityLazyLoadContext.
 */

namespace Drupal\page_manager\Context;

use Drupal\Component\Plugin\Context\ContextDefinitionInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Plugin\Context\Context;

class EntityLazyLoadContext extends Context {

  /**
   * The entity UUID.
   *
   * @var string
   */
  protected $uuid;

  /**
   * The entity manager.
   *
   * @var string
   */
  protected $entityManager;

  /**
   * Construct an EntityLazyLoadContext object.
   *
   * @param \Drupal\Component\Plugin\Context\ContextDefinitionInterface $context_definition
   *   The context definition.
   * @param string $uuid
   *   The UUID of the entity.
   */
  public function __construct(ContextDefinitionInterface $context_definition, EntityManagerInterface $entity_manager, $uuid) {
    parent::__construct($context_definition);
    $this->entityManager = $entity_manager;
    $this->uuid = $uuid;
  }

  /**
   * {@inheritdoc}
   */
  public function getContextValue() {
    if (!$this->contextValue) {
      $entity_type_id = substr($this->contextDefinition->getDataType(), 7);
      $this->contextValue = $this->entityManager->loadEntityByUuid($entity_type_id, $this->uuid);
    }
    return $this->contextValue;
  }

  /**
   * {@inheritdoc}
   */
  public function hasContextValue() {
    // Ensure that the entity is loaded before checking if it exists.
    if (!$this->contextValue) {
      $this->getContextValue();
    }
    return parent::hasContextValue();
  }

}

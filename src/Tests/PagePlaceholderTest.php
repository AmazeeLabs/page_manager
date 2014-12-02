<?php

/**
 * @file
 * Contains \Drupal\page_manager\Tests\PageNodeSelectionTest.
 */

namespace Drupal\page_manager\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests selecting page variants based on nodes.
 */
class PagePlaceholderTest extends WebTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = array('page_manager', 'page_manager_test');

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->drupalLogin($this->drupalCreateUser(array('administer pages')));
  }

  /**
   * Tests that a node bundle condition controls the node view page.
   */
  public function testPagePlaceHolder() {
    // Access the page callback and check whether string is printed.
    $page_string = 'test-page';
    $this->drupalGet('page-manager-test/' . $page_string);
    $this->assertResponse(200);
    $this->assertText('Hello World! Page ' . $page_string);

    // Create a new page entity with the same path as in the test module.
    $edit = array(
      'label' => 'Placeholder test',
      'id' => 'placeholder',
      'path' => '/page-manager-test/%',
    );
    $this->drupalPostForm('admin/structure/page_manager/add', $edit, 'Save');
    $this->clickLink('Edit');
    $this->drupalPostForm(NULL, array('display_variant[status_code]' => 200), 'Update display variant');

    // Access the page callback again and check that now the text is not there.
    $this->drupalGet('page-manager-test/' . $page_string);
    $this->assertResponse(200);
    $this->assertNoText('Hello World! Page ' . $page_string);
  }

}

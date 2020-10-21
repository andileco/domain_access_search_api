<?php

namespace Drupal\domain_access_search_api\Plugin\views\filter;

use Drupal\domain\DomainNegotiatorInterface;
use Drupal\views\Plugin\views\filter\BooleanOperator;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\ViewExecutable;

/**
 * Handles matching of current domain.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("domain_access_search_api_current_all_filter")
 */
class DomainAccessSearchApiCurrentAllFilter extends BooleanOperator {

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->value_value = t('Available on current domain');
  }

  /**
   * {@inheritdoc}
   */
  public function getValueOptions() {
    $this->valueOptions = [1 => $this->t('Yes'), 0 => $this->t('No')];
  }

  /**
   * {@inheritdoc}
   */
  protected function operators() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    $this->ensureMyTable();

    /** @var DomainNegotiatorInterface $domain_negotiator */
    $domain_negotiator = \Drupal::service('domain.negotiator');
    $current_domain = $domain_negotiator->getActiveDomain();
    $current_domain_id = $current_domain->id();

    if (!empty($this->value)) {

      $this->query->addWhere(0, $this->realField, $current_domain_id, "=");
    }

    // This filter causes duplicates.
    $this->query->options['distinct'] = TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    $contexts = parent::getCacheContexts();

    $contexts[] = 'url.site';

    return $contexts;
  }

}

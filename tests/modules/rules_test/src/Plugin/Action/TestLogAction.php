<?php

/**
 * @file
 * Contains \Drupal\rules_test\Plugin\Action\TestAction.
 */

namespace Drupal\rules_test\Plugin\Action;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\rules\Core\RulesActionBase;
use Drupal\rules\Logger\RulesLoggerChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an action writing something to the Rules log.
 *
 * @Action(
 *   id = "rules_test_log",
 *   label = @Translation("Test action logging.")
 * )
 */
class TestLogAction extends RulesActionBase implements ContainerFactoryPluginInterface {

  /**
   * Rules logger instance.
   *
   * @var \Drupal\rules\Logger\RulesLoggerChannel
   */
  protected $loggerChannel;

  /**
   * Constructs a TestLogAction object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\rules\Logger\RulesLoggerChannel $loggerChannel
   *   Rules logger object.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RulesLoggerChannel $loggerChannel, LoggerInterface $logger) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->loggerChannel = $loggerChannel;
    $this->loggerChannel->addLogger($logger);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('logger.channel.rules'),
      $container->get('logger')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function execute() {
    $this->loggerChannel->critical('action called');
  }

}
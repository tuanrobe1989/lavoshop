<?php
namespace MailPoetVendor\Monolog\Handler;
if (!defined('ABSPATH')) exit;
use MailPoetVendor\Monolog\ResettableInterface;
abstract class AbstractProcessingHandler extends AbstractHandler
{
 public function handle(array $record)
 {
 if (!$this->isHandling($record)) {
 return \false;
 }
 $record = $this->processRecord($record);
 $record['formatted'] = $this->getFormatter()->format($record);
 $this->write($record);
 return \false === $this->bubble;
 }
 protected abstract function write(array $record);
 protected function processRecord(array $record)
 {
 if ($this->processors) {
 foreach ($this->processors as $processor) {
 $record = \call_user_func($processor, $record);
 }
 }
 return $record;
 }
}

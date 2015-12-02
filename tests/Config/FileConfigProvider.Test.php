<?php

namespace iblamefish\baconiser\Tests\Config;

use iblamefish\baconiser\Config\FileConfigProvider;

class FileConfigProviderTest extends \PHPUnit_Framework_TestCase {
  private $invalidConfigFile = "file-not-found.php";

  private $validConfigFile = "tests/assets/config.php";

  private $invalidSimpleConfigKey = "invalidKey";

  private $invalidCompoundConfigKey = "invalid.key";

  private $simpleConfigKey = "simpleKey";

  private $simpleConfigValue = "simple value";

  private $compoundConfigKey = "compound.key";

  private $compoundConfigValue = "compound value";

  /**
   * @expectedException iblamefish\baconiser\Exception\FileNotFoundException
   */
  public function testShouldThrowIfFileNotFound() {
    $config = new FileConfigProvider($this->invalidConfigFile);
  }

  public function testShouldNotThrowIfConfigFileFound() {
    $config = new FileConfigProvider($this->validConfigFile);
  }

  /**
   * @expectedException \iblamefish\baconiser\Exception\ConfigKeyNotFoundException
   */
  public function testShouldThrowIfSimpleConfigKeyNotValid() {
    $config = new FileConfigProvider($this->validConfigFile);

    $config->get($this->invalidSimpleConfigKey);
  }

  /**
   * @expectedException \iblamefish\baconiser\Exception\ConfigKeyNotFoundException
   */
  public function testShouldThrowIfCompoundConfigKeyNotValid() {
    $config = new FileConfigProvider($this->validConfigFile);

    $config->get($this->invalidCompoundConfigKey);
  }

  public function testShouldReturnSimpleConfigItem() {
    $config = new FileConfigProvider($this->validConfigFile);

    $value = $config->get($this->simpleConfigKey);

    $this->assertEquals($this->simpleConfigValue, $value);
  }

  public function testShouldReturnCompoundConfigItem() {
    $config = new FileConfigProvider($this->validConfigFile);

    $value = $config->get($this->compoundConfigKey);

    $this->assertEquals($this->compoundConfigValue, $value);
  }
}

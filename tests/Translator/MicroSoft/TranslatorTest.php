<?php

use Chekun\Translator\MicroSoft\Translator;

class TranslatorTest extends PHPUnit_Framework_TestCase {

    public function testTranslate()
    {
        $config = include __DIR__.'/../../../src/config/api.php';
        $translator = new Translator($config['microsoft']['id'], $config['microsoft']['secret']);
        $this->assertEquals('你好', $translator->translate('Hello', 'zh-CHS'));
    }

}
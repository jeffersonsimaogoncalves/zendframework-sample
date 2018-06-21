<?php

use Zend\Paginator\ConfigProvider;

return [
    'service_manager' => (new ConfigProvider())->getDependencyConfig(),
];
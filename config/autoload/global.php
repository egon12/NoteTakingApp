<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'db' => array(
        'driver'   => 'Pdo',
        'hostname' => 'localhost',
        'database' => 'zendauth',
        'dsn'      => 'mysql:dbname=zendauth;host=localhost',
        'options'  => array('buffer_results' => true)
    ),

    'service_manager' => array(
        'factories' => array(
            // 'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
           
            'Zend\Db\Adapter\Adapter' => function ($sm) {
                $db = $sm->get('Config')['db'];

                $adapter = new BjyProfiler\Db\Adapter\ProfilingAdapter($db);

                if (php_sapi_name() == 'cli') {
                    $logger = new Zend\Log\Logger();
                    // write queries profiling info to stdout in CLI mode
                    // $writer = new Zend\Log\Writer\Stream('php://output');
                    $writer = new Zend\Log\Writer\Stream('file:///tmp/db.log');
                    $logger->addWriter($writer, Zend\Log\Logger::DEBUG);
                    $adapter->setProfiler(new BjyProfiler\Db\Profiler\LoggingProfiler($logger));
                } else {
                    $adapter->setProfiler(new BjyProfiler\Db\Profiler\Profiler());
                }
                if (isset($db['options']) && is_array($db['options'])) {
                    $options = $db['options'];
                } else {
                    $options = array();
                }
                $adapter->injectProfilingStatementPrototype($options);
                return $adapter;
            },
        ),
    ),
);

<?php

class ohMailChimpApi extends MCAPI
{

    static $instance;
    static $logger;

    /**
     *
     * @return ohMailChimpApi
     */
    static function getInstance()
    {
        if (!isset(self::$instance))
        {
            $apiKey = sfConfig::get('app_ohMailChimp_api_key');
            $class = sfConfig::get('app_ohMailChimp_class_name', 'ohMailChimpApi');
            self::$instance = new $class($apiKey);
        }
        return self::$instance;
    }

    /**
     *
     * You can log mailchimp communications to a serperate file by
     * ohMailChimpApi::setLogger(
     *   new sfFileLogger(
     *     new sfEventDispatcher,
     *     array('file'=>sfConfig::get('sf_log_dir').'/mailchimp.log')
     *   )
     * );
     *
     * @param sfLogger $logger
     */
    static function setLogger($logger = false)
    {
        self::$logger = $logger;
    }

    /**
     *
     * @return sfLogger
     */
    static function getLogger()
    {
        if (!isset(self::$logger))
        {
            self::setLogger(sfContext::getInstance()->getLogger());
        }

        return self::$logger;
    }

    /**
     * Logs a message to the logger class self::$logger
     * @param string $message
     * @param string $priority  EMERG, ALERT, CRIT, ERR, WARNING, NOTICE, INFO, DEBUG
     */
    static function log($message, $priority = 'INFO')
    {

        if (!isset(self::$logger))
        {
            self::getLogger();
        }

        self::$logger->log($message, constant("sfLogger::$priority"));
    }

    /**
     * Wraps the main MCAPI callServer method and adds some symfony logging
     * and exception handling
     * 
     * @param string $method
     * @param array $params
     * @return bool success
     */
    public function callServer($method, $params)
    {

        if (sfConfig::get('app_ohMailChimp_logging', false))
        {

            $message = 'MailChimp method: "' . $method . '" called with parameters ' . print_r($params, true);

            self::log($message);
        }

        $response = parent::callServer($method, $params);

        if (sfConfig::get('app_ohMailChimp_logging', false))
        {

            if ($response === false && $this->errorCode)
            {
                self::log($this->getErrorMessage(), 'CRIT');
            }
            else
            {
                $message = 'MailChimp response: "' . print_r($params, true) . '"';
                self::log($message, 'INFO');
            }
        }
        if ($response === false && sfConfig::get('app_ohMailChimp_throw_exception'))
        {
            throw new ohMailChimpException($this->getErrorMessage());
        }

        return $response;
    }

    public function getErrorMessage()
    {

        if (!empty($this->errorCode))
        {
            return 'MailChimp error with code "' . $this->errorCode . '": "' . $this->errorMessage . '"';
        }
    }

}

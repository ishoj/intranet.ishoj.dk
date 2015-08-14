<?php

/**
 * Extends the SoapClient class providing:
 * - custom security header, WS-Security
 * - extract SOAP envelope from multipart message
 *
 * See more at http://stackoverflow.com/questions/953639/connecting-to-ws-security-protected-web-service-with-php
 */
class WsSoapClient extends SoapClient {
  protected static $WssNamespace = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';

  protected $login;
  protected $password;

  /**
   * Constructor.
   */
  public function __construct($wsdl, $options = array()) {
    if (isset($options['login'])) {
      // Keep authentication for the WS-Security header.
      $this->login = $options['login'];
      unset($options['login']);
      $this->password = $options['password'];
      unset($options['password']);
    }
    // Forward constructor.
    parent::__construct($wsdl, $options);

    // Set the initial Soap header (will be overrided next).
    $obj_header = new SoapHeader(self::$WssNamespace, 'Security', '', FALSE);
    $this->__setSoapHeaders(array($obj_header));
  }

  /**
   * Overrided to provide custom security header.
   */
  public function __doRequest($request, $location, $action, $version, $one_way = 0) {
    $dom_request = new DOMDocument();
    $dom_request->loadXML($request);
    $xp = new DOMXPath($dom_request);
    $header = $xp->query('/SOAP-ENV:Envelope/SOAP-ENV:Header')->item(0);

    // Implement WS-Security.
    if ($this->login) {
      $security_token = $dom_request->createElementNS(self::$WssNamespace, 'wsse:Security');
      $username_token = $dom_request->createElementNS(self::$WssNamespace, 'wsse:UsernameToken');
      $username = $dom_request->createElementNS(self::$WssNamespace, 'wsse:Username', $this->login);
      $password = $dom_request->createElementNS(self::$WssNamespace, 'wsse:Password', $this->password);
      $username_token->appendChild($username);
      $username_token->appendChild($password);
      $security_token->appendChild($username_token);
      $header->appendChild($security_token);
    }

    // Do request.
    $request = $dom_request->saveXML();
    $response = parent::__doRequest($request, $location, $action, $version, $one_way);

    // Extract SOAP XML from multipart message.
    $response = $this->extractSoapEnvelope($response);
    return $response;
  }

  /**
   * Extract the SOAP message from a multipart message.
   */
  protected function extractSoapEnvelope($message) {
    $matches = array();
    $result = preg_match('#<soap:Envelope(?:\s+[^>]+)?>(.*?)</soap:Envelope>#s', $message, $matches);
    if ($result) {
      $message = '<?xml version="1.0" encoding="UTF-8"?>' . $matches[0];
    }
    return $message;
  }
}

<?php

/**
 * @file
 * Home of the FeedsSOAPFetcher and related classes.
 */

/**
 * Fetches data via SOAP.
 */
class FeedsSOAPFetcher extends FeedsFetcher {

  /**
   * Implementation of FeedsFetcher::fetch().
   */
  public function fetch(FeedsSource $source) {
    // Note: we fetch data using the Feed config instead of using the source
    // import form. The reason for this, is that does not make sense allowing
    // the user to switch the SOAP endpoint, when it requires a much more
    // complex configuration.
    $options = array('trace' => TRUE);
    if ($this->config['username']) {
      $options['login'] = $this->config['username'];
      $options['password'] = $this->config['password'];
    }
    $this->client = new WsSoapClient($this->config['endpoint'], $options);

    $args = array();
    if ($this->config['arguments']) {
      $query_str = str_replace(array("\r", "\r\n", "\n"), '&', $this->config['arguments']);
      parse_str($query_str, $args);
    }

    try {
      call_user_func(array($this->client, $this->config['function']), $args);
      $response = $this->client->__getLastResponse();
      return new FeedsFetcherResult($response);
    } catch (SoapFault $fault) {
      drupal_set_message("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", 'error');
      return;
    }    
  }

  /**
   * Override parent::configDefaults().
   */
  public function configDefaults() {
    return array(
      'endpoint' => '',
      'username' => '',
      'password' => '',
      'function' => '',
      'arguments' => '',
    );
  }
  
  /**
   * Return an array containing functions and parameters for the WSDL SOAP service
   */
  private function endpointFunctions($endpoint) {
    $result = array(
      'functions' => array()
    );
    if (!$endpoint) return $result;

    $client = new WsSoapClient($this->config['endpoint']);
    // TODO: cache this to avoid so many requests
    if ($functions = $client->__getFunctions()) {
      foreach($functions as $key => $function) {
        $matches = array();
        preg_match('/(\w+) (\w+)\(.+\)/', $function, $matches);
        if ($matches) {
          $result['functions'][$matches[2]] = $matches[0];
        }
      };
    }

    return $result;
  }

  /**
   * Override parent::configForm().
   */
  public function configForm(&$form_state) {
    $form['endpoint'] = array(
      '#type' => 'textfield',
      '#title' => t('SOAP server endpoint URL'),
      '#size' => 60,
      '#maxlength' => 256,
      '#description' => t('Enter the absolute endpoint URL of the SOAP Server service. If WSDL is being used (see SOAPFetcher settings), this will be the URL to retrieve the WSDL.'),
      '#default_value' => $this->config['endpoint'],
      '#required' => TRUE
    );

    $form['username'] = array(
      '#type' => 'textfield',
      '#title' => 'Username',
      '#default_value' => $this->config['username'],
    );

    $form['password'] = array(
      '#type' => 'textfield',
      '#title' => 'Password',
      '#default_value' => $this->config['password'],
    );

    // TODO: refresh functions after changing the endpoint (through AHAH)
    $functions = $this->endpointFunctions($this->config['endpoint']);
    $form['function'] = array(
      '#type' => 'select',
      '#title' => t('SOAP Function'),
      '#options' => $functions['functions'],
      '#default_value' => $this->config['function'],
      '#required' => (bool)$functions['functions']
    );

    // TODO: create a dynamic arguments form, related with the function chosen above (use AHA for this)
    $form['arguments'] = array(
      '#type' => 'textarea',
      '#title' => t('Arguments'),
      '#cols' => 60,
      '#rows' => 10,
      '#description' => t('Enter the arguments of the function. One argument per line, for named arguments, the format of <em>name=value</em> may be used.'),
      '#default_value' => $this->config['arguments'],
    );

    return $form;
  }

  
  /**
   * Expose source form.
   */
  public function sourceForm($source_config) {
    $form = array();
    // HACK: the hidden field is required to allow Feeds to process the import
    $form['source'] = array('#type' => 'hidden', '#value' => 'hack_to_allow_import');

    $form['info'] = array(
      '#type' => 'item',
      '#value' => t('Will import from %function at %endpoint', array('%function' => $this->config['function'], '%endpoint' => $this->config['endpoint'])),
    );
    return $form;
  }
}

<?php

/**
 * OAuthLoginResource
 *
 * @Action(name='info', controller='userInfo')
 */
class OAuthLoginResource {

  /**
   * Retrieves information about the current user
   *
   * @return object
   *
   * @Access(callback='user_access', args={'access content'}, appendArgs=false)
   */
  public static function userInfo() {
  	$req = DrupalOAuthRequest::from_request();
  	$token_key = $req->get_parameter('oauth_token');
  	$result = db_fetch_object(db_query("SELECT * FROM {oauth_common_token} WHERE token_key='%s' AND provider_token=%d", array(
      ':key' => $token_key,
      ':provider_token' => 1,
    )));
   $data = (array)user_load($result->uid);
  /*  global $user;

    $data = (array)$user;*/
    unset($data['pass']);

    return (object)$data;
  }
}
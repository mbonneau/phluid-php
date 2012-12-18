<?php

namespace Phluid\Test;
use Phluid\Http\RequestMatcher;
use Phluid\Http\Headers;

class RequestMatcherTest extends TestCase {
  
  public function testRegexCompiling(){
    $this->assertSame( "#^/user(/(?<name>[^/]+))?/?$#", RequestMatcher::compileRegex( '/user/:name?' ) );
  }
         
  public function testPathVariables(){
    $matcher = new RequestMatcher( 'GET', '/show/:person' );
    $request = $this->makeRequest( 'GET', '/show/beau' );
    $this->assertArrayHasKey( 'person', $matcher( $request ), "Route should match path" );
  }
  
  public function testSlashDelimiter(){
    $matcher = new RequestMatcher( 'GET', '/show/:person' );
    $request = $this->makeRequest( 'GET', '/show/beau/something' );
    $this->assertFalse( $matcher( $request ), "Route shouldn't match" );
  }
  
  public function testSplatRoutes(){
    $matcher = new RequestMatcher( 'GET', '/user/*' );
    $request = $this->makeRequest( 'GET', '/user/beau' );
    $this->assertArrayHasKey( 0, $matcher( $request ) );
  }
  
  public function testParamRoute(){
    $request = $this->makeRequest( 'GET', '/user/' );
    $matcher = new RequestMatcher( 'GET', '/user/:name?' );
    $this->assertArrayHasKey( 0, $matcher( $request ) );
    $matches = $matcher->matches( $this->makeRequest( 'GET', '/user/beau/' ) );
    $this->assertArrayHasKey( 'name', $matches  );
    $this->assertSame( 'beau', $matches['name'] );
  }
  
  function makeRequest( $method, $path ){
    $request = new Request( $method, $path );
    $request->method = $method;
    $request->path = $path;
    return $request;
  }
  
}
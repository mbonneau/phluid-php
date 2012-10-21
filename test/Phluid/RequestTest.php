<?php

namespace Phluid;

require_once 'test/helper.php';

class RequestTest extends \PHPUnit_Framework_TestCase {
  
  public function testPrefix(){
  
    $request = new Request('GET', '/something/other/');
    $new_request = $request->withPrefix( '/something' );
    
    $this->assertSame( '/other/', $new_request->path );
    
  }
  
  public function testAccessors(){
    
    $request = new Request( 'GET', '/' );
    
    $request->something = "Hi";
    
    $this->assertSame( "Hi", $request->something );
    
  }  
  
  public function testBody(){
    $request = new Request( 'POST', '/' );
    $request->setBody( "Hello world" );
    $this->assertSame( "Hello world", $request->getBody() );
  }
    
}
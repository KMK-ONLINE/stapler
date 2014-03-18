<?php

use Mockery as m;

class StorageS3Test extends TestCase
{

  /**
   * Teardown method.
   *
   * @return void
   */
  public function tearDown()
  {
    m::close();
  }

  /**
   * Test that attachment's options are forwarded on to S3, so one can
   * set content options expires headers etc
   *
   * @return void
   */
  public function testMoveRespectsAttachmentCacheControl()
  {
    $config = m::mock('Codesleeve\Stapler\Config', ['mockAttachment', ['preserve_files' => false, 'styles' => ['foo' => '']]])->makePartial();

    $instance = m::mock();

    $attachment = m::mock('Codesleeve\Stapler\Attachment')->makePartial();
    $attachment->setConfig($config);
    $attachment->setInstance($instance);

    $s3ClientManager = $this->app->make('S3ClientManager');

    $storage = m::mock('Codesleeve\Stapler\Storage\S3', [$attachment, $s3ClientManager])->makePartial();
    $storage->move("/doesn't matter.jpg", "s3://somewhere");

//     $attachment->shouldReceive('originalFilename')->once()->andReturn(true);
//     $attachment->shouldReceive('defaultPath')->never();
//     $attachment->setStorageDriver($storageDriver);
//
    $this->assertEquals('foo', 'bar');
  }

}

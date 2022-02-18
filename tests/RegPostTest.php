<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Post;

class RegPostTest extends TestCase
{
    public function testPostReg(): void
    {
        $post=new Post();

        $post->setUserName("用户名1");

        $this->assertSame("用户名1",$post->getUserName());
    }
}

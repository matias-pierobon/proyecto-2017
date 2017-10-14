<?php
/**
 * Created by PhpStorm.
 * User: matias
 * Date: 10/13/17
 * Time: 5:26 PM
 */

namespace Tests\Melody\Collection;

use PHPUnit\Framework\TestCase;
use Melody\Collection\Set;
use \StdClass;

class SetTest extends TestCase
{
    public function testAdd()
    {
        $set = new Set();
        $o1 = new StdClass;
        $o2 = new StdClass;
        $set->add($o1);
        $set->add($o2);

        $this->assertTrue($set->contains($o1));
        $this->assertTrue($set->contains($o2));
    }

    public function testContains()
    {
        $set = new Set();

        $o1 = new StdClass;
        $this->assertFalse($set->contains($o1));
        $set->add($o1);
        $this->assertTrue($set->contains($o1));

        $o2 = new StdClass;
        $this->assertFalse($set->contains($o2));
        $set->add($o2);
        $this->assertTrue($set->contains($o2));
    }
}
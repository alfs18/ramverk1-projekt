<?php

namespace Alfs18\User;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
// use Alfs18\User\Functions;

/**
 * Test the Functions.
 */
class FunctionsTest extends TestCase
{
    /**
     * Test the function getTagsOnce.
     */
    public function testGetTagsOnce()
    {
        $function = new Functions();
        $tagsArray = ["Frukt", "Plantor", "Bär", "Frukt"];
        $res = $function->getTagsOnce($tagsArray);

        $this->assertContains("Bär", $res);
        $this->assertIsArray($res);
        $this->assertSameSize(["Frukt", "Plantor", "Bär"], $res);
    }


    /**
     * Test the function countTagsFrequency.
     */
    public function testCountTagsFrequncy()
    {
        $function = new Functions();
        $tagsArray = ["Frukt", "Plantor", "Bär", "Frukt"];
        $res = $function->countTagsFrequency($tagsArray);

        $this->assertIsArray($res);
        $this->assertArrayHasKey("Frukt", $res);
        $this->assertArrayHasKey("Plantor", $res);
        $this->assertArrayHasKey("Bär", $res);
    }
}

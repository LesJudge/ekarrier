<?php
namespace Tests\Uniweb\Helper;

class UserRelationHelper
{
    public static function testUserRelation($testSuite, array $data, $user)
    {
        /* @var $testSuite PHPUnit_Framework_TestCase */
        /* @var $user \Uniweb\Module\User\Model\ActiveRecord\User */
        $testSuite->assertInstanceOf('\\Uniweb\\Module\\User\\Model\\ActiveRecord\\User', $user);
        $testSuite->assertEquals($data['user_vnev'], $user->user_vnev);
        $testSuite->assertEquals($data['user_knev'], $user->user_knev);
        $testSuite->assertEquals($data['user_email'], $user->user_email);
        $testSuite->assertEquals($data['user_fnev'], $user->user_fnev);
        
        $keysToCheck1 = array(
            'user_id',
            'user_fnev',
            'user_email',
            'user_vnev',
            'user_knev',
            'user_last_login'
        );
        $keysToCheck2 = array(
            'user_szum_login',
            'user_jelszo',
            'user_reg_date'
        );
        $attributes = $user->attributes();
        
        foreach ($keysToCheck1 as $key) {
            $testSuite->assertArrayHasKey($key, $attributes);
        }
        
        foreach ($keysToCheck2 as $key) {
            $testSuite->assertArrayNotHasKey($key, $attributes);
        }
    }
}
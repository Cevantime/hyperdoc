<?php


class HelloSkeletonTestCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->wantToTest('Home page');
        $I->amOnPage('/');
        $I->see('Welcome on the Sherpa skeleton !');
    }
}

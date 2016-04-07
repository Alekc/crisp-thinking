<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07/04/2016
 * Time: 10:18
 */

namespace Alekc\CrispThinking;


use Alekc\CrispThinking\Request\SubmitUgcTextRequest;

class Crisp
{
    /**
     * Gets option singleton
     *
     * @return Options
     */
    public static function getOptions(){
        return Options::getInstance();
    }

    public static function makeUgcTextRequest($text){
        $request = new SubmitUgcTextRequest();
        $request->setText($text);
        return $request;
    }

}
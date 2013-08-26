<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 23.08.13
 * Time: 18:30
 * To change this template use File | Settings | File Templates.
 */

namespace api;

use db\Db as DB;
class APIException extends \Exception
{

}

class Api
{
    protected $request;
    protected $dbh;
    protected $availableMethods = [
        'ping',
        'getCurrencies',
        'getHistory'
    ];
    protected $methodParams = [];

    public function v1()
    {
        $request = $this->getRequestBody();
        if (!$request) {
            throw new ApiException('Failed to parse request data: json is not valid');
        }
        if (!$this->isUserRegistered()) {
            throw new ApiException('Auth failed');
        }
        if (!isset($request->method)) {
            throw new ApiException('No method specified');
        }

        if (in_array($request->method, $this->availableMethods)) {
            $method = $request->method;
            if (isset($request->params)) {
                $this->setCallParams($request->params);
            }
            return $this->$method();
        } else {
            throw new ApiException('Method not found');
        }
    }

    protected function setCallParams($params)
    {
        $this->methodParams = $params;
    }

    /** @return Object */
    protected  function getRequestBody()
    {
        if ($this->request === null) {
            $this->request=file_get_contents('php://input');
        }
        return json_decode($this->request);
    }

    protected  function getMethod()
    {
        return $this->getRequestBody()->method;
    }

    protected  function isUserRegistered()
    {
        $request = $this->getRequestBody();
        if (isset($request->login) && isset($_SERVER['HTTP_X_APIKEY'])) {
            $sql = "SELECT *
                     FROM `money`.`user`
                     WHERE `login` = :login AND `apikey` =:key";
            $dbh = DB::getConnection();
            $sth = $dbh->prepare($sql);
            $sth->execute(array(':login' => $request->login, ':key' => $_SERVER['HTTP_X_APIKEY']));
            $result = $sth->fetch(\PDO::FETCH_ASSOC);
            if ($result) {
                return true;
            }
        }
        return false;
    }

    protected function ping()
    {
        return json_encode(array('pong' => 1));
    }
}
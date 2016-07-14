<?php

/**
 * Инструмент реализующий API запросы к Realtime
 *
 * Realtime Register is proxy
 *
 * <code>
 * require_once 'IsProxy.php';
 *
 * $ip = new IsProxy("customer/user", "password");
 * $ip->check('domainname', 'com');
 *
 * $result = $ip->result();
 * echo $result['domain'].' '.$result['result'];
 *
 * $ip->close();
 * </code>
 *
 * @package Shop.Helper
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.25
 */
class Shop_Helper_RealtimeRegisterTelnet
{
    private $username;

    private $password;

    private $host;

    private $port;

    /**
     * Connection
     *
     * @var     object
     */
    private $_fp;

    /**
     * Construct
     *
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     */
    function __construct($host = Shop_DomainsZone::TelnetHost, $port = Shop_DomainsZone::TelnetPort, $username = Shop_DomainsZone::TelnetLogin, $password = Shop_DomainsZone::TelnetPassword)
    {
        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Close
     *
     * @return  void
     */
    public function Logout()
    {
        $this->write('CLOSE');
        @fclose($this->_fp);
    }

    /**
     * Check
     *
     * @param   string  Domainname
     * @param   mixed   TLD(s)
     * @return  void
     */
    public function Check($domainname, $tlds)
    {
        if ( !is_array($tlds) )
        {
            $tlds = (array)$tlds;
        }

        foreach ($tlds as $tld)
        {
            if ( substr($tld, 0, 1) != '.' )
                $tld = '.' . $tld;
            $this->write('IS ' . $domainname . $tld);
        }
    }

    /**
     * Result
     *
     * @return  array   [ domain, result ]
     */
    public function Result()
    {
        $response = $this->read();
        if ( preg_match('#^([\-\w.]+)\s(available|not\savailable|invalid\sdomain|error)#', $response, $match) )
        {
            return array('domain' => $match[1], 'result' => $match[2]);
        }

        return array('domain' => '-', 'result' => 'error');
    }

    /**
     * Is connected?
     *
     * @return  bool    Connection?
     */
    public function Is_connected()
    {
        return is_resource($this->_fp);
    }

    /**
     * Login
     *
     * @return  bool    Login successfull?
     */
    public function Login()
    {
        $this->_fp = @fsockopen($this->host, $this->port, $errno, $errstr, 10);
        if ( !is_resource($this->_fp) )
        {
            return false;
        }
        if ( !$this->write('LOGIN ' . $this->username . ' ' . $this->password) )
        {
            return false;
        }
        $response = $this->read();
        if ( preg_match('#^400\sLogin\sfailed#', $response) )
        {
            return false;
        }
        return preg_match('#^100\sLogin\sok#', $response);
    }

    /**
     * Read
     *
     * @return  string  Response
     */
    private function read()
    {
        if ( !$this->Is_connected() )
        {
            if ( false == $this->Login() )
                return false;
        }
        if ( !$response = fgets($this->_fp, 1024) )
        {
            return false;
        }
        return trim($response);
    }

    /**
     * Write
     *
     * @param   string $message
     * @return  bool    Writing successfull?
     */
    private function write($message)
    {
        if ( !$this->Is_connected() )
        {
            if ( false == $this->Login() )
                return false;
        }
        return @fputs($this->_fp, $message . "\r\n");
    }
}

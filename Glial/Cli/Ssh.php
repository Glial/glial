<?php

namespace Glial\Cli;

class Ssh
{

    // SSH Host 
    private $ssh_host;
    // SSH Port 
    private $ssh_port;
    // SSH Server Fingerprint 
    private $ssh_server_fp = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    // SSH Username 
    private $ssh_auth_user;
    // SSH Private Key Passphrase (null == no passphrase) 
    private $ssh_auth_pass;
    // SSH Public Key File 
    private $ssh_auth_pub = '/home/username/.ssh/id_rsa.pub';
    // SSH Private Key File 
    private $ssh_auth_priv = '/home/username/.ssh/id_rsa';
    // SSH Connection 
    private $connection;

    static public function testAccount($host, $port, $login, $password)
    {
        $connection = ssh2_connect($host, $port);

        if (ssh2_auth_password($connection, $login, $password)) {
            return true;
        } else {
            return false;
        }
    }

    public function __construct($host, $port, $login, $password)
    {
        $this->ssh_host = $host;
        $this->ssh_port = $port;
        $this->ssh_auth_user = $login;
        $this->ssh_auth_pass = $password;
    }

    public function connect()
    {
        if (!($this->connection = ssh2_connect($this->ssh_host, $this->ssh_port))) {
            throw new Exception('Cannot connect to server');
        }
        
        /*
        $fingerprint = ssh2_fingerprint($this->connection, SSH2_FINGERPRINT_MD5 | SSH2_FINGERPRINT_HEX);
        
        if (strcmp($this->ssh_server_fp, $fingerprint) !== 0) {
            throw new Exception('Unable to verify server identity!');
        }*/
        
        /*
        if (!ssh2_auth_pubkey_file($this->connection, $this->ssh_auth_user, $this->ssh_auth_pub, $this->ssh_auth_priv, $this->ssh_auth_pass)) {
            throw new Exception('Autentication rejected by server');
        }*/
        
        
        if (! ssh2_auth_password($this->connection, $this->ssh_auth_user, $this->ssh_auth_pass)) {
            return false;
        }
        
        
        
    }

    public function exec($cmd)
    {
        if (!($stream = ssh2_exec($this->connection, $cmd))) {
            throw new Exception('SSH command failed');
        }
        stream_set_blocking($stream, true);
        $data = "";
        while ($buf = fread($stream, 4096)) {
            $data .= $buf;
        }
        fclose($stream);
        return $data;
    }

    public function disconnect()
    {
        $this->exec('echo "EXITING" && exit;');
        $this->connection = null;
    }

    public function __destruct()
    {
        $this->disconnect();
    }

}
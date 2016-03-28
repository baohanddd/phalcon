<?php
namespace Bob\Phalcon;

class Password
{
    /**
     * Hash string
	 *
     * @param string $string
     * @return string
     */
	public function generate($string)
	{
		$option = array('salt' => '+A{Wx|{#lX$=<z[-ZMUmfE>^qd/b7-Z2|[B*G?V_bMwM}/(lYS.wyTxT){|X]T}b', 'cost' => 9);
	    return password_hash($string, PASSWORD_DEFAULT, $option);
	}
	
	/**
	 * Verified hashed string
	 *
	 * @param string $string
	 * @param string $hash
	 * @return boolean
	 */
	public function verify($string, $hash) 
	{
	    return password_verify($string, $hash);
	}
}
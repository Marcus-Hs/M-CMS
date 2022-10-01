<?php
class syntax {
	public static function http($http) {
		global $vorgaben;
		$vorgaben['skip_err'] = 1;
		$domain = trim(url_protocol($http,false),'/');
		if (strpos($domain,'/')!==false)	$domain = startstr($domain,'/');
		if(!preg_match('/^(([_a-züöäß0-9-]+)\\.)+([a-z]){2,6}$/i' ,$domain) )								return false;
		elseif (syntax::newlines($domain))																	return false;
		elseif (!$vorgaben['localhost']) {
			if(fsockopen($domain,80,$errno,$errstr,30) || fsockopen('www.'.$domain,80,$errno,$errstr,30))	return true;
			else																							return false;
		} else																								return true;
	}
	public static function subdomain($http) {
		$domain = str_remove($http,'http://');
		$domain_parts = explode('.',$domain);
		$subdomain_parts = explode('-',$domain_parts[0]);
		if (count($subdomain_parts)>1)	return false;
		else 							return true;
	}
	public static function email($email) {
		global $vorgaben;
		$vorgaben['skip_err'] = 1;
		if(!is_string($email) || !preg_match('/^[_a-z0-9-]+(\\.[_a-z0-9-]+)*@(([_a-züöäß0-9-]+)\\.)+([a-z]){2,6}$/i' ,$email) || syntax::headers($email))	return false;
		if (strpos_arr($email,array('no-reply', 'noreply', 'mail.ru','yandex.ru')))																													return false;
		list($username,$domain)=explode('@',$email);
		if($vorgaben['localhost'] || syntax::myCheckDNSRR($domain) || fsockopen($domain,80,$errno,$errstr,30) && fsockopen('www.'.$domain,80,$errno,$errstr,30))	return true;
		else																																						return false;
	}
	public static function myCheckDNSRR($hostName, $recType = 'MX') {
		if(!empty($hostName)) {
			if (function_exists('checkdnsrr')) {
				if (checkdnsrr($hostName.'.', $recType)) 	return true;
			} else {
				exec("nslookup -type=$recType $hostName", $result);
				foreach ($result as $line) {								// check each line to find the one that starts with the host name.
					if(eregi("^$hostName",$line))			return true;	// If it exists then the function succeeded.
		}	}	}
		return false;														// otherwise there was no mail handler for the domain
	}
	public static function has_zip($data) {
		$x = filter_address($data,false,false);
		if (!empty($x))		return true;
		else				return false;
	}
	public static function has_nbr($data,$just_nbr=false) {
		$x = filter_address($data,true,true,false,$just_nbr);
		if (!empty($x))		return true;
		else				return false;
	}
	public static function name($name) {
		if(syntax::number($name) || !syntax::string($name))	return false;
		else												return true;
	}
	public static function string($name) {
		if(!is_string($name) || syntax::newlines($name))	return false;
		else												return true;
	}
	public static function number($number) {
		if(!is_string($number) || !preg_match("/^[0-9\/\.\,\:\;\-\+\(\) ]{1,64}$/Ui" ,$number) || syntax::newlines($number))	return false;
		else																													return true;
	}
	public static function msg($text) {
		if (preg_match('/http|www/i',$text))			return false;
		else											return true;
	}
	public static function newlines($text) {
		if (preg_match("/(%0A|%0D|\n+|\r+)/i", $text))	return true;
		else											return false;
	}
	public static function headers($text) {
		if (preg_match("/(%0A|%0D|\n+|\r+)(content-type:|to:|cc:|bcc:)/i", $text))	return true;
		else																		return false;
}	}
/** Generate cryptographic Hashes for passwords
 *
 * Features:
 * 	Harderned against precomputation attacks like rainbow tables (using unique salts)
 * 	Harderned against brute force and dictionary attacks (using key stretching and optional secret key)
 *
 *  http://en.wikipedia.org/wiki/Password_cracking
 *
 * @author gabe@fijiwebdesign.com
 * @link http://www.fijiwebdesign.com/
 * @version $Id$
*/
class Password_Hash {
/**	Verify a password meets a hash
 *	@return Bool
 *	@param $password String, @param $hash String, @param $secret String[optional]
*/
	public static function verify($password, $hash, $secret = 'Webdesign Haas rules!') {
		list($_hash, $iterations, $hash_function, $salt) = explode(':', $hash);
		return ($hash == self::generate($password, $salt, $iterations, $hash_function, $secret));
	}
/**	Generate the Hash
 *	@return String
 *	@param $password String, @param $salt String[optional], @param $iterations Int[optional], @param $secret String[optional]
*/
	public static function generate($password, $salt = null, $iterations = 10000, $hash_function = 'sha1', $secret = 'Webdesign Haas rules!') {
		$salt or $salt = self::generateToken();
		$hashes = array();
		$hash = str_replace(array('\"',"\''"),array('"',"''"),$password);
		for( $i = 0; $i < $iterations; ++$i ) {				// each hash depends on the last one,
			$hash = $hash_function($hash.$salt.$secret);	// so any implementation must hash each one individually
		}
		return implode(':', array($hash, $iterations, $hash_function, $salt));
	}
/**	Generate a random hex based token
 *	@return String
 *	@param $length Int[optional]
*/
	public static function generateToken($length = 40) {
		$token = array();
		for( $i = 0; $i < $length; ++$i ) {
			$token[] =	dechex( mt_rand(0, 15) );
		}
		return implode('', $token);
}	}
class mb_preg {
	public static function match_all($pattern, $subject, &$matches, $flags = PREG_PATTERN_ORDER, $offset = 0, $encoding = null) {
//		Multibyte analogue of preg_match_all() function
//		@author chuckie
//		@link http://www.php.net/manual/en/function.preg-match-all.php#71572
		if(is_null($encoding))	$encoding = mb_internal_encoding();
		$offset = strlen(mb_substr(r_implode($subject), 0, $offset, $encoding));
		$ret = preg_match_all($pattern, r_implode($subject), $matches, $flags, $offset);
		$matches[0] = array_unique($matches[0]);
		$matches[1] = array_unique($matches[1]);
		if($ret && ($flags & PREG_OFFSET_CAPTURE))
		foreach($matches as &$ha_match) {
			foreach($ha_match as &$ha_match) {
				$ha_match[1] = mb_strlen(mb_substr($subject, 0, $ha_match[1]), $encoding);
		}	}
		return $ret;
	}
	public static function match($pattern, $subject, &$matches, $flags = null, $offset = 0, $encoding = null) {
//		Multibyte analogue of preg_match() function
//		@author chuckie
//		@link http://php.nusa.net.id/manual/en/function.preg-match.php#71571
		if(is_null($encoding))	$encoding = mb_internal_encoding();
		$offset = strlen(mb_substr($subject, 0, $offset, $encoding));
		$result = preg_match($pattern, $subject, $matches, $flags, $offset);
		if($result && ($flags & PREG_OFFSET_CAPTURE)) {
			foreach($matches as &$ha_subpattern) {
				$ha_subpattern[1] = mb_strlen(substr($subject, 0, $ha_subpattern[1]), $encoding);
		}	}
		return $result;
	}
	public static function str_split($str, $length = 1, $encoding = null) {
//		Multibyte analogue of str_split() function (with htmlentities addition)
		if($length < 1) 		return false;
		if(is_null($encoding))	$encoding = mb_internal_encoding();
		$result = array();
		$space_key = null;
		for($i = 0, $c = mb_strlen($str, $encoding); $i < $c; $i += $length) {
			$result[] = my_htmlentities(mb_substr($str, $i, $length, $encoding), $encoding);
		}
		return $result;
}	}
class Math {
	/* stereofrog	Apr 24, 2008, 06:41, http://www.sitepoint.com/forums/php-34/math-based-string-545041.html */
	/* usage:		echo Math::calc('10 * (5 - 3) / (1 + 1)'); */
	public static function calc($s) {
		Math::tokenize($s);
		return Math::expr();
	}
	public static function tokenize($s) {
		global $toks;
		preg_match_all('~[+*/%()-]|[^\s+*/%()-]+~', $s, $m);
		$toks = $m[0];
	}
	private static function expr() {
		$v = Math::term();
		while(Math::getsym() == '+' || Math::getsym() == '-' || Math::getsym() == '%') $v = Math::operator($v, Math::eatsym(), Math::term());
		return $v;
	}
	private static function term() {
		$v = Math::factor();
		while(Math::getsym() == '*' || Math::getsym() == '/') $v = Math::operator($v, Math::eatsym(), Math::factor());
		return $v;
	}
	private static function factor() {
		$t = Math::eatsym();
		if(is_numeric($t))				return floatval($t);
		if($t == '(') {
			$v = Math::expr();
			if(Math::eatsym() == ')')	return $v;
		}
		user_error("Math: syntax error");
	}
	private static function getsym() {
		global $toks;
		return count($toks) ? $toks[0] : null;
	}
	private static function eatsym()	{
		global $toks;
		return array_shift($toks);
	}
	private static function operator($le, $op, $ri) {
		switch($op) {
			case '+': return $le + $ri;
			case '-': return $le - $ri;
			case '*': return $le * $ri;
			case '/': if (!empty($ri))return $le / $ri;
			case '%': if (!empty($ri))return $le % $ri;
		}
		return 0;
	}
}
class ftpconnection {
	private $host;
	private $controlconnection;
	public function __construct($host,$username,$password) {
		$this->conn_id = ftp_connect($host); 											// set up basic connection
		if ((!$this->conn_id) || !is_resource($this->conn_id))	return false;
		else	$login_result = ftp_login($this->conn_id, $username, $password); 		// login with username and password
		if (!$login_result)										return false;			// check connection
		else 													return true;
	}
	public function __destruct() {
		if (is_resource($this->conn_id))	ftp_close($this->conn_id); 					// close the FTP stream
	}
	public function ls($dir='.',$match='') {
		$list = ftp_nlist($this->conn_id, $dir);										// get file list
		if (!$list) 					return false;
		elseif(empty($match))			return $list;									// return file array
		else {
			while($file = current($list)) {
				if(strpos($file, $match)!==false)	$filtered[] = $file;				//if this file matches the pattern
				$file = next($list);
			}
			if (!empty($filtered[0]))	return $filtered;								// return found.
			else						return false;
	}	}
	public function delete($remote_file) {
		if (ftp_delete($this->conn_id, $remote_file))	return true;					// check status
		else 											return false;
	}
	public function upload($destination_file,$source_file) {
		$upload = ftp_put($this->conn_id, $destination_file, $source_file, FTP_BINARY); // upload the file
		if (!$upload)   return false;													// check upload status
		else 			return true;
	}
	public function download($local_file,$remote_file) {
		$result = false;
		if ($this->is_file($remote_file)) {
			$handle = fopen($local_file, 'w');											// open some file
			if (ftp_fget($this->conn_id, $handle, $remote_file, FTP_ASCII))			// try to download $file
				$result = true;
			fclose($handle);
		}
		return $result;
	}
	public function is_file($remote_file) {
		if (ftp_size($this->conn_id, $remote_file) != -1) return true;					// this is ovious
		else											  return false;
	}
	public function filecollect($dir='.') {												// returns a list of files (hopefully)
		static $flist=array();
		if ($files = ftp_nlist($this->conn_id,$dir)){
			foreach ($files as $file) {
				if (ftp_size($this->conn_id, $file) == "-1")	filecollect($this->conn_id,$file);
				else $flist[] = $file;
			}
			return $flist;
		} else return false;
}	}
?>
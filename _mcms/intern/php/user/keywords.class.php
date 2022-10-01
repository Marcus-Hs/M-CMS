<?php
function keywords($data='') {
	global $sub_tpl;
	if (empty($sub_tpl['keywords'])) $sub_tpl['keywords'] = KeywordsGenerator::generateKeywords($data);
	return $sub_tpl['keywords'];
}
/**
 * Static KeywordsGenerator Class to generate keywords from whereever you need.
 * Returns a lowercase string with keywords ordered by occurance in content seperated with comma's
 * Use KeywordsGenerator::generateKeywords($string);
 *
 * @Author Martijn van Nieuwenhoven, Marcus Haas
 * @Email info@axyrmedia.nl, kontakt@webdesign-haas.de
 */
class KeywordsGenerator {
	/**
	 * Extract Keywords
	 * Returns a lowercase string with keywords ordered by occurance in content seperated with comma's
	 * @var $string
	 * @var $min_word_char
	 * @var $keyword_amount
	 * @var $exclude_words
	 */
	public static function generateKeywords($string = '', $min_word_char = 4, $keyword_amount = 15){
		return self::calculateKeywords($string,$min_word_char,$keyword_amount);
	}
	private static function calculateKeywords($string,$min_word_char,$keyword_amount) {
		global $sub_tpl;
		$string = '';
		if (!empty($sub_tpl['text'])) 			$string .= $sub_tpl['text'];
		if (!empty($sub_tpl['description']))	$string .= str_repeat(' '.$sub_tpl['description'],3);
		if (!empty($sub_tpl['pagetitle'])) 		$string .= str_repeat(' '.$sub_tpl['pagetitle'],5);
		$exclude_words = array("all", "also", "am", "amount", "an", "and", "any", "are",
						"as", "ask", "at", "be", "became", "because", "become", "been",
						"before", "began", "begin", "behind", "being", "belong", "below", "beside", "between", "beyond", "big", "body",
						"busy", "but", "buy", "by", "call", "came", "can",
						"cause", "choose", "contain", "continue", "could", "cry", "cut", "dare", "dark",
						"did", "do", "does",
						"either", "else",
						"find", "fit", "fly", "follow", "for", "forget", "from", "front", "get",
						"gives", "got", "had", "has", "hat", "have",
						"he", "her", "hers", "him", "his", "I",
						"if", "ill", "in", "into", "is", "it", "its",
						"me",
						"mine", "my", "no", "none", "nor", "not",
						"of", "off", "oh", "on", "or", "our",
						"self", "she", "so",
						"than", "that", "the", "their", "them", "then", "there", "therefore", "these", "they", "this", "those", "to",
						"too", "two", "us", "was", "we", "went", "were", "what", "when", "where", "whether",
						"which", "while", "who", "whom", "whose", "why", "will", "with", "within", "without", "would", "yes", "yet", "you", "your",

						'sowie','dieser','ihrer','ihre','deine','unsere','oder','ohne','aber','alles','und','über','bei','wenn','einer','email','e-mail','einem','sowie','werden','ist','das','dass','sonstiges','haben',
						'vieles','mehr','weniger','gegen','haben','ihnen','auf','an','in', 'eine', 'willkommen', 'herzlich', 'home',
						'nicht','hatte','konnte','wieder, waren','schon','einen','keine','nicht','nichts','jetzt','etwas','wir','uns','du','er','sie','die','aus','der','des','das',
						'%code_raw%');
		$string = preg_replace("/\$(\S_+)\$/", '',$string);
		if (!empty($sub_tpl['keywordsprefix'])) {
			$string .= str_replace(array(', ',',',' - '),'|',str_repeat('|'.$sub_tpl['keywordsprefix'],4));
		}
		make_replacements($string);
		$string = preg_replace('/\<br(\s*)?\/?\>/i',' ',$string);		//remove br tags.
		$string = str_replace('/','-',$string);
		$string = preg_replace('/\d{2,}/','',$string);
		$string = str_replace(array("\n","\r","\t",", ",".",":","!","?"," - "," ",'"',"(",")"), "|", $string);
		$string = html_entity_decode(strip_tags($string)); 	// get rid off all tags
		$new_string = strtolower($string);
		$words_array = explode('|',preg_replace("/(#|$|§|$)([a-z_0-9]{2,}.+)(#|$|§|$)/Usi",'',$new_string));
		$words_array = array_count_values(array_values(array_filter($words_array,
				function($var) use( &$min_word_char, &$exclude_words) {
					trim($var);
					if (strlen($var) >= $min_word_char && $var != $exclude_words) 
						return $var;}
			)));
		arsort($words_array);		// sort array form higher to lower
		return  implode(', ',array_slice(array_keys($words_array), 0, $keyword_amount));		// glue keywords to string
}	}
?>
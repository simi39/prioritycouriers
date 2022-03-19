<?php

class RStd
{
	/**
	 * Decode string in html content
	 * @param string $Input the string to be decode
	 * @return string
	 */
	public function HtmlDecode($Input)
	{
		$TransTable = get_html_translation_table(HTML_ENTITIES);
   		$TransTable = array_flip($TransTable);
   		return strtr($Input, $TransTable);
	}

	/**
	 * Encode html content string to string
	 * @param string $Input the string to be encode
	 * @return string
	 */
	public function HtmlEncode($Input)
	{
		$TransTable = get_html_translation_table(HTML_ENTITIES);
		return strtr($Input, $TransTable);
	}
}

?>
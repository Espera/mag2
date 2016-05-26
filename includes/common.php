<?php

	function truncate_print_r( $input ) {
		$output = str_replace('    ', '  ', $input);
		$output = preg_replace('/Array\n[\s]*\(\n/', "Array(\n", $output);
		$output = preg_replace('/Array\(\n[\s]*\)/', 'Array()', $output);
		$output = preg_replace('/\)\n\n/', ")\n", $output);
		return $output;
	}

	function printr( $var ) {
		echo '<hr><pre style="border: 1px dashed #F0F; font-family: Courier New; font-weight: bold; font-size: 14px; background: #FFF; color:#333333; text-align: left !important;">'.truncate_print_r(print_r( $var, true )).'</pre><hr>'."\r\n";
	}


	function getURLInformation( $uri = array() ) {

		$uri['protocol'] = isset( $_SERVER['HTTPS'] ) && ( $_SERVER['HTTPS'] == 'on' ) ? 'https': 'http';

		$uri['domain'] = $_SERVER['HTTP_HOST'];
		$uri['host'] = $uri['domain'];

		return $uri;
	}


	function _parse_url( $url ) {

		if ( ( $out = @parse_url( $url ) ) === false ) {

			$out = array();
			$query = "";

			if ( count( $parts = explode( "?", $url ) ) > 1 ) {
				$url = array_shift( $parts );
				$query = implode( "?", $parts );
			}

			if ( count( $parts = explode( "://", $url ) ) > 1 ) {

				if ( preg_match( '#([^A-Za-z0-9+-\.]+)#', $parts[ 0 ] ) == 0 ) {

					$out['scheme'] = array_shift( $parts );
					$url = implode( "://", $parts );

					$parts = explode( "/", $url );

					$out['host'] = array_shift( $parts );
					$url = count( $parts ) > 0 ? "/".implode( "/", $parts ) : "";

					$parts = explode( "@", $out['host'] );
					$out['host'] = array_pop( $parts );

					if ( count( $p = explode( ":", $out['host'] ) ) > 1 ) {
						$out['host'] = array_pop( $p );
						$parts = $p;
					}

					if ( ( $parts = implode( "@", $parts ) ) !== "" ) {
						$parts = explode( ":", $parts );
						$out['user'] = array_shift( $parts );
						if ( $out['user'] === "" ) {
							unset( $out['user'] );
						}

						if ( $parts = implode( ":", $parts ) ) {
							$out['pass'] = $parts;
						}
					}
				} else {
					$url = implode( "://", $parts );
				}
			}

			if ( $url !== "" ) {
				$out['path'] = $url;
			}

			if ( $query !== "" ) {
				$parts = explode( "#", $query );
				$out['query'] = array_shift( $parts );

				if ( count( $parts ) > 0 ) {
					$out['fragment'] = implode( "#", $parts );
				}
			}

		}

		return $out;
	}


	function parse_uri( $url = null ) {

		$uri = _parse_url( $url == null ? $_SERVER['REQUEST_URI'] : $url );

		$query = isset( $uri['query'] ) ? "?".$uri['query'] : "";
		$uri = rawurldecode( isset( $uri['path'] ) ? $uri['path'] : '/' );

		$uri = preg_replace( "#^"._LINK_PATH."#iu", "/", $uri );

		if ( preg_match( '#^([/]?)([^/]+)/((.*)/)$#', $uri, $out ) == 0 )
			if ( preg_match( '#^([/]?)([^/]+)/((.*))$#', $uri, $out ) == 0 )
				if ( preg_match( '#^(/())/((.*)/)$#', $uri, $out ) == 0 )
					if ( preg_match( '#^(/())/((.*))$#', $uri, $out ) == 0 )
						preg_match( '#^(/)(.*)(())$#', $uri, $out );

		if ( count( $out ) == 0 ) {
			$result = array(
				'module' => '',
				'params' => '',
				'uri' => $query,
				'list' => array()
			);
		} else {
			$result = array(
				'module' => $out[ 2 ],
				'params' => $out[ 4 ],
				'uri' => $out[ 1 ].$out[ 3 ].$query,
				'list' => explode( '/', $out[ 4 ] )
			);
		}

		return getURLInformation( $result );
	}


	function NFD2Chars( $value ) {
		$convmap = array( 0x80, 0xFFFF, 0, 0xFFFF );
		return mb_decode_numericentity(
					preg_replace( '/(\\\\u([ABCDEF0-9]{2})([ABCDEF0-9]{2}))/ise', '"&#".(0x\\2\\3).";"', $value ),
						$convmap, 'UTF-8');
	}


	if ( !function_exists( 'json_encode' ) ) {
		function json_encode( $value, $options = 0 ) {

			if ( is_int( $value ) ) {

				return (string)$value;

			} elseif ( is_string( $value ) ) {

				$value = str_replace( array( '\\', '/', '"', "\r", "\n", "\b", "\f", "\t" ),
										array( '\\\\', '\/', '\"', '\r', '\n', '\b', '\f', '\t' ), $value );

				$convmap = array( 0x80, 0xFFFF, 0, 0xFFFF );

				$result = "";

				for ( $i = mb_strlen( $value ) - 1; $i >= 0; $i-- ) {
					$mb_char = mb_substr( $value, $i, 1 );
					if ( mb_ereg( "&#(\\d+);", mb_encode_numericentity( $mb_char, $convmap, "UTF-8" ), $match ) ) {
						$result = sprintf( "\\u%04x", $match[1] ).$result;
					} else {
						$result = $mb_char.$result;
					}
				}

				return '"'.$result.'"';

			} elseif ( is_float( $value ) ) {

				return str_replace( ",", ".", $value );

			} elseif ( is_null( $value ) ) {

				return 'null';

			} elseif ( is_bool( $value ) ) {

				return $value ? 'true' : 'false';

			} elseif ( is_array( $value ) ) {

				$with_keys = false;
				$n = count( $value );

				for ( $i = 0, reset( $value ); $i < $n; $i++, next( $value ) ) {
					if ( key( $value ) !== $i ) {
						$with_keys = true;
						break;
					}
				}

			} elseif ( is_object( $value ) ) {

				$with_keys = true;

			} else {

	            return '';
			}

			$result = array();

			if ( $with_keys ) {

				foreach ( $value as $key => $v ) {
					$result[] = json_encode( (string)$key ).':'.json_encode( $v );
				}
				return '{'.implode( ',', $result ).'}';

			} else {

				foreach ( $value as $key => $v ) {
					$result[] = json_encode( $v );
				}
				return '['.implode( ',', $result ).']';
			}
		}
	}


	if ( !function_exists( 'json_decode' ) ) {

		function _complete_json_decode( $data ) {

			if ( is_array( $data ) ) {

				$out = array();

				foreach( $data as $key => $value ) {
					$out[ _complete_json_decode( $key ) ] = _complete_json_decode( $value );
				}

				return $out;
			} else {
				return str_replace( array( '\t', '\f', '\b', '\n', '\r', '\"', '\/', '\\\\'),
										array( "\t", "\f", "\b", "\n", "\r", '"', '/', '\\'), NFD2Chars( $data ) );
			}
		}

		function json_decode( $json, $assoc = false, $depth = 512, $options = 0 ) {

			if ( !isset( $json ) || !$json ) {
				return null;
			}

			$json = substr( $json, 1, -1 );

			$json = str_replace(
						array( ":", "{", "[", "}", "]" ),
						array( "=>", "array(", "array(", ")", ")" ), $json );

			@eval( "\$json_array = array( {$json} );" );

			return _complete_json_decode( $json_array );
		}
	}

?>
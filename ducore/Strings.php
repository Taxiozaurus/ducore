<?php

/**
 * Utility class for working with strings
 *
 * @author Taxiozaurus
 */
class Strings {

	protected static $_mime = ["audio/aac", "application/x-abiword", "application/octet-stream", "video/x-msvideo", "application/vnd.amazon.ebook", "application/octet-stream", "application/x-bzip", "application/x-bzip2", "application/x-csh", "text/css", "text/csv", "application/msword", "application/vnd.ms-fontobject", "application/epub+zip", "image/gif", "text/html", "image/x-icon", "text/calendar", "application/java-archive", "image/jpeg", "application/javascript", "application/json", "audio/midi", "video/mpeg", "application/vnd.apple.installer+xml", "application/vnd.oasis.opendocument.presentation", "application/vnd.oasis.opendocument.spreadsheet", "application/vnd.oasis.opendocument.text", "audio/ogg", "video/ogg", "application/ogg", "font/otf", "image/png", "application/pdf", "application/vnd.ms-powerpoint", "application/x-rar-compressed", "application/rtf", "application/x-sh", "image/svg+xml", "application/x-shockwave-flash", "application/x-tar", "image/tiff", "application/typescript", "font/ttf", "application/vnd.visio", "audio/x-wav", "audio/webm", "video/webm", "image/webp", "font/woff", "font/woff2", "application/xhtml+xml", "application/vnd.ms-excel↵    application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/xml", "application/zip", "video/3gpp", "audio/3gpp", "video/3gpp2", "audio/3gpp2", "application/x-7z-compressed"];

	/**
	 * Sanitize a string
	 *
	 * @param string $str
	 * @return string|null
	 * @author Taxiozaurus
	 */
	public static function sanitize(string $str): ?string {
		return htmlspecialchars($str);
	}

	/**
	 * Check if passed mime type is known
	 *
	 * @param string $mime
	 * @return bool
	 * @author Taxiozaurus
	 */
	public static function checkMime(string $mime): bool {
		return in_array($mime, static::$_mime);
	}

	/**
	 * Removes all whitespaces from a string
	 *
	 * @param string $str
	 * @return string
	 * @author Taxiozaurus
	 */
	public static function removeSpaces(string $str): string {
		return preg_replace('/\s/', '', $str);
	}
}
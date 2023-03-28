<?php
function include_file($main_url = null, $file_map = null , $error_url = '/php_learning/all_solid/home') {
    $request_uri = $_SERVER['REQUEST_URI'];
    if (substr($request_uri, -1) === '/') {
        // Redirect to the same URL without the trailing slash
        $redirect_url = rtrim($request_uri, '/');
        header("Location: $redirect_url");
        exit;
    }
    $url_parts = explode('/', $request_uri);
    // Find the position of the main URL in the URL parts
    $main_url_pos = array_search($main_url, $url_parts);
    if ($main_url_pos === false) {
        // Main URL not found in request URI
        $error = true;
    } else {
        // Get the additional path component(s) after the main URL
        $path = implode('/', array_slice($url_parts, $main_url_pos + 1));
        // Remove any trailing slashes from the path component
        $path = rtrim($path, '/');

        // Look up the file path based on the path component
        $file_path = $file_map[$path] ?? null;
        if ($file_path !== null) {
            // File found - include it
            include $file_path;
            return;
        } else {
            // No matching file found for the given path component
            $error = true;
        }
    }
    // Handle the error by redirecting to the error URL
    if ($error) {
        header("Location: $error_url");
        exit;
    }
}
